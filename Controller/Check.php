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
 * @author   meng-b_l <laure.meng-boyer@epitech.eu>
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

    /**
    * Construct
    * 
    * Reprend le construc de la classe Bdd et instancie PDO
    */
    public function __construct()
    {
        parent::__construct();
    }

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
                $donnees["name"] = "?";
                $placeholder[] = $prenom;               
            } else {
                $prenom = false;
                $erreur[] = "Prenom incorrect, minimum 3 caracteres.";
            }
            
            $nom = htmlspecialchars(addslashes($_POST['nom']));
            if (preg_match('/[a-zA-Z0-9@\.;:!_\-^<>`]{2,}/', $nom)) {
                $donnees["lastname"] = "?";
                $placeholder[] = $nom;
            } else {
                $nom = false;
                $erreur[] = "Nom incorrect, minimum 2 caracteres.";
            }
            
            $mail = htmlspecialchars(addslashes($_POST['email']));
            $occup = $this->_bdd->prepare('SELECT * FROM `user` WHERE `email`= ?');
            $occup->bindValue(1, $mail, PDO::PARAM_STR);
            $result = $occup->execute();

            if ($result != false) {

                if (preg_match('/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/', $mail)) {
                    $donnees["email"] = "?";
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

            $membre = new User();
            $membre->inscription($donnees, $placeholder);
        }

        return $erreur;
    }

    /**
    * checkModif
    *
    * Fonction qui controle les modification d'infos utilisateur
    * 
    * @return array; 
    */
    public function checkModif()
    {
        $send = true;
        if (!empty($_POST['nom'])) {
            if (!preg_match('/[a-zA-Z0-9@\.;:!_\-^<>`]{2,}/', $_POST['nom'])) {
                $send = false;
                $erreur[] = "Le nom doit contenir 2 caracteres minimum.";
            }
        } else {
            $send = false;
            $erreur[] = "Veuillez renseignez un nom.";
        }
        if (!empty($_POST['prenom'])) {
            if (!preg_match('/[a-zA-Z0-9@\.;:!_\-^<>`]{3,}/', $_POST['prenom'])) {
                $send = false;
                $erreur[] = "le prenom doit contenir 3 caracteres minimum";
            }
        } else {
            $send = false;
            $erreur[] = "Veuillez renseignez un prenom.";
        }

        if (!empty($_POST['email'])) {
            if($_SESSION['rss']['email'] != $_POST['email']) {
                $occup = $this->_bdd->prepare('SELECT * FROM `user` WHERE `email`= ?');
                $occup->bindValue(1, $_POST['email'], PDO::PARAM_STR);
                $result = $occup->execute();
                if ($result != false) {
                    if (!preg_match('/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/', $_POST['email'])) {
                        $send = false;
                        $erreur[] = "le mail doit etre au format xxxx@xxxx.xx";
                    } 
                } else {
                    $mail = false;
                    $erreur[] = "Email deja utilise.";
                }    
            }       
        } else {
            $send = false;
            $erreur[] = "Veuillez renseignez un email.";
        }

        if ($send != false) {
            $erreur = array();
            $infos = array("`name`" => "?", "`lastname`" => "?", "`email`" => "?");
            $placeholder = array(htmlspecialchars($_POST['prenom']), htmlspecialchars($_POST['nom']), htmlspecialchars($_POST['email']));
            $user = new User;
            $erreur = $user->modifInfos($infos, $placeholder);
        }
        return $erreur;
    }

    /**
    * CheckPwd
    *
    * Fonction qui controle le mot de passe avant sa modification
    * 
    * @return array; 
    */
    public function checkPwd()
    {
        $send = true;
        $erreur = array();
        if(!empty($_POST['oldpwd'])) {
            $req = $this->_bdd->prepare('SELECT * FROM `user` WHERE `id_user` = ? AND `password` = ?');
            $req->bindValue(1, $_SESSION['rss']['id_user'], PDO::PARAM_INT);
            $req->bindValue(2, sha1($_POST['oldpwd']), PDO::PARAM_STR);
            $result = $req->execute();
            $occup = $req->fetch();

            if($occup == false)
            {
                $send = false;
                $erreur[] = "Votre ancien mot de passe ne correspond pas.";
            }

        } else {
            $send = false;
            $erreur[] = "Veuillez saisir votre ancien mot de passe.";
        }
        if (!empty($_POST['newpwd'])) {
            if (!preg_match('/[a-zA-Z0-9@\.;:!_\-^<>`]{6,}/', $_POST['newpwd'])) {
                $send = false;
                $erreur[] = "Votre mot de passe doit contenir 6 caracteres minimum";
            }
        } else {
            $send = false;
            $erreur[] = "Veuillez saisir un nouveau mot de passe.";
        }
        if (!empty($_POST['confirm'])) {
            if (!preg_match('/[a-zA-Z0-9@\.;:!_\-^<>`]{6,}/', $_POST['confirm'])) {
                $send = false;
                $erreur[] = "Votre mot de passe doit contenir 6 caracteres minimum";
            } else {
                if ($_POST['newpwd'] != $_POST['confirm']) {
                    $send = false;
                    $erreur[] = "Les deux mot de passe ne correspondent pas.";
                }
            }
        } else {
            $send = false;
            $erreur[] = "Veuillez confirmez votre mot de passe.";
        }

        if ($send != false) {
            $infos = array("`password`" => "?");
            $placeholder = array(sha1($_POST['confirm']));
            $user = new User;
            $erreur = $user->modifPwd($infos, $placeholder);
        }
        return $erreur;
    }

    /**
    * CheckUrl
    *
    * Fonction qui controle le mot de passe avant sa modification
    * 
    * @return array; 
    */
    public function checkUrl()
    {
        $send = true;
        libxml_use_internal_errors();

        if (!empty($_POST['url'])) {
            $extension = substr($_POST['url'], -4, 4);
            if ($extension != ".xml") {
                $send = false;
                $erreur[] = "L'url doit etre au format .xml";
            }
            $xml = simplexml_load_file($_POST['url']);
            if ($xml == false) {
                $send = false;
                $erreur[] = "Une erreur s'est produite, veuillez reessayer.";
            } else {
                $erreur2 = libxml_get_errors();
                if (!empty($erreur2)) {
                    $send = false;
                    $erreur[] = "Une erreur s'est produite, veuillez reessayer.";
                }
            }
        } else {
            $send = false;
            $erreur[] = "Veuillez entrer une URL";
        }
        
        if ($send != false) {
            $user = new User;
            $erreur = $user->addFlux();
        }

        return $erreur;
    }

    /**
    * CheckDeleteFlux
    *
    * Fonction qui controle la suppression de flux
    * 
    * @return array; 
    */
    public function checkDeleteFlux()
    {
        if ($_POST['flux'] != "none") {
            $user = new User;
            $erreur = $user->deleteFlux();
        } else {
            $erreur[] = "Veuillez selectionner un flux.";
        }
        return $erreur;
    }

}

?>