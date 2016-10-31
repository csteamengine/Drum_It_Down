/**
 * Created by nkarasch on 10/27/16.
 */

var svg = {
    get: function(type, x, y, misc) {
        if (misc == undefined) {
            misc = "";
        }
        switch (type) {
            case "note":
                return '<ellipse transform="translate(' + x + ' ' + y + ') rotate(-30)" ' + misc + '></ellipse>';
            case "stem":
                return '<rect width="4.6" height="165" transform="translate(' + x + ' ' + y + ')" ' + misc + '></rect>';
            default:
                return '';
        }
    },
    config: {
        scale: 3,
        width: 800,
        height: 300
    },
    vbWidth: function() { return this.config.scale * this.config.width; },
    vbHeight: function() { return this.config.scale * this.config.height; },
    lineSpacing: function() { return this.vbHeight() / 15; },
    getStaff: function() {
        var lines = [];
        for (var i = 0; i < 5; i++) {
            var val = (i + 6) * this.lineSpacing();
            lines.push('<rect width="' + this.vbWidth() + '" height="4.6" ' +
                'transform="translate(0 ' + val + ')"/>');
        }
        return lines.join('');
    },
    getSvg: function(notes) {
        return '<svg width="' + this.config.width + '" height="' + this.config.height + '" ' +
            'viewBox="0 0 ' + this.vbWidth() + ' ' + this.vbHeight() + '">' + this.getStaff() +
            notes.join("") + '</svg>';
    }
};

var initMusicStaff = function(midiFile) {
    var ticks = 0;
    var notes = [];
    for (var i = 0; i < midiFile.tracks[0].length / 100; i++) {
        var obj = midiFile.tracks[0][i];
        ticks += obj.deltaTime;
        if (obj.subtype == "noteOn") {
            var exactBeat = ticks / midiFile.header.ticksPerBeat;
            var roundedBeat = Math.round(exactBeat * 8) / 8.0;
            var noteData = noteInfo.get(obj.noteNumber);
            var xOffset = 8*(roundedBeat-5)*svg.lineSpacing();
            var yOffset = noteData.y;
            notes.push(svg.get("note", xOffset, yOffset,
                'id="' + i + '_beat' + roundedBeat + '"'));
            var xAdjustment = (noteData.rawY > 7) ? -28 : 24;
            var yAdjustment = (noteData.rawY > 7) ? 0 : -165;
            notes.push(svg.get("stem", xOffset + xAdjustment, yOffset + yAdjustment));
        }
    }
    $("#music-staff").html(svg.getSvg(notes));
};

var noteInfo = {
    get: function(note) {
        var n = this.notes[String(note)];
        if (n == undefined) {
            return {
                noteHead: this.notes['DEFAULT'].noteHead,
                rawY: this.notes['DEFAULT'].y,
                y: this.notes['DEFAULT'].y * svg.lineSpacing()
            };
        } else {
            return {
                noteHead: n.noteHead,
                rawY: n.y,
                y: n.y * svg.lineSpacing()
            };
        }
    },
    notes: {
        DEFAULT: {
            noteHead: "x",
            y: 12
        },
        35: {  // "Bass Drum 2",
            noteHead: "filled ellipse",
            y: 9.5
        },
        36: {  // "Bass Drum 1",
            noteHead: "filled ellipse",
            y: 9.5
        },
        37: {  // "Side Stick/Rimshot",
            noteHead: "x",
            y: 7.5
        },
        38: {  // "Snare Drum 1",
            noteHead: "filled ellipse",
            y: 7.5
        },
        39: {  // "Hand Clap",
            noteHead: "filled diamond",
            y: 7.5
        },
        40: {  // "Snare Drum 2",
            noteHead: "filled ellipse",
            y: 7.5
        },
        41: {  // "Low Tom 2",
            noteHead: "circled dot",
            y: 9.0
        },
        42: {  // "Closed Hi-hat",
            noteHead: "x",
            y: 6.0
        },
        43: {  // "Low Tom 1",
            noteHead: "circled dot",
            y: 8.5
        },
        44: {  // "Pedal Hi-hat",
            noteHead: "x",
            y: 10.5
        },
        45: {   // "Mid Tom 2",
            noteHead: "circled dot",
            y: 7.0
        },
        46: {   // "Open Hi-hat",
            noteHead: "x open",
            y: 6.0
        },
        47: {   // "Mid Tom 1",
            noteHead: "circled dot",
            y: 7.0
        },
        48: {  // "High Tom 2",
            noteHead: "circled dot",
            y: 6.5
        },
        49: {  // "Crash Cymbal 1",
            noteHead: "x",
            y: 5.0
        },
        50: {  // "High Tom 1",
            noteHead: "circled dot",
            y: 6.5
        },
        51: {  // "Ride Cymbal 1",
            noteHead: "x",
            y: 5.5
        },
        52: {  // "Chinese Cymbal",
            noteHead: "open diamond",
            y: 4.5
        },
        53: {  // "Ride Bell",
            noteHead: "circled x",
            y: 5.5
        },
        // 54: // "Tambourine",
        55: {  // "Splash Cymbal",
            noteHead: "open diamond",
            y: 4.5
        },
        // 56: // "Cowbell",
        57: {  // "Crash Cymbal 2",
            noteHead: "x",
            y: 5.0
        },
        // 58: // "Vibra Slap",
        59: {  // "Ride Cymbal 2",
            noteHead: "x",
            y: 5.5
        }
        // 60: // "High Bongo",
        // 61: // "Low Bongo",
        // 62: // "Mute High Conga",
        // 63: // "Open High Conga",
        // 64: // "Low Conga",
        // 65: // "High Timbale",
        // 66: // "Low Timbale",
        // 67: // "High Agogô",
        // 68: // "Low Agogô",
        // 69: // "Cabasa",
        // 70: // "Maracas",
        // 71: // "Short Whistle",
        // 72: // "Long Whistle",
        // 73: // "Short Güiro",
        // 74: // "Long Güiro",
        // 75: // "Claves",
        // 76: // "High Wood Block",
        // 77: // "Low Wood Block",
        // 78: // "Mute Cuíca",
        // 79: // "Open Cuíca",
        // 80: // "Mute Triangle",
        // 81: // "Open Triangle",
    }
};

// var notes = [
// ];
// for (var i = 1; i < 7; i+=0.5) {
//     notes.push(svg.get("note",
//         4*i*svg.lineSpacing(),
//         svg.lineSpacing()*(i+4),
//         'id="' + i + '"'));
// }
// for (i = 1; i < 7; i+=0.5) {
//     var xAdjustment = (i < 4) ? -28 : 24;
//     var yAdjustment = (i < 4) ? 0 : -165;
//     notes.push(svg.get("stem",
//         4 * i * svg.lineSpacing() + xAdjustment,
//         svg.lineSpacing() * (i + 4) + yAdjustment));
// }
// $("#music-staff").html(svg.getSvg(notes));
