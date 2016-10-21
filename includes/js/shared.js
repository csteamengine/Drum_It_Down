/**
 * Created by adm_gcs on 10/19/2016.
 */
var audioObject;

/**
 * Created by adm_gcs on 6/9/2016.
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


function parse_midi(file_name, original_file_name){
    file_name = "midi_files/"+file_name;
    loadRemote(file_name, function(data) {
        midiFile = MidiFile(data);
        midiFile.header.original_file_name = original_file_name;
        synth = Synth(44100);
        replayer = Replayer(midiFile, synth);
        var found = false;
        var deltaTime = 0;
        var curr_delta = 0;

        if(midiFile.header.drum_track != null){
            var instruments = new Array();
            for(i =0;i< midiFile.tracks[midiFile.header.drum_track].length;i++){
                if(midiFile.tracks[midiFile.header.drum_track][i].noteNumber != null && instruments.indexOf(midiFile.tracks[midiFile.header.drum_track][i].noteNumber) == -1){
                    instruments.push(midiFile.tracks[midiFile.header.drum_track][i].noteNumber);
                }
            }
        }

        // console.log(midiFile);
        // console.log(instruments);
        // for(i=0;i<instruments.length;i++){
        //     console.log(drum_numbers[instruments[i]]);
        // }
        // synth = Synth(44100);
        // replayer = Replayer(midiFile, synth);
        // audio = AudioPlayer(replayer);
        // audio.play();
        // // play_drums(midiFile,milliseconds);
        // var drums = midiFile.header['drum_track'];
        //
        // if(found){
        //     var counter = 0;
        //     var timer = setInterval(function(){
        //         counter++;
        //         if(counter == 100){
        //             clearInterval(timer);
        //         }
        //     },milliseconds);
        // }else{
        //     console.log("Could not find BPM");
        // }

        return midiFile;
    });

}


function play_note(midiNote){
    console.log(midiNote.subtype + " - " + midiNote.noteNumber + " - " + midiNote.deltaTime);
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
    }
    fetch.send();
}
