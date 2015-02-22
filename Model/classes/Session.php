<?php
/**
 * Session.php
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
 * Class Session
 *
 * Classe gerant l'ouverture et la fermeture de session ainsi que la redirection
 * si la session['user'] est inexistante
 *
 * @category Model
 * @package  Model
 * @author   meng-b_l <laure.meng-boyer@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:8080/PHP_Avance_RSS_Feed/Model/classes
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
        if (!isset($_SESSION['rss']['id_user'])) {
            header('Location: ../View/login.php');

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
        if (isset($_SESSION['rss']['id_user'])) {
            header('Location: ../View/home.php');

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

        header('Location: ../View/login.php');
    }
}

?>