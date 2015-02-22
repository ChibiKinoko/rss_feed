<?php
/**
 * ReadFlux.php
 *
 * Page permettant la lecture des flux
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
$erreur = $check->checkDisplayFlux();

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
			<div class="marg">
				<h1><a href="home.php" title="lien vers l'acceuil"><img src="img/home.png" alt="icone acceuil">Accueil</a></h1>

				<a href="home.php?deco=1">Deconnexion</a>
			</div>
		</nav>

		<div id="center" class="marg">
			<h2>Consulter un flux</h2>
			<?php
			if (!empty($erreur[0])) {
				foreach ($erreur[0] as $elem) {
					?>
					<p class="erreur"><?php echo $elem; ?></p>
					<?php
				}
			}
			?>

			<div id="choice">
				<form method="POST" action="readFlux.php">
					<label for="selectFlux">Selectionnez un flux : </label>

					<select name="selectFlux" id="selectFlux">
						<option value="none">--Aucun--</option>

						<?php
						foreach ($listFlux as $flux) {			

							?>
							<option value="<?php echo $flux['id_flux']; ?>" 
								<?php if ((isset($_POST['selectFlux']) && $_POST['selectFlux'] == $flux['id_flux']) || (isset($_GET['flux']) && $_GET['flux'] == $flux['id_flux'])) { 
									echo "selected";
								}
								?>><?php echo $flux['name_flux']; ?>
							</option>
							<?php
						}
						?>
					</select>

					<input type="submit" name="displayFlux" id="displayFlux" value="Ok"/>
				</form>
			</div>

			<?php
			if (!empty($erreur[1][0])) {
				?>
				<div id="result">
					<?php
					foreach ($erreur[1][0] as $actu) {

						?>
						<article>
							<header><h3><?php echo $actu->title; ?></h3></header>
							<p><?php echo $actu->description; ?></p>
							<p><a href="<?php echo $actu->link; ?>">Lire l'article &rarr;</a></p>
							<footer>Publie le : <?php $date = strftime("%Y-%m-%d %H:%M:%S", strtotime($actu->pubDate)); echo $date; ?></footer>
						</article>
						<?php
					}
					?>
				</div>
				<div id="arrow">
					<?php
					$currentPage = $erreur[1][2];
					$nbPages = $erreur[1][1];
					if($currentPage < $nbPages)
					{
						?>
						<a href='<?php echo "?flux="; if (isset($_POST['selectFlux'])) echo $_POST['selectFlux']; elseif(isset($_GET['flux'])) echo $_GET['flux']; echo "&amp;page=" . ($currentPage+1); ?>' class="next" title="lien vers la page suivante">Suivant &rarr;</a>
						<?php
					}
					if($currentPage > 1)
					{
						?>
						<a href="<?php echo "?flux="; if (isset($_POST['selectFlux'])) echo $_POST['selectFlux']; elseif(isset($_GET['flux'])) echo $_GET['flux']; echo  "&amp;page=" . ($currentPage-1); ?>" class="previous" title="lien vers la page précédente">&larr; Précédent</a>
						<?php
					}
					?>
				</div>
				<div class="clear"></div>
				<?php
			}
			?>

		</div>

	</div> <!-- Fin du main -->


</body>
</html>	