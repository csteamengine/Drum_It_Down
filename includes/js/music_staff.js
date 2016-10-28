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
                return '<ellipse transform="translate(' + x + ' ' + y + ') rotate(-30)" ' + misc + '/>';
            case "stem":
                return '<rect width="4.6" height="165" transform="translate(' + x + ' ' + y + ')" ' + misc + '/>';
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
    }
};

var notes = [
    svg.getStaff()
];
for (var i = 1; i < 7; i+=0.5) {
    notes.push(svg.get("note",
        4*i*svg.lineSpacing(),
        svg.lineSpacing()*(i+4),
        'id="' + i + '"'));
}
for (i = 1; i < 7; i+=0.5) {
    var xAdjustment = (i < 4) ? -28 : 24;
    var yAdjustment = (i < 4) ? 0 : -165;
    notes.push(svg.get("stem",
        4 * i * svg.lineSpacing() + xAdjustment,
        svg.lineSpacing() * (i + 4) + yAdjustment));
}

document.getElementById("music-staff").innerHTML =
    '<svg width="' + svg.config.width + '" height="' + svg.config.height + '" ' +
    'viewBox="0 0 ' + svg.vbWidth() + ' ' + svg.vbHeight() + '">' +
    notes.join("") + '</svg>';
