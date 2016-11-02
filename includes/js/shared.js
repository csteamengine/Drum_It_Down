/**
 * Created by adm_gcs on 10/19/2016.
 */


var drum_numbers = {
    35: "Bass Drum 2",
    36: "Bass Drum 1",
    37: "Side Stick/Rimshot",
    38: "Snare Drum 1",
    39: "Hand Clap",
    40: "Snare Drum 2",
    41: "Low Tom 2",
    42: "Closed Hi-hat",
    43: "Low Tom 1",
    44: "Pedal Hi-hat",
    45: "Mid Tom 2",
    46: "Open Hi-hat",
    47: "Mid Tom 1",
    48: "High Tom 2",
    49: "Crash Cymbal 1",
    50: "High Tom 1",
    51: "Ride Cymbal 1",
    52: "Chinese Cymbal",
    53: "Ride Bell",
    54: "Tambourine",
    55: "Splash Cymbal",
    56: "Cowbell",
    57: "Crash Cymbal 2",
    58: "Vibra Slap",
    59: "Ride Cymbal 2",
    60: "High Bongo",
    61: "Low Bongo",
    62: "Mute High Conga",
    63: "Open High Conga",
    64: "Low Conga",
    65: "High Timbale",
    66: "Low Timbale",
    67: "High Agogô",
    68: "Low Agogô",
    69: "Cabasa",
    70: "Maracas",
    71: "Short Whistle",
    72: "Long Whistle",
    73: "Short Güiro",
    74: "Long Güiro",
    75: "Claves",
    76: "High Wood Block",
    77: "Low Wood Block",
    78: "Mute Cuíca",
    79: "Open Cuíca",
    80: "Mute Triangle",
    81: "Open Triangle"
};


function parse_midi(file_name, original_file_name, callback){
    file_name = "/midi_files/"+file_name;
    loadRemote(file_name, function(data) {
        var midiFile = MidiFile(data);
        midiFile.header.original_file_name = original_file_name;
        guess_track_info(midiFile);
        if (callback != undefined) {
            callback(midiFile);
        }
        return midiFile;
    });
}

//    This goes through all of the events with subtype trackName and queries spotify to see if any of those trackNames are a relevant title
//    Eventually, this information will be put in the dom, asking them if the midi file is any of the following tracks.
//    If not, they can search Spotify by searching the song name.
function guess_track_info(midiFile) {
    var songGuesses = $('#song_guesses');
    songGuesses.html('');
    if (midiFile != null) {
        //An array that I'm storing all the spotify result in. Not going to work for the final product, due to cl
        var top_hits = [];
        var search_term = "";
        var limit = 1;
        for (var i = 0; i < midiFile.tracks.length; i++) {
            for (var j = 0; j < midiFile.tracks[i].length; j++) {
                if (midiFile.tracks[i][j].subtype == "trackName" && midiFile.tracks[i][j].text != "") {
                    search_term = encodeURI(midiFile.tracks[i][j].text.trim());
                    var url = "https://api.spotify.com/v1/search?q=" + search_term + "&type=track&limit=" + limit;
                    $.getJSON(url, function (result) {

                        if (result.tracks.items.length > 0) {
                            songGuesses.append('<h3 id="instructions">Click a song to pair it with the your midi file.</h3>');
//                                top_hits.push(result.tracks.items[0].name + " -- " + result.tracks.items[0].artists[0].name);
                            songGuesses.append(
                                '<div class="guess" onclick="specify_song(\'' + result.tracks.items[0].id + '\')"><div>' + result.tracks.items[0].name + " -- " + result.tracks.items[0].artists[0].name + '</div><audio style="background-color: transparent" controls><source src="'+ result.tracks.items[0].preview_url +'" type="audio/mpeg" ></audio></div>'
                            );
                        }
                    });
                }
            }
        }
        //TODO eventually pass in more info.
        if (midiFile.header.original_file_name != null) {
            limit = 5;
            search_term = encodeURI(midiFile.header.original_file_name.trim().replace('.mid', ''));
            search_term = search_term.replace(' ', '%20');
            url = "https://api.spotify.com/v1/search?q=" + search_term + "&type=track&limit=" + limit;
            $.getJSON(url, function (result) {
                if (result.tracks.items.length > 0) {
                    for (m = 0; m < result.tracks.items.length; m++) {
//                            top_hits.push(result.tracks.items[m].name + " -- " + result.tracks.items[m].artists[0].name );
                        $('#song_guesses').append(
                            '<div class="guess" onclick="specify_song(\'' + result.tracks.items[m].id + '\')" ><div>' + result.tracks.items[m].name.trim() + " -- " + result.tracks.items[m].artists[0].name.trim() + '</div><audio controls><source src="'+ result.tracks.items[m].preview_url +'" type="audio/mpeg" ></audio></div>'
                        );
                    }
                }

            });
        }
    }
}

function upload_file() {

    var file_data = $('#midi_file').prop('files')[0];
    var form_data = new FormData();
    form_data.append('midi_file', file_data);


    $.ajax({
        url: '/includes/php/upload.php?action=upload', // point to server-side PHP script

        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function (php_script_response) {
            if (php_script_response != "ERROR UPLOADING FILE") {
                midiFile = parse_midi(php_script_response, $('#midi_file').prop('files')[0].name);
                if (midiFile == "Error: Could not find a drum track.") {
                    console.log("Error");
                } else {
                    //parsing was successful
                    guess_track_info(midiFile);
                }
            }
        }
    });
}

function upload_image() {

    var file_data = $('#image_file').prop('files')[0];
    var form_data = new FormData();
    form_data.append('image_file', file_data);


    $.ajax({
        url: '/profile/index.php?action=upload_image', // point to server-side PHP script

        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function (php_script_response) {
            if (php_script_response != "ERROR UPLOADING FILE") {
                $('#user_image').css('background', "url('/user_images/"+php_script_response+"') center no-repeat" );
                $('#user_image').css('background-size', 'cover');
                $('#user_icon').attr('src', '/user_images/'+result.image);
                $('#change_image').hide();
            }
        }
    });
}


function search_song() {
    var songGuesses = $('#song_guesses');
    var songTitle = $('#song_title');
    songGuesses.html('');

    if (songTitle.val() != "") {
        var limit = 10;
        var search_term = encodeURI(songTitle.val());
        var url = "https://api.spotify.com/v1/search?q=" + search_term + "&type=track&limit=" + limit;
        $.getJSON(url, function (result) {
            if (result.tracks.items.length > 0) {
                songGuesses.append('<h3 id="instructions">Click a song to pair it with the your midi file.</h3>');
                for (var m = 0; m < result.tracks.items.length; m++) {
                    songGuesses.append(
                        '<div class="guess" onclick="specify_song(\'' + result.tracks.items[m].id + '\')"><div>' + result.tracks.items[m].name.trim() + " -- " + result.tracks.items[m].artists[0].name.trim() + '</div><audio controls><source src="'+ result.tracks.items[m].preview_url +'" type="audio/mpeg" ></audio></div>'
                    );
                // <audio controls><source src="'+ result.tracks.items[m].preview_url +'" type="audio/mpeg" ></audio>
                }
            }else{
                songGuesses.append('<h3>No results for that search</h3>')

            }

        });
    }
}


function specify_song(id) {
    $('#song_guesses').html('');
    $('#song_guesses').hide();
    $('#file_upload').hide();
    $('#search_song').hide();
    $('#loading').show();
    $('#other_midi').hide();
    var url = "https://api.spotify.com/v1/tracks/" + id;
    $.getJSON(url, function (result) {

        var new_url = "/includes/php/upload.php?action=rename&title=" + encodeURI(result.name) + "&artist=" + encodeURI(result.artists[0].name) + "&album=" +
            encodeURI(result.album.name) + "&duration=" + encodeURI(result.duration_ms) + "&spotify_id=" + encodeURI(result.id) + "&spotify_url=" + encodeURI(result.href) + "&spotify_popularity=" +
            encodeURI(result.popularity) + "&preview_url=" + encodeURI(result.preview_url) + "&spotify_uri=" + encodeURI(result.uri) + "&image_url=" + encodeURI(result.album.images[0].url);

        $.ajax({
            url: new_url,
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            success: function (php_script_response) {
                var json = JSON.parse(php_script_response);
                if(json['code'] == 200){
                    window.location = "/player/index.php?action=play&track="+json['track']+"&file="+json['file'];
                }else{
                    console.log(json);
                }
            }
        });

    });
}

function loadRemote(path, callback) {
    var fetch = new XMLHttpRequest();
    fetch.open('GET', path);
    fetch.overrideMimeType("text/plain; charset=x-user-defined");
    fetch.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            /* munge response into a binary string */
            var t = this.responseText || "" ;
            var ff = [];
            var mx = t.length;
            var scc= String.fromCharCode;
            for (var z = 0; z < mx; z++) {
                ff[z] = scc(t.charCodeAt(z) & 255);
            }
            callback(ff.join(""));
        }
    };
    fetch.send();
}
