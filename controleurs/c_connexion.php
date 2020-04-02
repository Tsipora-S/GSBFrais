<?php
/**
 * Gestion de la connexion
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    beth sefer,Tsipora Schvarcz
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);//va filtrer le contenu de 'action'.
if (!$uc) {
    $uc = 'demandeconnexion';
}

switch ($action) {
case 'demandeConnexion':
    include 'vues/v_connexion.php';
    break;
case 'valideConnexion':
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);//verifie si login et mdp sont remplis,si oui il met le nom, le prenom et l'id ds visiteur.
    $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);//INPUT_POST=ce que l'utilisateur entre.
    $visiteur = $pdo->getInfosVisiteur($login, $mdp);//$pdo represente la connexion entre php et la bdd.
    $comptable=$pdo->getInfosComptable($login, $mdp);
    if (!is_array($visiteur)&&!is_array($comptable))  {
       //!is_array veut dire n'est pas dans le tableau
       ajouterErreur('Login ou mot de passe incorrect');
       include 'vues/v_erreurs.php';
       include 'vues/v_connexion.php';
   } else {
       if (is_array($visiteur)){
       $id = $visiteur['id'];
       $nom = $visiteur['nom'];
       $prenom = $visiteur['prenom'];
       $statut='visiteur';}
       
       elseif (is_array($comptable)){
 
           $id = $comptable['id'];
           $nom = $comptable['nom'];
           $prenom = $comptable['prenom'];
           $statut='comptable';
       }
           connecter($id, $nom, $prenom,$statut);
           header('Location: index.php');
       }
   break;
default:
   include 'vues/v_connexion.php';
   break;
}