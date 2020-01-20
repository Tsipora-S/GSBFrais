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
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        if (lesQteFraisValides($lesFrais)) {
                $pdo->majFraisForfait($idVisiteur, $leMois, $lesFrais);
                echo "La modification a bien été prise en compte.";  
        } else {
                ajouterErreur('Les valeurs des frais doivent être numériques');
                include 'vues/v_erreurs.php';
               }
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);  
        
        include 'vues/v_afficheFrais.php';
        break;
    case 'validerMajFraisHorsForfait':
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        $lesVisiteurs=$pdo->getLesVisiteurs();
        $visiteurASelectionner=$idVisiteur;
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesMois = getLesDouzeDerniersMois($mois);
        $moisASelectionner=$leMois;
        $dateHF=filter_input(INPUT_POST, 'dateHF', FILTER_SANITIZE_STRING);
        $montantHF=filter_input(INPUT_POST, 'montantHF', FILTER_SANITIZE_STRING);
        $libelleHF=filter_input(INPUT_POST, 'libelleHF', FILTER_SANITIZE_STRING);
        valideInfosFrais($dateHF, $libelleHF, $montantHF);
        if (nbErreurs() != 0) {
            include 'vues/v_erreurs.php';
        } else {
             $pdo->creeNouveauFraisHorsForfait(
                $idVisiteur,
                $leMois,
                $libelleHF,
                $dateHF,
                $montantHF
            );
        }
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        $nbJustificatifs = filter_input(INPUT_POST, 'nbJust', FILTER_SANITIZE_STRING);
        include 'vues/v_afficheFrais.php';
        break;
    case 'validerFiche':
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        $lesVisiteurs=$pdo->getLesVisiteurs();
        $visiteurASelectionner=$idVisiteur;
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesMois = getLesDouzeDerniersMois($mois);
        $moisASelectionner=$leMois;
        $nbJustificatifs = filter_input(INPUT_POST, 'nbJust', FILTER_SANITIZE_STRING);
        $etat='VA';
        $pdo->majEtatFicheFrais($idVisiteur, $leMois, $etat);
        $pdo->majNbJustificatifs($idVisiteur, $leMois, $nbJustificatifs);
        include 'vues/v_retourAccueil.php';
        break;
}


