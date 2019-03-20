--------------------------
File formats and filenames
--------------------------
All website icons and menu graphics are designed in Inkscape and saved to SVG.  These master files can be easily edited.  A version of each master file is saved with "-outline" appended to the file basename.  These files have all objects (including text) converted to path outlines.  This effectively embeds the font so that the image will appear the same on any system and will also cleanly scale.

----------------------
"Software Type" Design
----------------------
The software-tab/sw-icon-*.svg files are laid out in such a way that letters above or below the baseline may extend above or below the graphics element.  This precludes the use of a minumum bounding box when setting file size because fonts would scale to different apparent sizes if files have different heights.  This is addressed by embedding a rectangle with no stroke and no fill to serve as a consistent vertical pad.  The minimal bounding box now produces files with a constant height and the width is variable depending on the icon name (OK).

---------------
Font selections
---------------
"NMR" of NMRbox     Libre Franklin / Bold
"box" of NMRbox     Libre Franklin / Light
Software Types      Avenir / Medium
Research Problems   Avenir / Medium
Navigation icons    Avenir / Medium




