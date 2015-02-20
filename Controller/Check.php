<?php
/**
 * Check.php
 *
 * PHP Version 5.2
 *
 * @category Controler
 * @package  Controler
 * @author   meng-b_l <laure.meng-boyer@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:8080/PHP_Avance_RSS_Feed
 */

require '../Model/core/init.php';

/**
 * Class Check
 *
 * Classe controllant les entree utilisateurs input
 * 
 * @category Controler
 * @package  Controler
 * @author   zahir_d / pade_m / meng-b_l / thorna_c <ninjaturle@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:8080/PHP_Avance_RSS_Feed
 */


class Check extends User
{
    /**
    * VerifSignIn
    *
    * Fonction controle les entree utilisateur lors de la connexion au site
    * 
    * @return array; contient les erreur survenue lors de la connexion au site
    */
    public function verifSignIn()
    {
        $send = true;
        $placeholder = array();
        $erreur = array();

        if (!empty($_POST['emailLogin']) && !empty($_POST['passwordLogin'])) {

            if (preg_match('/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/', $_POST['emailLogin'])) {

                $login = htmlspecialchars(addslashes($_POST['emailLogin']));
                //$donnees['login'] = "?";
                $placeholder[] = $login;
            } else {
                $erreur[] = "email incorrect.";
                $send = false;
            }
            if (preg_match("/[a-zA-Z0-9@\.;:!_\-^<>`]{6,}/", $_POST['passwordLogin'])) {

                $password = htmlspecialchars(addslashes($_POST['passwordLogin']));
                $password = sha1($password);
                //$donnees['password'] = "?";
                $placeholder[] = $password;
            } else {
                $erreur[] = "Mot de passe incorrect.";
                $send = false;
            }
            if ($send == true) {
                $placeholder[ ] = $login;
                $placeholder[] = $password;
                
                $connexion = new User();
                $erreur = $connexion->connexion($placeholder);
            }
        } else {
            $erreur[] = "Veuillez entre un login/email et mot de passe.";
            $send =  false;
        }

        return $erreur;
    }

    /**
    * VerifInscription
    *
    * Fonction qui controle les entree utilisateur lors de l'inscription
    * 
    * @return array; 
    */
    public function verifInscription()
    {
        $erreur = array();

        if (isset($_POST['nom']) && isset($_POST['password']) && isset($_POST['confirm']) && isset($_POST['prenom']) && isset($_POST['email'])) {

            $mdp = htmlspecialchars(addslashes($_POST['password']));
            $secondMdp = htmlspecialchars(addslashes($_POST['confirm']));
            if (preg_match('/[a-zA-Z0-9@\.;:!_\-^<>`]{6,}/', $mdp)) {

                if ($mdp == $secondMdp) {
                    $mdp = sha1($mdp);
                    $donnees["password"] = "?";
                    $placeholder[] = $mdp;  
                } else {
                    $erreur[] = "Les deux mots de passe ne correspondent pas !";
                    $mdp = false;
                }
            } else {
                $erreur[] = "Mot de passe invalide !";
                $mdp = false;
            }
            
            $prenom = htmlspecialchars(addslashes($_POST['prenom']));
            if (preg_match('/[a-zA-Z0-9@\.;:!_\-^<>`]{3,}/', $prenom)) {
                $donnees["f_name"] = "?";
                $placeholder[] = $prenom;               
            } else {
                $prenom = false;
                $erreur[] = "Prenom incorrect, minimum 3 caracteres.";
            }
            
            $nom = htmlspecialchars(addslashes($_POST['nom']));
            if (preg_match('/[a-zA-Z0-9@\.;:!_\-^<>`]{2,}/', $nom)) {
                $donnees["l_name"] = "?";
                $placeholder[] = $nom;
            } else {
                $nom = false;
                $erreur[] = "Nom incorrect, minimum 2 caracteres.";
            }
            
            $mail = htmlspecialchars(addslashes($_POST['email']));
            $occup = $this->_bdd->prepare('SELECT * FROM `user` WHERE `mail`= ?');
            $occup->bindValue(1, $mail, PDO::PARAM_STR);
            $result = $occup->execute();

            if ($result != false) {

                if (preg_match('/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/', $mail)) {
                    $donnees["mail"] = "?";
                    $placeholder[] = $mail;
                } else {
                    $erreur[] =  "Format de l'email invalide.";
                    $mail = false;
                }
            } else {
                $mail = false;
                $erreur[] = "Email deja utilise.";
            }

        }
        if ($mdp != false && $prenom != false && $nom != false && $mail != false) {

            $fullname = $nom." ".$prenom;
            $donnees['`fullname`'] = "?";
            $placeholder[] = $fullname;
            $key = sha1(date('c')); //generation de la clef d'activation
            $donnees['`key_activation`'] = "?";
            $placeholder[] = $key;

            $membre = new User();
            $membre->inscription($donnees, $placeholder);
        }

        return $erreur;

    }

    /**
    * VerifTweet
    *
    * Fonction qui controle les entree utilisateur lors d'un post de tweet
    *
    * @param int; $reply 
    * 
    * @return array; 
    */
    public function verifTweet($reply = null)
    {
        $erreur = array();
        $tweetErrone = "";

        if (!empty($_POST['content'])) {

            $length = strlen($_POST['content']);
            if ($length <= 140) {

                $tweeter = new Tweet();
                if (!isset($reply)) {
                    $tweeter->tweet();
                } else {
                    $tweeter->reply();
                }
            } else {
                $tweetErrone = $_POST['content'];
                $erreur[] = "140 caracteres depasses : ".$length." caracteres";
            }
        } else {
            $erreur[] = "Tweet vide.";
        }

        return array($erreur, $tweetErrone);
    }

}

?>