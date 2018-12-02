<?php

// 1 == wordManager; 2 == Separator
$testMode = 2;

require("Domain\Separator.php");

if ($testMode == 2) { $separator = new \WordSeparator\Domain\Separator("data/words.txt"); }
if ($testMode == 1) { $wordsManager = new \WordSeparator\Domain\FileReader("data/words.txt"); }

?>

<html>
<body>
	<?php
		if ($testMode == 1) { $wordsManager->printAll(true, true); }
		if ($testMode == 2) { 
			$words = $separator->separate("donaudampfschiffkapitän");
		
			foreach($words as $word) {
				echo("<p>$word</p>");
			}
		}
	?>
</body>
</html>