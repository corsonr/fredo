# Fredo: A simple and clean WordPress theme
A free, open source WordPress theme, will be soon available. You can get a demo on my site: https://remicorson.com

<a align="center" href="https://github.com/corsonr/fredo/"><img width="100%" src="https://github.com/corsonr/fredo/raw/master/screenshot.png" alt="Fredo, simple & clean WordPress theme"></a>

## Why calling it "Fredo"?

Well, Fred is my father's name, and trust me, that man is really incredible. Highly inspiring. He's a multi [ironman](https://www.ironman.com), a former professional football player, a known chef who who worked in the best Parisian restaurants etc... That's why I called that theme Fredo ;-)

## Fredo is using Milligram

[Milligram](https://milligram.io/) a minimalist CSS framework built by [CJ Patoilo](http://cjpatoilo.com/). Well, to be honest, Fredo is using a modified version of Milligram, with more components.

## How to compile SASS?

Fredo is using sass for CSS. To add you own CSS code, you'll need to edit `/assets/_sass/_style.sass`. That's the only file you'll need to edit unless you submit a pull request to modify components.

1. Open the terminal.
2. Type `cd` and drag n drop the `fredo` folder to the terminal window, and hit enter.
3. Type `sass --sourcemap=none --style nested --watch  _sass:css` and hit enter.
4. Start modifying `_style.sass`.
