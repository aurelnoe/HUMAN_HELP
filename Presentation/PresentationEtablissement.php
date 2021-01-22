<?php
function formulairesEtablissement($tabAffichageFormEtablissement,$etablissement=null,$message=null) 
{
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <?php include("../../head.php"); ?>
        </head> 
    <body>
        <?php
            echo navbar();
            $allPays = $tabAffichageFormEtablissement['allPays'];
            $action = $tabAffichageFormEtablissement['action'];
            $idEtablissement = isset($tabAffichageFormEtablissement['idEtablissement']) ? $tabAffichageFormEtablissement['idEtablissement'] : '';
            $idUtilisateur = isset($tabAffichageFormEtablissement['idUtilisateur']) ? $tabAffichageFormEtablissement['idUtilisateur'] : $etablissement->getIdUtilisateur();
        ?>
        <div class="col-12 col-md-6 formEtablissement container p-4 mb-5 borderGreen rounded">

            <h2 class="text-center my-2 pb-2"><?php echo $tabAffichageFormEtablissement['title']; ?></h2>

            <?php
                if ($message) {
                    echo '<div class="alert alert-danger w-100 text-center">'.$message.'</div>';
                }
            ?>
            <div id="msg_erreur"></div>

            <form class="needs-validation p-3" id="formEtablissement" role="form" action=<?php echo ($action=='update') ? "/HUMAN_HELP/Controller/MissionsController/listeMissionProController.php?action=updateEtablissement&idEtablissement=$idEtablissement" 
                                                                                                                        : "/HUMAN_HELP/Controller/MissionsController/listeMissionProController.php?action=$action" ?> 
                                                                                                                        method="POST">
                <input type="hidden" name="idEtablissement" value="<?php echo $idEtablissement ?>">
                <input type="hidden" name="idUtilisateur" value="<?php echo $idUtilisateur; ?>">

                <hr class="my-4 hrGreenLight">

                <div class="mb-3 form-group">
                    <label for="denomination">Dénomination de l'établissement</label>
                    <input type="text" class="form-control" name="denomination" placeholder="" value="<?php echo ($action=='update') ? $etablissement->getDenomination() : '';?>">
                    <div class="invalid-feedback">
                        Ce champ est requis.
                    </div>
                </div>
                <!--id_utilisateur à récupérer en GET apres connexion avant ajout -->
                
                <div class="mb-3 form-group">
                    <label for="mailEtablissement">Adresse mail</label>
                    <input name="mailEtablissement" type="mail" class="form-control" placeholder="" value="<?php echo ($action=='update') ? $etablissement->getMailEtablissement() : ''; ?>" required>
                    <div class="invalid-feedback">
                        Ce champ est requis.
                    </div>
                </div> 
                <div class="mb-3 form-group">
                    <label for="telEtablissement">Téléphone</label>
                    <input name="telEtablissement" type="number" class="form-control" placeholder="" value="0<?php echo ($action=='update') ? $etablissement->getTelEtablissement() : ''; ?>" required>
                    <div class="invalid-feedback">
                        Ce champ est requis.
                    </div>
                </div> 
                <div class="mb-3 form-group">
                    <label for="adresseEtablissement">Numéro et libellé de la voie</label>
                    <input type="text" class="form-control" name="adresseEtablissement" placeholder="" value="<?php echo ($action == 'update') ? utf8_encode($etablissement->getAdresseEtablissement()) :''; ?>" required>
                    <div class="invalid-feedback">
                        Ce champ est requis.
                    </div>
                </div> 
                <div class="row">
                    <div class="col-12 col-md-5 form-group">
                        <label for="villeEtablissement">Ville</label>
                        <input type="text" class="form-control" name="villeEtablissement" placeholder="" value="<?php echo ($action=='update') ? $etablissement->getVilleEtablissement() : ''; ?>" required>
                        <div class="invalid-feedback">
                            Ce champ est requis.
                        </div>
                    </div> 
                    <div class="col-12 offset-md-2 col-md-5 form-group">
                        <label for="code_postalEtablissement">Code postal</label>
                        <input type="number" class="form-control" name="codePostalEtablissement" placeholder="" value="<?php echo ($action=='update') ? $etablissement->getCodePostalEtablissement() : ''; ?>" required>
                        <div class="invalid-feedback">
                            Ce champ est requis.
                        </div>
                    </div>            
                </div>
                <div class="row p-0 mb-3">
                    <div class="form-group col-12 col-md-6 w-50 pl-3">
                        <label class="h-50" for="idPays">Pays concerné</label>
                        <select type="number" name="idPays" class="custom-select list-group d-block h-50 w-100" required>
                            <option class="list-group-item" value="<?php echo ($action=='update') ? $etablissement->getIdPays() : ''; ?>">
                                <p class="pl-5"><?php echo ($_GET['action']=='update') ? searchNamePaysById($etablissement->getIdPays()) : 'Choisissez...' ?></p>
                            </option>
                            <?php foreach ($allPays as $pays) : ?>
                                <option value="<?php echo $pays->getIdPays(); ?>" class="list-group-item">
                                    <?php echo utf8_encode($pays->getNomPays()); ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">
                            Choisissez un pays valide.
                        </div>
                    </div>
                </div>
                
                <hr class="my-4 hrGreenLight">
                
                <button class="btn btnGreen btn-lg btn-block mb-5" type="submit"><?php echo $tabAffichageFormEtablissement['titleBtn'];?></button>
            </form>
            <div class=" text-center m-auto">
                <a href="/HUMAN_HELP/Controller/MissionsController/listeMissionProController.php" class="btn btn-primary w-50">
                    Retour à votre espace Pro
                </a>   
            </div>
        </div>

        <?php      
        echo footer();
        ?>
    </body>
    </html>
    <?php
}
?>