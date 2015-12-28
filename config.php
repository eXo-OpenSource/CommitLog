<?php
    define('USE_SHORT_HASHES', true);
    define('USE_SECRET_KEY', true);
    define('SECRET_KEY', '');

	// functions
	function match_GitHubChars ($text, $baseUri = 'https://github.com/vRoleplay/CommitLog') {
		// Match hashes
		preg_match_all('/\b([a-f0-9]{40})\b/', $text, $matches, PREG_OFFSET_CAPTURE);
		foreach ($matches[0] as $match) {
			$text = str_replace($match[0], "<a href=\"{$baseUri}/commit/{$match[0]}\">".substr($match[0], 0, 7)."</a>", $text);
		}
		
		// Match issues
		preg_match_all('/(#[0-9][0-9]{0,10})/', $text, $matches, PREG_OFFSET_CAPTURE);
		foreach ($matches[0] as $match) {
			$text = str_replace($match[0], "<a href=\"{$baseUri}/issues/".substr($match[0], 1, strlen($match[0]))."\">".$match[0]."</a>", $text);
		}
		
		// Match @name
		preg_match_all('/(@[^\s]+)/', $text, $matches, PREG_OFFSET_CAPTURE);
		foreach ($matches[0] as $match) {
			$match[0] = preg_replace(array("#[,./]#", "#[^@a-zA-Z0-9]#"), array("", ""), $match[0]);
			$text = str_replace($match[0], "<a href=\"https://github.com/".substr($match[0], 1, strlen($match[0]))."\">".$match[0]."</a>", $text);
		}
		
		return $text;
	}
?>
