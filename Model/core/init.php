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
 * @author   zahir_d / pade_m / meng-b_l / thorna_c <ninjaturle@epitech.eu>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:8080/Projet_Web_tweet_academie/model/core
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