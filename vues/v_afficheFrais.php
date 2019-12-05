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
   
<div class="col-md-4">
        <form action="index.php?uc=validFrais&action=afficheFrais" 
              method="post" role="form">
            
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
                        if ($unMois == $moisASelectionner) {
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
                <a href="index.php?uc=validFrais&action=validerMajFraisForfait" 
                <button class="btn btn-success" type="edit">Corriger</button></a>
                <a href="index.php?uc=validFrais&action=reinitialiserFrais"          
                <button class="btn btn-danger" type="reset">Reinitialiser</button></a>
            </fieldset>
    </div>
</div>
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

            <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
                <th><button class="btn btn-success" type="edit">Corriger</button>
                    <button class="btn btn-danger" type="reset">Reinitialiser</button></th>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
<h5>Nombre de justificatifs: <?php echo $nbJustificatifs ?><br><br></h5>
    <input id="ok" type="submit" value="Valider" class="btn btn-success" 
            role="button"></input>
    <button class="btn btn-danger" type="reset">Reinitialiser</button>
    </form>
    