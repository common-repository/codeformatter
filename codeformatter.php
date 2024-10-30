<?php
/*
Plugin Name: code Formatter
Plugin URI: http://axlotl.net/plugins/
Description: Finds <code> tags and numbers and styles the lines within
Version: 0.2
Author: chris feldmann	
Author URI: http://axlotl.net
Author email: axlotl.blog@mailnull.com
*/
/*
version history
0.2:	moved css to php file so it could be edited with plugin editor
			color bars on alternating rows
			improved handling of spaces
			
0.1:	initial release
*/
add_action('wp_head','cwf2_wp_head');
add_filter('the_content', 'cwf2_number_lines');

function cwf2_wp_head($unused)
{
	echo '<style type="text/css" media="screen">'."\n";
	echo <<<CSSEND
table.codeTable {
	background: rgb(238,252,246);
	border-collapse: collapse;
	width:100%;
	display: block;
	margin: 10px 14em 01px 20px;
	padding: 6px 1px 6px 2px;
	border: 2px solid rgb(200,200,200);
	border-left: 8px solid rgb(190,190,190);
	-moz-border-radius: 12px;
	font-size: 80%;
}
td.code_ln {
	display: table-cell;
	color: rgb(149,47,47);
	font: 1.1em monaco, monospace, courier, serif;
}
td.code_content {
	width: 100%;
	color:  rgb(80,80,80);
	white-space: nowrap;
	font: 1.1em monaco, monospace, courier, serif;
}

span.alternate {
	display: block;
	width: 100%;
	background-color: rgb(255,255,255);
	font-family:  monaco, monospace, courier, serif;
	font-size: inherit;
}
CSSEND;
	echo "\n</style>\n";

}

function cwf2_number_lines($content)
{
	preg_match_all("/<code>(.*?)<\/code>/is", $content, $elems); 

	for ($i = 0; $i < count($elems[1]); $i++) {
		$ln = "";
		$codeBlock = "";
		$replace[$i] = $elems[0][$i];
		$code = trim($elems[1][$i]);
		$lines = explode("\n", $code);
		$number = 1;
		for ($j = 0; $j < count($lines) ; $j++){	
			/*
			*		remove blank lines and non-code html
			*/
			if (preg_replace( "/<\/?code>|<br\s?\/?>/i", "", $lines[$j]) == "" ){
				continue;
			} else {	
				/*
				*	alter the conditional in the next 2 lines to change the hilighted rows.
				*	e.g. ($number %2 == 0) results in alternate hilighted rows.
				*	currently set to mimic punch-feed computer paper.
				*/
				$hilite = ($number % 3 == 2) ? '<span class="alternate">' : "";
				$hiliteClose = ($number % 3 == 2) ? '</span>' : "";
				
				$ln .= $hilite . $number. '&nbsp;'. $hiliteClose . "\n";
				$tmpLine = preg_replace( "/<\/?code>/i", "", $lines[$j]);
				$codeBlock .= $hilite . preg_replace('/(?<=\s)\s/', '&nbsp;', $tmpLine) . $hiliteClose . "\n";
				
					
			}
			$number++;
		}
		/*		
		*		build the table.
		*/
		$tableString[$i] = "<table class='codeTable'>\n<tr>\n<td class='code_ln' align='right' width='10'>\n";
		$tableString[$i] .= $ln. "\n";
		$tableString[$i] .= "</td><td class='code_content'>\n";
		$tableString[$i] .= $codeBlock. "\n";
		$tableString[$i] .= "</td>\n</tr>\n</table>\n";

	}

	/*
	*		We can feed str_replace 2 arrays...
	*/
	if($lnContent = str_replace($replace, $tableString, $content)){
		return $lnContent;
	} else {
		return $content;
	}
}
?>
