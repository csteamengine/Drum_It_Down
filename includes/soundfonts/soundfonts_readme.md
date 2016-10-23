# Soundfonts

## Credit

The synth_drum soundfont in this directory was taken from letoribo's
[General-MIDI-Percussion-soundfonts-for-MIDI.js-](https://github.com/letoribo/General-MIDI-Percussion-soundfonts-for-MIDI.js-)
repository. The only change that was made was that in letoribo's repo,
the soundfont is assigned to the acoustic grand piano. I changed that
so that it's assigned to the synth_drum instrument.

## Usage

So that nobody else has to struggle figuring this junk out...

```js
MIDI.loadPlugin({
    soundfontUrl: "includes/soundfonts/",
    instrument: "synth_drum",
    onsuccess: function () {
        MIDI.Player.loadFile("midi_files/MyHero.mid", function(onsuccess) {
	    // In this example, track 9 is the drum track. But I think that
	    // by general MIDI convention, track 9 is always the drums.
            MIDI.programChange(9, MIDI.GM.byName["synth_drum"].number);
            MIDI.Player.start(onsuccess);
        });
    }
});
```
