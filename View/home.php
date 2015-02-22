<?php
/**
 * Home.php
 *
 * PHP Version 5.2
 *
 * @category View
 * @package  View
 * @author   meng-b_l <laure.meng-boyer@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:8080/PHP_Avance_RSS_Feed/View
 */

include '../Model/classes/Session.php';

$session = new Session;

if (isset($_GET['deco']) && $_GET['deco'] == 1) {
	$session->destroy();
}

$session->coOrNot();

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
		<nav>
			<h1><a href="home.php" title="lien vers l'acceuil"><img src="img/home.png" alt="icone acceuil">Accueil</a></h1>

			<a href="home.php?deco=1">Deconnexion</a>
		</nav>

		<div id="center" class="marg">
			<h2>Bienvenue <?php echo $_SESSION['rss']['name']." ".$_SESSION['rss']['lastname']?></h2>

			<div class="sections"><a href="edition.php">Editer mes informations</a></div>

			<div class="sections"><a href="gestionFlux.php">Gerer mes flux</a></div>

			<div class="sections"><a href="readFlux">Consulter mes Flux</a></div>
		</div>

	</div>



</body>
</html>	