<?php
/**
 * Vue Affichage de Frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Tsipora Schvarcz
 */
?>

<form method="post" 
              action="index.php?uc=validFrais&action=validerMajFraisForfait" 
              role="form">
<div class="col-md-4">
            
            <?php//liste déroulante des visiteurs?>
            
            <div class="form-group" style="display: inline-block"> 
                <label for="lstVisiteurs" accesskey="n">Choisir le visiteur : </label>
                <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
                    <?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $id = $unVisiteur['id'];
                        $nom = $unVisiteur['nom'];
                        $prenom = $unVisiteur['prenom'];
                        if ($id == $visiteurASelectionner) {
                            ?>
                            <option selected value="<?php echo $id ?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $id ?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </div>
            
            <?php//liste déroulante des mois?>
            
            &nbsp;<div class="form-group" style="display: inline-block">
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($lesMois as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        if ($mois == $moisASelectionner) {
                            ?>
                            <option selected value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </div>  
        
</div><br><br><br><br> 

<div class="row">    
    <h2 style="color:orange">&nbsp;Valider la fiche de frais</h2>
    <h3>&nbsp;&nbsp;Eléments forfaitisés</h3>
    <div class="col-md-4">  
        
            <fieldset>
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite']; ?>
                    <div class="form-group">
                        <label for="idFrais"><?php echo $libelle ?></label>
                        <input type="text" id="idFrais" 
                               name="lesFrais[<?php echo $idFrais ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $quantite ?>" 
                               class="form-control">
                    </div>
                    <?php
                }
                ?> 
                <button class="btn btn-success" type="submit">Corriger</button>       
                <button class="btn btn-danger" type="reset">Reinitialiser</button>
            </fieldset>
        
    </div>
</div>
</form>

<hr>
 

<div class="panel panel-info-me">
    <div class="panel-heading">Descriptif des éléments hors forfait </div>
    <table class="table table-bordered table-responsive">
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>
            <th></th>
        </tr>
        <?php
        foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
            $date = $unFraisHorsForfait['date'];
            $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
            $montant = $unFraisHorsForfait['montant']; ?>
            <form method="post" 
                  accept-charset=""action="index.php?uc=validFrais&action=validerMajFraisHorsForfait" 
                  accesskey=""role="form">
                <input name="lstMois" type="hidden" id="lstMois" class="form-control" value="<?php echo $moisASelectionner ?>">
                <input name="lstVisiteurs" type="hidden" id="lstVisiteurs" class="form-control" value="<?php echo $visiteurASelectionner ?>">
            
                <tr>
                    <td><input name="dateHF" type="text" id="txtDateHF" class="form-control" value="<?php echo $date ?>"></td>
                    <td><input name="libelleHF" type="text" id="txtLibelleHF" class="form-control" value="<?php echo $libelle ?>"></td>
                    <td><input name="montantHF" type="text" id="txtMontantHF" class="form-control" value="<?php echo $montant ?>"></td>
                    <input id="id"  name="FraisHorsForfait[<?php echo $id ?>]" value="<?php echo $id ?>" type="hidden">  <!-- pour pouvoir recuperer tous les id et ansi modifier chaque champ selon son id -->
                    <th><button class="btn btn-success" type="edit" name="corriger" value="corriger">Corriger</button>
                        <button class="btn btn-danger" type="reset">Reinitialiser</button>
                    </th>
                    <td>
                        <button class="btn btn-success" type="submit" name="refuser" value="refuser" onclick="return confirm('Voulez-vous vraiment refuser ce frais?');">Refuser</button>
                        <button class="btn btn-danger" type="submit" name="reporter" value="reporter" onclick="return confirm('Voulez-vous vraiment reporter ce frais?');">Reporter</button>    
                    </td>               
                </tr>
            </form>
        <?php
        }
        ?>
    </table>
</div>
                    
<form method="post" 
              action="index.php?uc=validFrais&action=validerFiche" 
              role="form">
    <input name="lstMois" type="hidden" id="lstMois" class="form-control" value="<?php echo $moisASelectionner ?>">
    <input name="lstVisiteurs" type="hidden" id="lstVisiteurs" class="form-control" value="<?php echo $visiteurASelectionner ?>">
      Nombre de justificatifs: <input type="text" id="nbJust" name="nbJust" class="form-control-me" value="<?php echo $nbJustificatifs ?>"><br><br> 
    <input id="ok" type="submit" value="Valider" class="btn btn-success" 
            role="button">
    <button class="btn btn-danger" type="reset">Reinitialiser</button>
</form>
    