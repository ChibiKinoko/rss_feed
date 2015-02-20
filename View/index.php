<?php
$xml = simplexml_load_file('http://lexpansion.lexpress.fr/rss/high-tech.xml');

$nb = 1;
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>My_RSS_Feed</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
</head>
<body>

	<div id="main">
		<?php
		foreach ($xml->channel->item as $actu) {

			?>
			<p>Actu n°<?php echo $nb." : ".$actu->title."\n"; ?></p>
			<p><?php echo $actu->description."\n" ?></p>
			<p>Publie le : <?php echo $actu->pubDate; ?></p>
			<?php
			/*print_r($actu->description);*/
			$nb++;
		}
		?>

	</div>

</body>
</html>	