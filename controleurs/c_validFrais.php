<?php
/**
 * Controleur validFrais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Tsipora Schvarcz
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idVisiteur = $_SESSION['idUtilisateur'];
$mois = getMois(date('d/m/Y'));
$moisPrecedent = getMoisPrecedent($mois);
$fichesCL = $pdo->ficheDuDernierMoisCL($moisPrecedent);
if (!$uc) {
    $uc = 'validFrais';
}
switch ($action) {
    case 'choixVM':
        $lesVisiteurs=$pdo->getLesVisiteurs();
        $lesCles1=array_keys($lesVisiteurs);
        $visiteurASelectionner=$lesCles1[0];
        $lesMois = getLesDouzeDerniersMois($mois);
        $lesCles2=array_keys($lesMois);
        $moisASelectionner=$lesCles2[0];
        if($fichesCL){
            include 'vues/v_listeVisiteursMois.php';
        }
        else{
            $pdo->clotureFiches($moisPrecedent);
            include 'vues/v_listeVisiteursMois.php';
            
        }
        break;
    case 'afficheFrais':
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        $lesVisiteurs=$pdo->getLesVisiteurs();
        $visiteurASelectionner=$idVisiteur;
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesMois = getLesDouzeDerniersMois($mois);
        $moisASelectionner=$leMois;
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        if(!is_array($lesInfosFicheFrais)){
            ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
            include 'vues/v_erreurs.php';
            include 'vues/v_listeVisiteursMois.php';
        }
        else{
            include 'vues/v_afficheFrais.php';
        }
        break;
    case 'validerMajFraisForfait':
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        $lesVisiteurs=$pdo->getLesVisiteurs();
        $visiteurASelectionner=$idVisiteur;
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesMois = getLesDouzeDerniersMois($mois);
        $moisASelectionner=$leMois;
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        var_dump($lesFrais);
        if (lesQteFraisValides($lesFrais)) {
                $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
                echo "la modification a bien été prise en compte";  
                $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
            } else {
                ajouterErreur('Les valeurs des frais doivent être numériques');
                include 'vues/v_erreurs.php';
            }
        include 'vues/v_afficheFrais.php';
        $ficheVA= $pdo->majEtatFicheFrais($idVisiteur, $mois, $etat);
        break;
    
}


