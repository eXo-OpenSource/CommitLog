<?php
    define('USE_SHORT_HASHES', true);
    define('USE_SECRET_KEY', true);
    define('SECRET_KEY', '');

	// functions
	function match_all_hashes ($text, $baseUri = 'https://github.com/Jusonex/vRoleplay_Script/') {
		preg_match_all('/\b([a-f0-9]{40})\b/', $text, $matches, PREG_OFFSET_CAPTURE);
		
		foreach ($matches[0] as $match) {
			$text = str_replace($match[0], "<a href=\"{$baseUri}{$match[0]}\">".substr($match[0], 0, 7)."</a>", $text);
		}
		
		return $text;
	}
?>
