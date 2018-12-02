<?php

namespace WordSeparator\Domain;

require("FileReader.php");

class Separator {
	private $wordManager;
	
	function __construct($path) {
		$this->wordManager = new FileReader($path);
	}
	
	function separate($compositeWord) { // TODO: externally check if this is a single word with no special characters
		$words = array();
		$currIndex = 0;
		
		while (($word = $this->getWord($compositeWord, $currIndex)) 
				&& $currIndex < strlen($compositeWord)) {
			$words[] = $word;
			echo("<p>$word FOUND</p>");
		}
		
		return $words;
	}
	
	// verifies each size in descending order until a word is found
	private function getWord($string, &$currIndex) {
		$currSize = strlen($string) - $currIndex;
		
		$skipped = ""; // required to keep track of connection elements
		
		while ($currSize > 0 && $currIndex < strlen($string)) {
			if ($word = $this->getWordFor($currSize, $string, $currIndex)) {
				return $word;
			}
			$currSize--; // move to next group
			
			// no word found yet, but a connection element could have been encountered
			if ($currSize <= 0 && $currIndex > 0) { // a connection element cannot exist in the beginning of a word
			
				// connection rules taken from https://www.dartmouth.edu/~deutsch/Grammatik/Wortbildung/Komposita.html
				if (
					($skipped === "" && in_array($string[$currIndex], array('e', 's', 'n'))) // no connector found yet; verifying single letter connectors
					|| ($skipped === "e" && in_array($string[$currIndex], array('r', 's', 'n'))) // one letter connector verified; attempting two letter connectors
					|| ($skipped === "en" && $string[$currIndex] == "s") // verifying the only possible three letter connector
				) {
					$currIndex++; // "skipping" connector
					$currSize = strlen($string) - $currIndex; // resetting size with consideration of connector
					$skipped .= $string[$currIndex]; // saving connector to avoid exploits
				}
			}
		}
	  
		// no word found
		return null;
	}
	
	// standard binary search; copied from internet and slightly edited to fit the requirements more
	private function getWordFor($size, $string, &$currIndex) {
		$this->resetFromAndToFor($from, $to, $size);
		
		echo("<p>Current size: $size</p>");
		while ($from <= $to && $currIndex < strlen($string)) {
			$midpoint = (int) floor(($from + $to) / 2);
			echo("<p>$currIndex & $from - $midpoint - $to</p>");
			
			// created temporary versions for values that have to be called/parsed multiple times
			$tempWord = $this->wordManager->getAt($size, $midpoint);
			echo("<p>$tempWord" . "</p>");
			$tempString = substr($string, $currIndex, strlen($tempWord));
			echo("<p>$tempString</p>");
			
			if ($tempWord < $tempString) {
				$from = $midpoint + 1;
			} elseif ($tempWord > $tempString) {
				$to = $midpoint - 1;
			} else {
				echo("<p>SUCCESS</p>");
				$currIndex += strlen($tempWord);
				return $tempWord;
			}
		}
		
		// no word found
		return null;
	}
	
	private function resetFromAndToFor(&$from, &$to, $size) {
		$from = 0;
		$to = $this->wordManager->getAmountFor($size) - 1;
	}
}

?>