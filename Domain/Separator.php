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
			echo("<p>$word</p>");
		}
		
		return $words;
	}
	
	// standard binary search; copied from internet and slightly edited to fit the requirements more
	private function getWord($string, &$currIndex) {
		$this->resetFromAndTo($from, $to);
		
		$skipped = ""; // required to keep track of connection elements
		
		while ($from <= $to && $currIndex < strlen($string)) {
			$midpoint = (int) floor(($from + $to) / 2);
			echo("<p>$currIndex & $from - $midpoint - $to</p>");
			
			// created temporary versions for values that have to be called/parsed multiple times
			$tempWord = $this->wordManager->getAt($midpoint);
			echo("<p>$tempWord" . strlen($tempWord). "</p>");
			$tempString = substr($string, $currIndex, strlen($tempWord));
			echo("<p>$tempString</p>");
			
			if ($tempWord < $tempString) {
				$from = $midpoint + 1;
			} elseif ($tempWord > $tempString) {
				$to = $midpoint - 1;
			} else {
				$currIndex += strlen($tempWord);
				return $tempWord;
			}
			
			// no word found yet, but a connection element could have been encountered
			if ($from > $to && $currIndex > 0) { // a connection element cannot exist in the beginning of a word
			
				// connection rules taken from https://www.dartmouth.edu/~deutsch/Grammatik/Wortbildung/Komposita.html
				if (
					($skipped === "" && in_array($string[$currIndex], array('e', 's', 'n'))) // no connector found yet; verifying single letter connectors
					|| ($skipped === "e" && in_array($string[$currIndex], array('r', 's', 'n'))) // one letter connector verified; attempting two letter connectors
					|| ($skipped === "en" && $string[$currIndex] == "s") // verifying the only possible three letter connector
				) {
					resetFromAndTo($from, $to); // shifting by one position and repeating the search
					$currIndex++; // "skipping" connector
					$skipped .= $string[$currIndex]; // saving connector to avoid exploits
				}
			}
		}
	  
		// no word found
		return null;
	}
	
	private function resetFromAndTo(&$from, &$to) {
		$from = 0;
		$to = $this->wordManager->getAmount() - 1;
	}
}

?>