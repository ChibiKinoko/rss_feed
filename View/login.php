<?php
/**
 * Login.php
 *
 * Page de connexion/inscription
 *
 * PHP Version 5.2
 *
 * @category View
 * @package  View
 * @author   meng-b_l <laure.meng-boyer@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:8080/PHP_Avance_RSS_Feed
 */

require'../Controller/Check.php';

if (isset($_POST['submitLogin'])) {
    $co = new Check();
    $erreur = $co->verifSignIn();
} elseif (isset($_POST['submitRegister'])) {
    $inscription = new Check();
    $erreur = $inscription->verifInscription();
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
        </nav>

        <div id="center" class="marg">
            <?php
            if (!empty($erreur))
            {
                foreach ($erreur as $elem) {
                    ?>
                    <p class="erreur"><?php echo $elem; ?></p>
                    <?php
                }
            }
            ?>
            <div id="left">
                <p><span>"L'information est un flux illimité dans un espace limité." </span> <em>Joêl Dicker</em></p>
                <p>Toute votre actualite en une seul clic :</p>
                <p>c'est par ici !</p>

                <form method="POST" action="login.php" id="login">
                    <label for="email">Email :</label>
                    <input type="text" name="emailLogin" id="email"/>

                    <label>Mot de passe :</label>
                    <input type="password" name="passwordLogin" id="password"/>

                    <button type="submit" name="submitLogin" id="submitLogin">OK</button>
                    <div class="clear"></div>
                </form>
            </div>

            <form method="POST" action="login.php" id="register">
                <label>Nom :</label>
                <input type="text" name="nom"/>

                <label>Prenom :</label>
                <input type="text" name="prenom"/>

                <label>Email :</label>
                <input type="email" name="email"/>

                <label>Mot de passe :</label>
                <input type="password" name="password">

                <label>Confirmation :</label>
                <input type="password" name="confirm"/>

                <button type="submit" name="submitRegister" id="submitRegister">S'inscrire</button>
            </form>
            <div class="clear"></div>
        </div>
    </div>

</body>
</html> 