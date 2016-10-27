/**
 * Created by nkarasch on 10/27/16.
 */

var svg = {
    get: function(type, x, y) {
        return this.elements[type] + 'translate(' + x + ' ' + y + ')"/>';
    },
    elements: {
        note: '<ellipse transform="rotate(-30) ',
        stem: '<rect width="4.6" height="165" transform="',
        dot: ''
    },
    config: {
        scale: 3,
        width: 800,
        height: 200,
        vbWidth: function() { return this.scale * this.width; },
        vbHeight: function() { return this.scale * this.height }
    },
    getStaff: function() {
        var lines = [];
        var heightFactor = this.config.vbHeight() / 10;
        for (var i = 0; i < 5; i++) {
            var val = (i + 3) * heightFactor;
            lines.push('<rect width="' + this.config.vbWidth() + '" height="4.6" ' +
                'transform="translate(0 ' + val + ')"/>');
        }
        return lines.join('');
    }
};


var notes = [
    svg.getStaff(),
    svg.get("note", 100, 510),
    svg.get("stem", 365, 215)
];

document.getElementById("music-staff").innerHTML =
    '<svg width="' + svg.config.width + '" height="' + svg.config.height + '" ' +
    'viewBox="0 0 ' + svg.config.vbWidth() + ' ' + svg.config.vbHeight() + '">' +
    notes.join("") + '</svg>';
