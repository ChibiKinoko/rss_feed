<?php
/**
 * Edition.php
 *
 * Page permettant l'edition des infos utilisateur
 *
 * PHP Version 5.2
 *
 * @category View
 * @package  View
 * @author   meng-b_l <laure.meng-boyer@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     hhttp://localhost:8080/PHP_Avance_RSS_Feed/View
 */

include '../Model/classes/Session.php';
include '../Controller/Check.php';

$session = new Session;
$session->coOrNot();

$check = new Check;

if (isset($_POST['submitModif'])) {
	$erreur = $check->checkModif();
} elseif (isset($_POST['submitPwd'])) {
	$erreur = $check->checkPwd();
}

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

		<div id="center" class="marg edition">
			<h2>Edition de mes informations</h2>
			<?php
			if (!empty($erreur)) {
				foreach ($erreur as $elem) {
					?>
					<p class="erreur"><?php echo $elem; ?></p>
					<?php
				}
			}
			?>

			<div>
				<h3>Mes donnees</h3>

				<form method="POST" action="edition.php">
					<label for="nom">Nom :</label>
					<input type="text" name="nom" id="nom" value="<?php echo $_SESSION['rss']['lastname']?>"/>

					<label for="prenom">Prenom :</label>
					<input type="text" name="prenom" id="prenom" value="<?php echo $_SESSION['rss']['name']?>">

					<label for="email">Email :</label>
					<input type="email" name="email" id="email" value="<?php echo $_SESSION['rss']['email']?>"/>

					<input type="submit" name="submitModif" id="submitModif" value="modifier" />
				</form>
			</div>

			<div>
				<h3>Changer mon mot de passe</h3>

				<form method="POST" action="edition.php">
					<label for="oldpwd">Ancien :</label>
					<input type="password" name="oldpwd" id="oldpwd"/>

					<label for="newpwd">Nouveau :</label>
					<input type="password" name="newpwd" id="newpwd"/>

					<label for="confirm">Confirmez :</label>
					<input type="password" name="confirm" id="confirm"/>

					<input type="submit" name="submitPwd" id="submitPwd" value="changer mon mot de passe"/>
				</form>
			</div>
		</div>

	</div>

	

</body>
</html>	