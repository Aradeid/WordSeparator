<?php

namespace WordSeparator\Domain;

class FileReader {
	private $wordArray = array();

	function __construct($path) {
		if ($file = fopen($path, "r")) {
			$tempWords = array();
			while (!feof($file)) {
				// replacement to avoid .txt artifacts
				$tempWords[] = preg_replace("/[^A-Za-zÄÖÜäöüß]/", '', fgets($file));
			}
			
			// this section is normally not required, but since umlauts aren't sorted alphabetically in PHP, I have to use it here
			sort($tempWords);
			for ($tempWords as $word) {
				$this->wordArray[] = $word;
			}
			
		} else {
			echo("Failed to open file '$path'");
		}
	}
	
	function getAmount() {
		return count($this->wordArray);
	}

	function getAll() {
		return $this->wordArray;
	}
	
	function getAt($index) {
		return $this->wordArray[$index];
	}

	// for testing purposes only
	function printAll($indexed = false, $html = false) {
		if ($html) { echo("<ul>"); }

		for ($i = 0; $i < count($this->wordArray); $i++) {
			if ($html) { echo("<li>"); }
			echo(
				($indexed ? "$i: " : "")
				. $this->wordArray[$i]
			);
			if ($html) { echo("</li>"); }
		}

		if ($html) { echo("</ul>"); }
	}
}

?>