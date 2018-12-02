<?php

namespace WordSeparator\Domain;

class FileReader {
	private $wordArray = array();

	function __construct($path) {
		if ($file = fopen($path, "r")) {
			$tempWords = array();
			while (!feof($file)) {
				// replacement to avoid .txt artifacts
				$word = preg_replace("/[^A-Za-zÄÖÜäöüß]/", '', fgets($file));
				$tempWords[strlen($word)][] = $word;
			}
			
			// this sort is purely for visual clearance and has no functional value
			ksort($tempWords);
			
			// this section is normally not required, but since umlauts aren't sorted alphabetically in PHP, I have to use it here
			foreach ($tempWords as $size => $wordGroup) {
				sort($wordGroup);
				foreach ($wordGroup as $word) {
					$this->wordArray[$size][] = $word;
				}
			}
			
		} else {
			echo("Failed to open file '$path'");
		}
	}
	
	function getAmountFor($size) {
		return isset($this->wordArray[$size]) ? count($this->wordArray[$size]) : null;
	}
	
	function getAmount() {
		$sum = 0;
		foreach ($this->wordArray as $size => $wordGroup) {
			$sum += $this->getAmountFor($size);
		}
		return $sum;
	}

	function getAll() {
		return $this->wordArray;
	}
	
	function getAt($size, $index) {
		return $this->wordArray[$size][$index];
	}
	
	function getFor($size) {
		return $this->wordArray[$size];
	}

	// for testing purposes only
	function printAll($indexed = false, $html = false) {
		if ($html) { echo("<ul>"); }
		
		foreach ($this->wordArray as $size => $wordGroup) {
			
			if ($html) { echo("<li>"); }
			if ($indexed) { echo("$size letters:"); }
			if ($html) { echo("<ul>"); }
			
			foreach ($wordGroup as $index => $word) {
				if ($html) { echo("<li>"); }
				echo(
					($indexed ? "$index: " : "")
					. $word
				);
				if ($html) { echo("</li>"); }
			}
			if ($html) { echo("</ul></li>"); }
		}

		if ($html) { echo("</ul>"); }
	}
}

?>