<?php
/**
 * User.php
 *
 * PHP Version 5.2
 *
 * @category Model
 * @package  Model
 * @author   meng-b_l <laure.meng-boyer@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:8080/PHP_Avance_RSS_Feed
 */

/**
 * Class User
 *
 * Classe qui gere tout le traitement relatif a un user
 *
 * @category Model
 * @package  Model
 * @author   meng-b_l <laure.meng-boyer@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:8080/PHP_Avance_RSS_Feed/Model/classes/
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
        $condition = " WHERE `email` = ? AND `password` = ? ";
        $donnees = parent::voirInfos($table, $infos, $placeholder, $condition);

        if (!empty($donnees)) {

            foreach ($donnees as $elem) {

                $_SESSION['rss']['id_user'] = $elem['id_user'];
                $_SESSION['rss']['name'] = $elem['name'];
                $_SESSION['rss']['lastname'] = $elem['lastname'];
                $_SESSION['rss']['email'] = $elem['email'];
            }

            header('Location: ../View/home.php');
        
        } else {
            $erreur[] = "Email et/ou mot de passe faux.";
        }

        //var_dump($erreur);

        return $erreur;
    }

    /**
    * ModifInfos
    *
    * Modifie les infos utilisateurs
    *
    * @param array; $infos       tableau des champs
    * @param array; $placeholder tableau des placeholder
    *
    * @return array;
    */
    public function modifInfos($infos, $placeholder)
    {
        $table = "`user`";
        $placeholder[] = $_SESSION['rss']['id_user'];
        $condition = " WHERE `id_user` = ?";
        parent::modifier($table, $infos, $placeholder, $condition);
        $erreur[] = "Informations modifiees.";

        $_SESSION['rss']['name'] = $placeholder[0];
        $_SESSION['rss']['lastname'] = $placeholder[1];
        $_SESSION['rss']['email'] = $placeholder[2];
        return $erreur;
    }

    /**
    * ModifPwd
    *
    * Modifie le mot de passe utilisateur
    *
    * @param array; $infos       tableau des champs
    * @param array; $placeholder tableau des placeholder
    *
    * @return array;
    */
    public function modifPwd($infos, $placeholder)
    {
        $table = "`user`";
        $placeholder[] = $_SESSION['rss']['id_user'];
        $condition = " WHERE `id_user` = ?";
        parent::modifier($table, $infos, $placeholder, $condition);
        $erreur[] = "Mot de passe modifie.";

        return $erreur;
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
        $placeholder[] = $_SESSION['rss']['id_user'];
        $condition = " WHERE `id_user` = ?";
        parent::modifier($table, $infos, $placeholder, $condition);

        $session = new Session();
        $session->destroy();

        header('Location: ../view/index.php');
    }

}

?>