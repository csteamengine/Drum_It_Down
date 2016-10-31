// TODO: Populate these songs programmatically with user input



var songId = 0;
var songs = [$('#song_file').val()];
var player;
var drumTrack = 9;
if (typeof (console) === "undefined") var console = {
    log: function () {
    }
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
    /// TODO: Replace the piano keys with an SVG drum kit.


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

            /// control the piano keys colors
            player.addListener(function (data) {
                var bass = [35,36];
                var crash = [49,51,53,57];
                var low_tom = [41,43];
                var mid_tom = [45,47];
                var high_tom = [48,50];
                var snare = [38,40];
                var high_hat = [42,44];
                if(data.channel == drumTrack){
                    if(bass.indexOf(data.note) != -1){
                        kick();
                    }else if(crash.indexOf(data.note) != -1){
                        crash_hit();
                    }else if(high_tom.indexOf(data.note) != -1){
                        rightTom();
                    }else if(mid_tom.indexOf(data.note) != -1){
                        leftTom();
                    }else if(low_tom.indexOf(data.note) != -1){
                        floorTom();
                    }else if(snare.indexOf(data.note) != -1){
                        snare_hit();
                    }else if(high_hat.indexOf(data.note) != -1){
                        hiHat();
                    }
                }

            });

            /// Show the player progress bar
            MIDIPlayerPercentage(player);
        }
    });
});
var lower = false;
var higher = false;
var tempo_found = false;
var onSuccessfulSongLoad = function (onsuccess) {
    // Show song filename

    //The following adjusts the timeWarp to match it as close to the spotify songs duration as possible.
    var time_goal = parseInt($('#duration').val())
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
    // Log all meta data
    for (var i = 0; i < player.data.length; i++) {
        var obj = player.data[i][0];
        if (obj.event.type == "meta") {

            if (obj.event.subtype == "trackName" && obj.event.text && obj.event.text.toLowerCase() == "drums") {
                // drumTrack = obj.track;
                console.log("DRUM TRACK: " + drumTrack);
            }
        }
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
