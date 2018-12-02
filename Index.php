<?php

require("Domain\Separator.php");

//$separator = new \WordSeparator\Domain\Separator("data/words.txt");
$wordsManager = new \WordSeparator\Domain\FileReader("data/words.txt");

?>

<html>
<body>
	<?php
		//echo count($me);
		echo $wordsManager->getAmountFor(1);
		echo $wordsManager->getAmount();
		$wordsManager->printAll(true, true);
		//$words = $separator->separate("donaudampfschiffkapitän");
		
		/*foreach($words as $word) {
			echo("<p>$word</p>");
		}*/
	?>
</body>
</html>