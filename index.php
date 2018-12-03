<?php

require("Domain\Separator.php");

$separator = new \WordSeparator\Domain\Separator("data/words.txt");

?>

<html>
<body>
	<form action="index.php" method="post">
		<input type="text" name="composite" style="width: 250px;" placeholder="Insert the composite word in lowercase" <?php if (isset($_POST['composite'])) { echo('value="'.$_POST['composite'].'"'); } ?> />
		<input type="submit" name="submit" value="submit" />
	</form>
	<?php
		if (isset($_POST['composite'])) {
			$words = $separator->separate($_POST['composite']);
			if ($words) {
				echo("<p>The discovered words are:</p><ul>");
				foreach ($words as $word) {
					echo("<li>$word</li>");
				}
				echo("</ul>");
			} else {
				echo("<p>No words were found.</p>");
			}
		}
		
		/*foreach($words as $word) {
			echo("<p>$word</p>");
		}*/
	?>
</body>
</html>
