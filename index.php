<?php
/**
* Index du projet GSB
*
* PHP Version 7
*
* @category  PPE
* @package   GSB
* @author    beth sefer,Tsipora Schvarcz
 */

require_once 'includes/fct.inc.php';//require_once= ce kon a besoin en preliminaire (en premier).
require_once 'includes/class.pdogsb.inc.php';//pdo=base de données.
session_start();//session=une variable super globale, un tableau qui va pouvoir contenir plusieurs variables de types differents.
$pdo = PdoGsb::getPdoGsb();//on va chercher ds le navigator de la classe PdoGsb la fonction getPdoGsb. 
$estConnecte = estConnecte();//appele la fonction estconnecté() de fct.inc.php et on rentre la reponse de la fonction ds $estconnecté.
require 'vues/v_entete.php';//envoie vers l'entête.
$uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);
if ($uc && !$estConnecte) {
    $uc = 'connexion';
} elseif (empty($uc)) {
    $uc = 'accueil';
}
switch ($uc) {//lindex va verifier quel est l'uc et renvoie vers les pages correspondantes.
case 'connexion':
    include 'controleurs/c_connexion.php';
    break;
case 'accueil':
    include 'controleurs/c_accueil.php';
    break;
case 'gererFrais':
    include 'controleurs/c_gererFrais.php';
    break;
case 'etatFrais':
    include 'controleurs/c_etatFrais.php';
    break;
case 'deconnexion':
    include 'controleurs/c_deconnexion.php';
    break;
case 'validFrais':
    include 'controleurs/c_validFrais.php';
    break;
case 'suiviPaiement':
    include 'controleurs/c_suiviPaiement.php';
    break;
}
require 'vues/v_pied.php';
