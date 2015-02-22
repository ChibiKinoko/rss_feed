<?php
/**
 * GestionFlux.php
 *
 * Page permettant la gestion des flux de l'utilisateur
 *
 * PHP Version 5.2
 *
 * @category View
 * @package  View
 * @author   meng-b_l <laure.meng-boyer@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     hhttp://localhost:8080/PHP_Avance_RSS_Feed/View
 */

include '../Controller/Check.php';

$session = new Session;
$session->coOrNot();

$check = new Check;
if (isset($_POST['submitUrl'])) {
	$erreur = $check->checkUrl();
} elseif (isset($_POST['deleteFlux'])) {
	$erreur = $check->checkDeleteFlux();
}

$user = new User;
$listFlux = $user->selectFlux();

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
			<h2>Gestionnaire de flux</h2>
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
				<h3>Ajouter un flux</h3>

				<form method="POST" action="gestionFlux.php">
					<label for="url">Entrez une URL :</label>
					<input type="text" name="url" id="url" />

					<input type="submit" name="submitUrl" id="submitUrl" value="ajouter"/>
				</form>
			</div>

			<div>
				<h3>Supprimer un flux</h3>

				<form method="POST" action="gestionFlux.php">
					<select name="flux">
						<option value="none">--Choisir--</option>
						<?php
						foreach ($listFlux as $flux) {
							?>
							<option value="<?php echo $flux['id_flux']; ?>"><?php echo $flux['name_flux']; ?></option>
							<?php
						}
						?>
					</select>

					<input type="submit" name="deleteFlux" id="deleteFlux" value="supprimer"/>
				</form>
			</div>
		</div>

	</div>

	

</body>
</html>	