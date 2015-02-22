<?php
/**
 * Init.php
 *
 * PHP Version 5.2
 *
 * Fichier qui charge toutes les classes a chaque fois qu'on l'inclut
 *
 * @category Model
 * @package  Model
 * @author   meng-b_l <laure.meng-boyer@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:8080/PHP_Avance_RSS_Feed/Model/core
 */

// ouverture de la session dans le init.php

/*if (session_status() == PHP_SESSION_NONE) {
    session_start();
}*/

/*
require_once 'classes/Config.php';
require_once 'classes/Cookie.php';
require_once 'classes/Bdd.php';

au lieu d'inclure chaque page j'utilise une fonction qui include et changera automtiquement
le du dossier ou file ci celui ci est changer lors du projet 

*/

spl_autoload_register(
    function($class) {
        include_once '../Model/classes/' .$class. '.php';
    }
);

?>