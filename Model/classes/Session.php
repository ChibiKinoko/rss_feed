<?php
/**
 * Session.php
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
 * Class Session
 *
 * Classe gerant l'ouverture et la fermeture de session ainsi que la redirection
 * si la session['user'] est inexistante
 *
 * @category Model
 * @package  Model
 * @author   zahir_d / pade_m / meng-b_l / thorna_c <ninjaturle@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:8080/Projet_Web_tweet_academie/model/classes
 */

class Session
{
    /**
    * Construct
    * 
    * Ouvre une session
    */
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
    * CoOrNot
    * 
    * Check si une session['user'] est ouverte sinon redirection signup_login
    *
    * @return none;
    */
    public function coOrNot()
    {
        if (!isset($_SESSION['user']['id_user'])) {
            header('Location: login_signup.php');

        }
    }

    /**
    * RedirectionLoginSignUp
    * 
    * Check si une session['user'] est interdit la page loginSignUp
    *
    * @return none;
    */
    public function redirectionLoginSignUp()
    {
        if (isset($_SESSION['user']['id_user'])) {
            header('Location: index.php');

        }
    }

    /**
    * Destroy
    * 
    * Detruit session lors de la deconnexion
    *
    * @return none;
    */
    public function destroy()
    {
        session_destroy();

        header('Location : login_signup.php');
    }
}

?>