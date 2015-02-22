<?php

$xml = simplexml_load_file('http://lexpansion.lexpress.fr/rss/high-tech.xml');

$nb = 1;


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