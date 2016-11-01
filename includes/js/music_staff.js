/**
 * Created by nkarasch on 10/27/16.
 */

var svg = {
    get: function(type, x, y, misc) {
        if (misc == undefined) {
            misc = "";
        }
        switch (type) {
            case "filled ellipse":
                return '<ellipse transform="translate(' + x + ' ' + y + ') rotate(-30)" ' + misc + '></ellipse>';
            case "circled dot":
                return '<circle cx="' + x + '" cy="' + y + '" r="28" class="open" ' + misc + '></circle>' +
                    '<circle cx="' + x + '" cy="' + y + '" r="5"></circle>';
            case "x":
                return '<line x1="' + (x-22) + '" y1="' + (y-22) + '" x2="' + (x+22) +'" y2="' + (y+22) + '" ' +
                    misc + '></line>' +
                    '<line x1="' + (x+22) + '" y1="' + (y-22) + '" x2="' + (x-22) +'" y2="' + (y+22) + '"></line>';
            case "x open":
                return '<line x1="' + (x-22) + '" y1="' + (y-22) + '" x2="' + (x+22) +'" y2="' + (y+22) + '" ' +
                    misc + '></line>' +
                    '<line x1="' + (x+22) + '" y1="' + (y-22) + '" x2="' + (x-22) +'" y2="' + (y+22) + '"></line>' +
                    '<circle cx="' + x + '" cy="' + (y-50) + '" r="10" class="open"></circle>';
            case "circled x":
                return '<line x1="' + (x-22) + '" y1="' + (y-22) + '" x2="' + (x+22) +'" y2="' + (y+22) + '"></line>' +
                    '<line x1="' + (x+22) + '" y1="' + (y-22) + '" x2="' + (x-22) +'" y2="' + (y+22) + '"></line>' +
                    '<circle cx="' + x + '" cy="' + y + '" r="28" ' + misc + '></circle>';
            case "filled diamond":
                return '<polygon points="0,-28 28,0 0,28 -28,0" transform="translate(' + x + ' ' + y + ')" ' +
                    misc + '></polygon>';
            case "open diamond":
                return '<polygon points="0,-24 24,0 0,24 -24,0" transform="translate(' +
                    x + ' ' + y + ')" class="open" ' + misc + '></polygon>';
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
    var ticksPerBeat = midiFile.header.ticksPerBeat;
    var notes = [];
    var ticks = 0;
    var beatsPerMeasure = 4;
    var musicStaff = $("#music-staff");
    var lastMeasureDisplayed = 0;
    var measureTree = new MeasureTree(4);

    var handleNoteOn = function() {
        var exactBeat = ticks / ticksPerBeat;
        var roundedBeat = Math.round(exactBeat * 8) / 8.0;
        var measure = Math.floor(roundedBeat / beatsPerMeasure);
        var measuresPassed = measure - lastMeasureDisplayed;
        if (measuresPassed > 0) {
            for (var i = 0; i < measuresPassed; i++) {
                musicStaff.append(svg.getSvg(notes));
                console.log({measure: measure, tree: measureTree}); // TODO: generateNoteFlags();
                console.log(measureTree.getNotes());
                notes = [];
                measureTree = new MeasureTree(4);
            }
            lastMeasureDisplayed = measure;
        }

        measureTree.add(roundedBeat - measure*4);
        var noteData = noteInfo.get(obj.noteNumber);
        var xOffset = (svg.lineSpacing()*2) + 9*(roundedBeat-measure*4)*svg.lineSpacing();
        var yOffset = noteData.y;
        notes.push(svg.get(noteData.noteHead, xOffset, yOffset,
            'id="' + i + '_beat' + roundedBeat + '"'));
        var xAdjustment = (noteData.rawY > 7) ? -28 : 24;
        var yAdjustment = (noteData.rawY > 7) ? 0 : -165;
        notes.push(svg.get("stem", xOffset + xAdjustment, yOffset + yAdjustment));
    };

    console.log(midiFile.tracks[0][42]);
    for (var i = 0; i < midiFile.tracks[0].length / 100; i++) {
        var obj = midiFile.tracks[0][i];
        ticks += obj.deltaTime;
        if (obj.subtype == "noteOn" && obj.channel == 9) {
            handleNoteOn(obj, ticks, i);
        }
    }
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

function Node(val) {
    // If left or right is null, it means it's a rest. Otherwise, it's a note
    // or has subdivision with a note.
    var decimalPart = val - Math.floor(val);
    if (decimalPart == 0) {
        this.left = null;
        this.right = null;
    } else if (decimalPart < 0.5) {
        this.left = new Node(val * 2);
        this.right = null;
    } else {
        this.left = new Node(0);
        this.right = new Node(val * 2);
    }
}
Node.prototype.add = function(val) {
    var decimalPart = val - Math.floor(val);
    if (decimalPart == 0) {
        // Do nothing
    } else if (decimalPart < 0.5) {
        if (this.left == null) {
            this.left = new Node(val * 2);
        } else {
            this.left.add(val * 2);
        }
    } else {
        if (this.left == null) {
            this.left = new Node(0);
        }
        if (this.right == null) {
            this.right = new Node(val * 2);
        } else {
            this.right.add(val * 2);
        }
    }
};
Node.prototype.getNotes = function(root, noteSize) {
    var notes = {};
    if (this.left == null && this.right == null) {
        notes[String(root)] = {type: "note", size: noteSize};
        return notes;
    }

    if (this.left != null) {
        notes = this.left.getNotes(root, noteSize/2);
    } else {
        notes[String(root)] = {type: "rest", size: noteSize};
    }
    if (this.right != null) {
        notes = $.extend(notes, this.right.getNotes(root + noteSize/2, noteSize/2));
    }
    return notes;
};

function MeasureTree(beats) {
    if ((typeof beats !== "number") || Math.floor(beats) !== beats) {
        throw new TypeError("The MeasureTree constructor must be given an integer!");
    }
    this.beatsPerMeasure = beats;
    this.beats = [];
    for (var i = 0; i < beats; i++) {
        this.beats.push(null);
    }
}
MeasureTree.prototype.add = function(val) {
    if (val >= this.beatsPerMeasure || val < 0) {
        throw new RangeError("Invalid value (" + val + ") added to MeasureTree with beatsPerMeasure=" + this.beatsPerMeasure)
    }
    var beat = Math.floor(val);
    if (this.beats[beat] == null) {
        this.beats[beat] = new Node(val, val);
    } else {
        this.beats[beat].add(val, val);
    }
};
MeasureTree.prototype.getNotes = function() {
    var notes = {};
    for (var i = 0; i < this.beats.length; i++) {
        if (this.beats[i] == null) {
            notes[i] = "rest";
        } else {
            notes[i] = this.beats[i].getNotes(0, 1);
        }
    }
    return notes;
};
