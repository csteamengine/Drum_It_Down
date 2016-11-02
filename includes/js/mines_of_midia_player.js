var songId = 0;
var songs = [$('#song_file').val()];
var player;
var drumTrack = 9;

if (typeof (console) === "undefined") var console = {
    log: function () {
    }
};

var handleNote = {
    35: kick,      // Bass Drum 2
    36: kick,      // Bass Drum 1
    37: undefined, // Side Stick/Rimshot
    38: snare_hit, // Snare Drum 1
    39: undefined, // Hand Clap
    40: snare_hit, // Snare Drum 2
    41: floorTom,  // Low Tom 2
    42: hiHat,     // Closed Hi-hat
    43: floorTom,  // Low Tom 1
    44: hiHat,     // Pedal Hi-hat
    45: rightTom,  // Mid Tom 2
    46: hiHat,     // Open Hi-hat
    47: rightTom,  // Mid Tom 1
    48: leftTom,   // High Tom 2
    49: crash_hit, // Crash Cymbal 1
    50: leftTom,   // High Tom 1
    51: crash_hit, // Ride Cymbal 1
    52: crash_hit, // Chinese Cymbal
    53: crash_hit, // Ride Bell
    54: undefined, // Tambourine
    55: crash_hit, // Splash Cymbal
    56: undefined, // Cowbell
    57: crash_hit  // Crash Cymbal 2
};

// Toggle between Pause and Play modes.
var pausePlayStop = function (stop) {
    var d = document.getElementById("pausePlayStop");
    if (stop) {
        MIDI.Player.stop();
        d.src = "/includes/images/play.png";
    } else if (MIDI.Player.playing) {
        d.src = "/includes/images/play.png";
        MIDI.Player.pause(true);
    } else {
        d.src = "/includes/images/pause.png";
        MIDI.Player.resume();
    }
};

//noinspection JSUnusedLocalSymbols
eventjs.add(window, "load", function (event) {
    if (songs.length == 1 && songs[0] == "") {
        // TODO: Redirect the page to somewhere the user can select a song
        // For now, I'm going to put a default song in there for testing...
        songs[0] = "Take_The_Money_And_Run_Steve_Miller_Band_Greatest_Hits_1974-78_1.mid";
    }

    /// Show a loading image while everything is loading up
    MIDI.loader = new sketch.ui.Timer;

    /// Load the MIDI plugin to play music
    MIDI.loadPlugin({
        soundfontUrl: "/includes/soundfonts/",
        instrument: "synth_drum",
        onprogress: function (state, progress) {
            // update the MIDI loader progress graphic as it loads
            MIDI.loader.setValue(progress * 100);
        },
        onsuccess: function () {
            player = MIDI.Player;
            player.timeWarp = 1; // speed the song is played back
            player.loadFile("/midi_files/" + songs[songId], onSuccessfulSongLoad);
            $('#loading').show();

            /// Handle note events
            player.addListener(function (data) {
                // We only care about "note on" messages in the drum track between notes 35-57
                if (data.message === 144
                    && data.channel == drumTrack
                    && data.note >= 35 && data.note <= 57
                    && handleNote[data.note] != undefined) {
                    handleNote[data.note]();
                }
            });

            /// Show the player progress bar
            MIDIPlayerPercentage(player);
        }
    });

    /// Load the MidiFile for parsing as staff music
    parse_midi(songs[songId], songs[songId], function(midiFile) {
        console.log(songs[songId]);
        console.log(midiFile);
        initMusicStaff(midiFile);
    });
});
var lower = false;
var higher = false;
var tempo_found = false;
var onSuccessfulSongLoad = function (onsuccess) {
    //The following adjusts the timeWarp to match it as close to the spotify songs duration as possible.
    var time_goal = parseInt($('#duration').val());
    if(player.endTime < time_goal){
        lower = true;
        if(!higher){
            // The following correctly changes the timeWarp, just need to get it to change to the right value.
            player.timeWarp = player.timeWarp += .01;
            player.loadFile("/midi_files/" + songs[songId], onSuccessfulSongLoad);
        }else{
            tempo_found = true;
        }
    }else if(player.endTime > time_goal){
        higher = true;
        if(!lower){
            player.timeWarp = player.timeWarp -= .01;
            player.loadFile("/midi_files/" + songs[songId], onSuccessfulSongLoad);
        }else{
            tempo_found = true;
        }
    }
    if(tempo_found){
        $('#loading').hide();
    }

    // Add MIDI drums
    MIDI.programChange(drumTrack, MIDI.GM.byName["synth_drum"].number);
    //TODO figure out how to get other instruments playing too.

    // Start the player
    player.start(onsuccess);
};

var MIDIPlayerPercentage = function (player) {
    // update the timestamp
    var time1 = document.getElementById("time1");
    var time2 = document.getElementById("time2");
    var capsule = document.getElementById("capsule");
    var timeCursor = document.getElementById("cursor");

    // Adjust the play location when the user click-drags in the song progress bar.
    eventjs.add(capsule, "drag", function (event, self) {
        eventjs.cancel(event);
        player.currentTime = (self.x) / 650 * player.endTime;
        if (player.currentTime < 0) player.currentTime = 0;
        if (player.currentTime > player.endTime) player.currentTime = player.endTime;
        if (self.state === "down") {
            player.pause(true);
        } else if (self.state === "up") {
            player.resume();
        }
    });

    function timeFormatting(n) {
        var minutes = n / 60 >> 0;
        var seconds = String(n - (minutes * 60) >> 0);
        if (seconds.length == 1) seconds = "0" + seconds;
        return minutes + ":" + seconds;
    }

    player.getNextSong = function (n) {
        var id = Math.abs((songId += n) % songs.length);
        player.loadFile("/midi_files/" + songs[id], onSuccessfulSongLoad);

        /// Load the MidiFile for parsing as staff music
        parse_midi(songs[songId], songs[songId], function(midiFile) {
            // console.log(midiFile);
            initMusicStaff(midiFile);
        });
    };

    //noinspection JSUnusedLocalSymbols
    player.setAnimation(function (data, element) {
        var percent = data.now / data.end;
        var now = data.now >> 0; // where we are now
        var end = data.end >> 0; // end of song
        if (now === end) { // go to next song
            var id = ++songId % songs.length;
            player.loadFile("/midi_files/" + songs[id], player.start); // load MIDI
        }
        // display the information to the user
        timeCursor.style.width = (percent * 100) + "%";
        time1.innerHTML = timeFormatting(now);
        time2.innerHTML = "-" + timeFormatting(end - now);
    });
};
