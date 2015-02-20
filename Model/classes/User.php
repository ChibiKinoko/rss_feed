<?php
/**
 * User.php
 *
 * PHP Version 5.2
 *
 * @category Model
 * @package  Model
 * @author   zahir_d / pade_m / meng-b_l / thorna_c <ninjaturle@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:8080/Projet_Web_tweet_academie
 */

/**
 * Class User
 *
 * Classe qui gere tout le traitement relatif a un user
 *
 * @category Model
 * @package  Model
 * @author   zahir_d / pade_m / meng-b_l / thorna_c <ninjaturle@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:8080/Projet_Web_tweet_academie/model/classes/
 */
class User extends Bdd
{
    /**
    * Construct
    * 
    * Reprend le construc de la classe Bdd et instancie PDO
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Inscription
    *
    * @param array; $infos       tableau des champs
    * @param array; $placeholder tableau des placeholder
    *
    * @return array;
    */
    public function inscription($infos, $placeholder)
    {
        $erreur = array();
        $table = "`user`";
        $send = parent::ajouter($table, $infos, $placeholder);

        if ($send != false) {

            $clef = $infos['key_activation'];
            $mail = $infos['mail'];

            $url = "http://localhost:8080/Projet_Web_tweet_academie/view/activate.php?clef=".$clef;
            $msg = "Pour confirmer votre inscription veuillez cliquez sur le lien suivant : ".$url;

            mail($mail, "Confirmation inscription Tweet_Academie", $msg);

            header('Location: ../view/confirmation.php');

            //auto following
            $login = $placeholder[0];
            $table = "`user`";
            $infos = array('`id_user`');
            $placeholder2[] = $login;
            $condition = " WHERE `login` = ?";
            $recup = parent::voirInfos($table, $infos, $placeholder2, $condition); //recuperation id
            
            foreach ($recup as $elem) {
                $id = $elem['id_user'];
            }

            $infos2['`follows`'] = "?";
            $placeholder3 = array($id, $id); 
            $condition2 = " WHERE `id_user` = ?";
            parent::modifier($table, $infos2, $placeholder3, $condition2); //insertion de l'id dans follows

            $table = "`followers`";
            $infos4['id_user'] = "?";
            $infos4['id_follower'] = "?";
            parent::ajouter($table, $infos4, $placeholder3); //insertion dans la table followers

        } else {
            $erreur[] = "Une erreur est survenue, veuillez réessayer plus tard.";
        }

        return $erreur;
    }

    /**
    * Connexion
    *
    * @param array; $placeholder tableau des placeholder
    *
    * @return array;
    */
    public function connexion($placeholder)
    {
        $erreur = array();
        $table = "`user`";
        $infos = "*";
        $condition = " WHERE (`login` = ? AND `password` = ? AND `activate` = 1) OR (`mail` = ? AND `password` = ? AND `activate` = 1)";
        $donnees = parent::voirInfos($table, $infos, $placeholder, $condition);

        if (!empty($donnees)) {

            foreach ($donnees as $elem) {

                $_SESSION['user']['id_user'] = $elem['id_user'];
                $_SESSION['user']['login'] = $elem['login'];
            }

            header('Location: ../view/index.php');
        
        } else {
            $erreur[] = "Login/email et/ou mot de passe faux.";
        }

        //var_dump($erreur);

        return $erreur;
    }

    /**
    * AfficheInfos
    *
    * Affiche toutes les infos d'un user
    *
    * @param int; $id select l'id pour les infos profil
    *
    * @return array;
    */
    public function afficheInfos($id = null)
    {
        $table = "`user`";
        $infos = "*";
        
        if (isset($id)) {

            $placeholder[] = $_GET['id'];
        
        } else {

            $placeholder[] = $_SESSION['user']['id_user'];
        }
        $condition = "WHERE `id_user` = ?";
        $infos = parent::voirInfos($table, $infos, $placeholder, $condition);

        foreach ($infos as $elem) {

            $login = $elem['login'];
            $date_register = $elem['date_register'];
            $bio = $elem['biography'];
        }

        $donnees = array($login, $date_register, $bio);

        return $donnees;
    }

    /**
    * CompteInfos
    *
    * Fonction qui compte le nombre de tweet, de follows et de followers
    *
    * @param int; $id select l'id pour les infos profil
    *
    * @return array;
    */
    public function compteInfos($id = null)
    {
        $table = "`tweet`";
        $infos[] = "COUNT(`id_tweet`) AS nbTweet";
        
        if (isset($id)) {
            $placeholder[] = $_GET['id'];
        
        } else {

            $placeholder[] = $_SESSION['user']['id_user'];
        }
        $condition = " LEFT JOIN `user` ON `tweet`.`id_user` = `user`.`id_user` WHERE `tweet`.`id_user` = ? AND `tweet`.`activate` = 1";
        $donnees = parent::voirInfos($table, $infos, $placeholder, $condition);
        
        foreach ($donnees as $elem) {

            $nbTweet = $elem['nbTweet'];
        }

        $table = "`followers`";
        $infos2[] = "COUNT(`id_follower`) AS nbFollowers";
        $condition2 = " WHERE `id_user` = ?";
        $donnees2 = parent::voirInfos($table, $infos2, $placeholder, $condition2);
        
        foreach ($donnees2 as $elem) {

            $nbFollowers = $elem['nbFollowers'] - 1; // exclu l'auto following
        }

        $table = "`user`";
        $infos3[] = "`follows` AS nbFollows";
        $donnees3 = parent::voirInfos($table, $infos3, $placeholder, $condition2);
        
        foreach ($donnees3 as $elem) {

            $nbFollows = $elem['nbFollows'];
        }
        $nbFollows = explode(";", $nbFollows);

        $number = count($nbFollows); // exclu l'auto following

        if ($nbFollows[0] == "" || $number == 1) {
            $nombreFollows = 0;

        } else {
            $nombreFollows = count($nbFollows) - 1;
        }

        return array($nbTweet, $nbFollowers, $nombreFollows);
    }
    

    /**
    * ModifierInfosGenerales
    *
    * Fonction qui enregistre les modification de profil dans la BDD
    *
    * @param array; $placeholder variables
    *
    * @return none
    */
    public function modifierInfosGenerales($placeholder)
    {
        $table ="user";
        $infos = ["`biography`" => "?", "`mail`" => "?", "`f_name`" => "?", "`l_name`"=>"?", "login"=>"?"] ;
        $condition = " WHERE `id_user` = ?";
        parent::modifier($table, $infos, $placeholder, $condition);
    }

    /**
    * FollowOrNot
    *
    * Fonction check si on follow ou non un autre user
    *
    * @return array
    */
    public function followOrNot()
    {
        $table = "`user`";
        $infos = array('`follows`');
        $condition = ' WHERE `id_user` = ?';
        $placeholder[] = $_SESSION['user']['id_user'];

        $follows = parent::voirInfos($table, $infos, $placeholder, $condition);

        foreach ($follows as $elem) {

            $listFollows = $elem['follows'];
        }

        if (!empty($listFollows)) {

            $allFollows = explode(';', $listFollows);
        
        } else {

            $allFollows = array();
        }

        return $allFollows;
    }

    /**
    * Follow
    *
    * Fonction qui permet de follow un user
    *
    * @return none
    */
    public function follow()
    {
        $listFollows = self::followOrNot();
        $listFollows[] = $_GET['id'];

        //var_dump($listFollows);

        $newList = implode(";", $listFollows);

        $table = "`user`";
        $infos['`follows`'] = "?";
        $placeholder = array($newList, $_SESSION['user']['id_user']);
        $condition = " WHERE `id_user` = ?";

        parent::modifier($table, $infos, $placeholder, $condition);

        $table = "`followers`";
        $infos2 = array('`id_user`' => "?", "`id_follower`" => "?");
        $placeholder2 = array($_GET['id'], $_SESSION['user']['id_user']);

        parent::ajouter($table, $infos2, $placeholder2);
    }

    /**
    * Unfollow
    *
    * Fonction qui permet de unfollow un user
    *
    * @return none
    */
    public function unFollow()
    {
        //echo "<script>alert(\"Unfollow !!!!\")</script>";
        $listFollows = self::followOrNot();

        foreach ($listFollows as $elem) {

            if ($elem != $_GET['id']) {
                $newList[] = $elem;
            }
        }

        $newListFollows = implode(";", $newList);

        $table = "`user`";
        $infos['`follows`'] = "?";
        $placeholder = array($newListFollows, $_SESSION['user']['id_user']);
        $condition = " WHERE `id_user` = ?";

        parent::modifier($table, $infos, $placeholder, $condition);

        $sql = "DELETE FROM `followers` WHERE `id_user` = ? AND `id_follower` = ?";
        $unFollow = $this->_bdd->prepare($sql);
        $unFollow->bindValue(1, $_GET['id'], PDO::PARAM_INT);
        $unFollow->bindValue(2, $_SESSION['user']['id_user'], PDO::PARAM_INT);
        $unFollow->execute();
    }

    /**
    * AfficheFollowers
    *
    * Fonction qui affiche tous les followers
    *
    * @return array
    */
    public function afficheFollowers()
    {
        $table = "`user`";
        $infos = array("`user`.`id_user`", "`login`");
        $condition = " LEFT JOIN `followers` ON `followers`.`id_follower` = `user`.`id_user` WHERE `followers`.`id_user` = ?";
        
        if (isset($_GET['id'])) {

            $placeholder[] = $_GET['id'];
        
        } else {
         
            $placeholder[] = $_SESSION['user']['id_user'];
        }
        $abones = parent::voirInfos($table, $infos, $placeholder, $condition);

        return $abones;

    }

    /**
    * AfficheFollows
    *
    * Fonction qui affiche tous les follows
    *
    * @return array
    */
    public function afficheFollows()
    {
        $table = "`user`";
        $infos = array("`user`.`id_user`", "`login`");
        $condition = " LEFT JOIN `followers` ON `followers`.`id_user` = `user`.`id_user` WHERE `followers`.`id_follower` = ?";
        
        if (isset($_GET['id'])) {

            $placeholder[] = $_GET['id'];
        
        } else {

            $placeholder[] = $_SESSION['user']['id_user'];
        }
        $abones = parent::voirInfos($table, $infos, $placeholder, $condition);

        return $abones;
    }

    /**
    * ActivateCompte
    *
    * Fonction qui active le compte apres ouverture du lien envoye par mail
    *
    * @param str $clef clef d'activation
    *
    * @return none
    */
    public function activateCompte($clef)
    {
        $table = "`user`";
        $infos['activate'] = "1";
        $now = date('Y-m-d G:i:s');
        $infos['date_register'] = "?";
        $placeholder[] = $now;
        $placeholder[] = $clef;
        $condition = " WHERE `key_activation` = ?";

        parent::modifier($table, $infos, $placeholder, $condition);

    }

    /**
    * SupprimerCompte
    *
    * Fonction qui desactive le compte
    *
    * @return none
    */
    public function supprimerCompte()
    {
        $table = "`user`";
        $infos['`activate`'] = 0;
        $placeholder[] = $_SESSION['user']['id_user'];
        $condition = " WHERE `id_user` = ?";
        parent::modifier($table, $infos, $placeholder, $condition);

        $session = new Session();
        $session->destroy();

        header('Location: ../view/index.php');
    }

}

?>