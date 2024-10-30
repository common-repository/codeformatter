codeformatter.php
uthor: axlotl.blog@mailnull.com

See it in action: http://axlotl.net/wp/2005/10/09/formatting-code/


This plugin finds all blocks of text between <code> tags, line-numbering and formatting it.


*	Displayed code can be selected without selecting line numbers.
*	Line numbers added dynamically so they don't sully the source, should you want to edit it.
*	Includes optional and configurable "tiger stripe" rows.
*	css included in the single file, easily configurable from plugin editor panel.

...and that's about it so far.

TODO:
*	syntax hilighting
*	optional specific character escaping
*	address some WP bugs (extra <code> tag appended)

Syntax hilighting looks like it's going to take over the entire plugin as the tools I'm looking at integrating
all include twin-tablecell line numbers already.
