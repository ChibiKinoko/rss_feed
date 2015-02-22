<?php
/**
 * Bdd.php
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
 * Class Bdd
 *
 * Classe permettant le parsing des boutons sur le tweet, ainsi qu'un traitement
 *
 * @category Controler
 * @package  Controler
 * @author   meng-b_l <laure.meng-boyer@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:8080/PHP_Avance_RSS_Feed/controller
 */
class Bdd
{
    protected $bdd;

    /**
    * Construct
    *
    * Instancie un objet PDO
    *
    * @return none;
    */
    public function __construct()
    {
        try
        {
            $this->_bdd = new PDO('mysql:host=localhost;dbname=rss_feed;unix_socket=/home/meng-b_l/.mysql/mysql.sock', 'root', '');
        }
        catch(PDOException $e)
        {
            die('Erreur :' . $e->getMessage());  
        }
    }

    /**
    * Ajouter
    *
    * Fonction qui fait un INSERT INTO en fonction des parametre passes
    *
    * @param str;   $table       table BDD
    * @param array; $infos       champs BDD
    * @param array; $placeholder variables
    *
    * @return array;
    */
    public function ajouter($table, $infos, $placeholder)
    {
        $sql = "INSERT INTO " .$table . " (";

            foreach ($infos as $cle => $valeur) {
                $sql .=  $cle .", ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ") VALUES (";

            foreach ($infos as $value) {
                $sql .= $value . ", ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ")";

        //var_dump($sql);
        //var_dump($placeholder);
        //debug_print_backtrace();

$req = $this->_bdd->prepare($sql);
$send = $req->execute($placeholder);

return $send;   
}

    /**
    * VoirInfos
    *
    * Fonction qui fait un SELECT en fonction des parametre passes
    *
    * @param str;   $table       table BDD
    * @param array; $infos       champs BDD
    * @param array; $placeholder variables
    * @param str;   $condition   jointure
    *
    * @return array;
    */
    public function voirInfos($table, $infos, $placeholder, $condition)
    {
        $sql = "SELECT ";
        if (is_array($infos)) {

            foreach ($infos as $value) {
                $sql .= $value . ", ";
            }
            
            $sql = substr($sql, 0, -2);
        } else {
            $sql .= "*";
        }

        $sql .= " FROM ". $table;
        $sql .= $condition;

        $req = $this->_bdd->prepare($sql);
        $req->execute($placeholder);
        $result = $req->fetchAll();

        //echo '<pre>';
        //var_dump($sql);
        //var_dump($placeholder);
        //debug_print_backtrace();

        return $result;
    }

    /**
    * Modifier
    *
    * Fonction qui fait un UPDATE en fonction des parametre passes
    *
    * @param str;   $table       table BDD
    * @param array; $infos       champs BDD
    * @param array; $placeholder variables
    * @param str;   $condition   jointure
    *
    * @return array;
    */
    public function modifier($table, $infos, $placeholder, $condition)
    {
        $sql = "UPDATE " . $table . " SET ";
        foreach ($infos as $key => $value) {
            $sql .= $key .  " = ". $value . ", ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= $condition;

        //var_dump($sql);
        //var_dump($placeholder);

        $req = $this->_bdd->prepare($sql);
        $req->execute($placeholder);
    }

    /**
    * Pagination
    *
    * Fonction qui fait la pagination des affichage de flux
    *
    * @param array; $array tableau a decouper
    *
    * @return array;
    */
    public function pagination($array)
    {
        $limit = 10;

        if(isset($_GET['page'])) { // recupration de la page courante

            $currentPage = $_GET['page'];
        } else {
            $currentPage = 1; //remet sur page 1 si aucune page definie
        }

        $newTab = array_slice($array, ($currentPage - 1)*$limit, $limit);

        $nbPages = ceil(count($array)/$limit);

        /*echo "<pre>";
        var_dump($newTab);*/

        return array($newTab, $nbPages, $currentPage);
    }
}

?>