<?php

$xml = simplexml_load_file('http://www.leparisien.fr/une/rss.xml');

echo '<pre>';
print_r($xml);

$nb = 1;


/*foreach ($xml->channel->item as $actu) {

	?>
	<p>Actu n°<?php echo $nb." : ".$actu->title."\n"; ?></p>
	<p><?php echo $actu->description."\n" ?></p>
	<p>Publie le : <?php echo $actu->pubDate; ?></p>
	<?php
	$nb++;
}*/


?>
