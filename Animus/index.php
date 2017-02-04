<?php

/*
 * Index.php - AnimusWebapp starting point
 * 
 */
    // Set constants

    define('_dispatch',	true);
    define('DOMROOT',dirname(__FILE__));    
    // Require AnimusRAD    
    require_once DOMROOT.'/classes/APICore/AnimusRAD.php';
    // Start AnimusWebApp
    AnimusRAD::startAnimusApp();
?>
