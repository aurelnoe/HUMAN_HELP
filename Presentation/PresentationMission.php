<?php 

function listeMissionsPro($missions,$etablissementPro=null,$utilisateur,$page,$pages,$errorCode=null,$message=null):void
{
    if ($errorCode) {
        if($errorCode == 1062){     //Error add mission
            $message = "La mission existe déja dans la base de données!";
            echo "<div class='alert alert-danger text-center'>Code : $errorCode,\n Message : $message</div>";
        }
        else if($errorCode == 1042){    //Connexion not found
            $message = "Un problème est survenue, veulliez réessayer ultérieurement.";
            echo "<div class='alert alert-danger text-center'>Code : $errorCode,\n Message : $message</div>";
        } 
        else if($errorCode == 9997){    //Missions pro not found
            echo "<div class='alert alert-danger text-center'>Code : $errorCode,\n Message : $message</div>";
        } 
        else if($errorCode == 9999){    //Error mission not found
            echo "<div class='alert alert-danger text-center'>Code : $errorCode,\n Message : $message</div>";
        }  
    }
    if(!$errorCode && $errorCode == 1027){
        $message = "L'établissement n'a pas était modifié, une erreur est survenue.";
        echo "<div class='alert alert-danger text-center'>Code : $errorCode,\n Message : $message</div>";
    }
    echo $errorCode;
    ?>
    <div class="container">
        <hr class="hrGreen mx-3 my-4">
        <div class="p-3">
            <h2>Etablissement :</h2>
            <hr class="hrTitreListeMission">
            <div class="row p-3">
                <div class="col-12 col-md-4">
                    <p><strong>Dénomination :</strong> <br><?php echo $etablissementPro->getDenomination();?></p>
                    <p><strong>Adresse mail :</strong> <br><?php echo $etablissementPro->getMailEtablissement();?></p>
                    <p><strong>Téléphone établissement:</strong> <br>0<?php echo $etablissementPro->getTelEtablissement();?></p>
                </div>
                <div class="col-12 col-md-4">
                    <p><strong>Responsable :</strong> <br><?php echo $utilisateur->getPrenomUtil(). ' ' .$utilisateur->getNomUtil();?></p>
                    <p><strong></strong></p>
                    <p><strong>Téléphone professionnel :</strong> <br>0<?php echo $utilisateur->getTelUtil();?></p>
                </div>
                <div class="col-12 col-md-4">
                    <h4><strong>Adresse :</strong></h4>
                    <div class="pl-1">
                        <p class="my-3"><strong>Libellé voie :</strong> <?php echo $etablissementPro->getAdresseEtablissement();?></p>
                        <p><strong>Ville :</strong> <?php echo $etablissementPro->getVilleEtablissement();?></p>
                        <p><strong>Pays :</strong> <?php searchNamePaysById($etablissementPro->getIdPays()); ?> (<?php searchContinentById($etablissementPro->getIdPays()); ?>)</p>
                    </div>
                </div>
            </div>
            <div class="col-10 col-md-6 m-auto">
                <a class="btn btnGreen w-100 my-4" href="/HUMAN_HELP/?q=EtablissementsController/formulaireEtablissementController?action=update&idEtablissement=<?php echo $etablissementPro->getIdEtablissement(); ?>">
                    Modifier les informations de l'établissement
                </a>
            </div>
        </div>
        <hr class="hrGreen mx-4 my-4">
        <h2 class="text-center mt-5">Liste de vos missions :</h2>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <?php if ($page > 1): ?>
                <li class="page-item <?php if ($page < $pages): ?>disabled<?php endif ?>">
                    <?php //PAGINATION
                    $link="/HUMAN_HELP/?q=MissionsController/listeMissionProController"; 
                    if ($page > 2) $link .= '?page=' . ($page - 1);
                    ?>
                    <a class="page-link" href="<?= $link ?>" tabindex="-1">
                        Précedente
                    </a>
                </li>
                <?php endif ?>
                <?php for ($i=1;$i<$pages+1;$i++) : ?>
                    <li class="page-item">
                        <a class="page-link" href="/HUMAN_HELP/?q=MissionsController/listeMissionProController?page=<?php echo $i + 1; ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor ?>
                
                <li class="page-item <?php if ($page > 1): ?>disabled<?php endif ?>">
                    <a class="page-link" href="/HUMAN_HELP/?q=MissionsController/listeMissionProController?page=<?php echo $page + 1; ?>">
                        Suivante
                    </a>
                </li>
            </ul>
        </nav>
        <div class="card-group w-100">
            <div class="row mx-0 my-3 w-100">
            <?php foreach($missions as $mission): ?>
                <div class="col-12 col-md-6 col-lg-5 m-auto my-3">
                    <div class="card cardListeMissionPro h-100 mx-auto">
                        <div class="imageMissionDiv rounded" style="background-image: url('data:image/png;base64,<?php echo $mission->getImageMission(); ?>');"></div>
                        <div class="card-body">
                            <h5 class="card-title"><strong>Titre : </strong><?php echo ucfirst(utf8_encode($mission->getTitreMission())); ?></h5>
                            <p class="card-text"><strong>Type d'activité : </strong><?php echo searchNameTypeActivityById($mission->getIdTypeActivite()); ?></p>
                            <p class="card-text"><strong>Pays : </strong><?php searchNamePaysById($mission->getIdPays()); ?> (<?php echo searchContinentById($mission->getIdPays()); ?>)</p>
                            <p class="card-text"><strong>Date de début : </strong><?php echo $mission->getDateDebut()->format('d-m-Y'); ?></p>
                        </div>
                        <div class="card-footer">
                            <div class="row m-auto">
                                <a href="/HUMAN_HELP/?q=MissionsController/detailsMissionController&idMission=<?php echo $mission->getIdMission(); ?>" 
                                    class="col-12 col-md-5 btn btn-primary my-1 w-100">
                                    Voir la mission
                                </a>
                                <a href="/HUMAN_HELP/?q=MissionsController/listeMissionProController?action=delete&idMission=<?php echo $mission->getIdMission(); ?>"  
                                    class="col-12 col-md-5 btn btn-danger my-1 w-100">
                                    Supprimer
                                </a>
                            </div>                    
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            </div>                     
        </div>

        <hr class="my-4">

        <div class="col-10 col-md-6 m-auto">
            <a class="btn btnGreen w-100 mb-4" href="/HUMAN_HELP/?q=MissionsController/formulairesMissionController?action=add&idEtablissement=<?php echo $etablissementPro->getIdEtablissement();?>">
                Ajouter une nouvelle mission
            </a>
        </div>

    </div>
  <?php
}

function searchMission($missions,$tabAffichSearchMission=null,$errorCode=null)
{
?>
    <div class="container text-center ">
        <?php
        if($errorCode == 1062){
            $message = "Un problème est survenu lors de la recherche";
            echo "<div class='alert alert-danger text-center'>Code : $errorCode,\n Message : $message</div>";
        }
        ?>
        <h1 class="h1-select"><?php echo $tabAffichSearchMission['title']; ?></h1>
        
        <hr class="my-4 hrGreen ">

        <nav aria-label="Page navigation example">
            <?php 
            $page = $tabAffichSearchMission['page']; //$_GET['page']
            $pages = $tabAffichSearchMission['pages']; //countPages
            $getIdTypeActivite = ($_GET['idTypeActivite']) ?? null;
            $getIdPays = ($_GET['idPays']) ?? null;
            ?>
            <ul class="pagination justify-content-end">
                <?php if ($page > 1): ?>
                    <li class="page-item <?php if ($page < $pages): ?>disabled<?php endif ?>">
                        <?php //PAGINATION
                        $link="/HUMAN_HELP/?q=MissionsController/searchMissionsController?idPays=$getIdPays&idTypeActivite=$getIdTypeActivite"; 
                        if ($page > 2) $link .= '&page=' . ($page - 1);
                        ?>
                        <a class="page-link" href="<?php echo $link; ?>" tabindex="-1">
                            Précedente
                        </a>
                    </li>
                <?php endif ?>
                <?php for ($i=0;$i<$pages;$i++) : ?>
                    <li class="page-item">
                        <a class="page-link" href="/HUMAN_HELP/?q=MissionsController/searchMissionsController?idPays=<?php echo $getIdPays; ?>&idTypeActivite=<?php echo $getIdTypeActivite; ?>&page=<?php echo $i + 1; ?>">
                            <?= $i + 1?>
                        </a>
                    </li>
                <?php endfor ?>
                <li class="page-item <?php if ($page > 1): ?>disabled<?php endif ?>">
                    <a class="page-link" href="/HUMAN_HELP/?q=MissionsController/searchMissionsController?idPays=<?php echo $getIdPays; ?>&idTypeActivite=<?php echo $getIdTypeActivite; ?>&page=<?php echo $page + 1; ?>">
                        Suivante
                    </a>
                </li>
            
            </ul>
        </nav>
        
        <?php
            if (!empty($missions)) 
            {   ?>
                <div class="card-group my-4">
                    <div class="row mx-0 my-2 m-auto w-100">
                    <?php
                    foreach ($missions as $mission) {
                        ?>
                        <div class="card card-select col-12 col-md-5">
                            <div class="card-body">
                                <div class="imageMissionDiv rounded" style="background-image: url('data:image/png;base64,<?php echo $mission->getImageMission(); ?>');"></div>
                                <div class="text-card-select">
                                    <div class="text-center mx-auto my-1">
                                        <h2 class="my-2">Titre de la mission</h2>
                                        <p><?php echo $mission->getTitreMission(); ?>
                                        </p>
                                    </div>
                                    <div class="text-center mx-auto my-1">
                                        <h2 class="my-2">Description</h2>
                                        <p><?php echo $mission->getDescriptionMission(); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="detailsMissionController?idMission=<?php echo $mission->getIdMission();?>" class="btn btn-primary my-1 col-12 col-md-6">
                                    Détails de la mission
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    </div>            
                </div>
            <?php
            }else {
            ?>
                <div class="my-3 py-3 text-center">Pas de mission dans la catégorie recherchée pour le moment</div>
            <?php
            }
            ?>  

        <a href="listeMissionController" class="btn btnGreen w-50 my-3">Retour à la liste des missions</a>

    </div>
<?php
}

function listeMissions($professionnel,$errorCode=null,$message=null)
{
    if ($errorCode) {
        if($errorCode == 9999){    //Error mission not found
            echo "<div class='alert alert-danger text-center'>Code : $errorCode,\n Message : $message</div>";
        }  
    }
    ?>
    <div class="container p-0">

        <?php
        if($professionnel)
        {   ?>
            <div class="col-12 col-md-4 m-auto">
                <a href="/HUMAN_HELP/?q=MissionsController/listeMissionProController?idUtilisateur=" class="button btn btnGreen w-100 my-2">
                    Consulter mes missions
                </a>
            </div>
        <?php
        }
        ?>
        
        <div class="col-12 col-md-4 m-auto">
            <div class="btn-group btnTypeFormation w-100 my-2">
                <div class="btn w-75">
                    <strong>Type de formation</strong>
                </div>
                <div class="dropdown">
                    <a class="btn btnGreen dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">          
                        <a class="dropdown-item" href="searchMissionsController?typeFormation=<?php echo A_DISTANCE; ?>">
                            <strong> à distance</strong>
                        </a>
                        <a class="dropdown-item" href="searchMissionsController?typeFormation=<?php echo SUR_LE_TERRAIN; ?>">
                            <strong> sur le terrain</strong>
                        </a>
                    </div>
                </div>
            </div>  
        </div>

        <hr class="my-4 hrGreenLight">
        
        <h1 class="my-5 px-3">Trouver ma mission humanitaire</h1>

        <hr class="hrTitreListeMission ml-3">

        <div class="p-3">
            <p>
                Human Helps vous propose tout types de missions humanitaires que se soit à distance ou sur le terrain et dans tous les secteurs.
            </p>
            <p>
                Vous souhaitez donner de votre temps, de vos vacances et participer à une mission humanitaire ou réaliser votre stage dans un cadre humanitaire sérieux, alors votre candidature nous intéresse.
            </p>
            <p>
                Si vous étiez venus chercher un voyage humanitaire, vous repartirez avec une mission concrète à effectuer pour aider les populations que nous soutenons.
            </p>
            <p>
                Vous intégrerez alors des équipes bénévoles (médicales, paramédicales ou chantiers humanitaires) pour une mission humanitaire de 15 jours ou un stage de plusieurs mois.            </div>
            </p>

        <hr class="my-4 hrGreenLight">

        <!-- CAROUSEL --------------------------------------------------------------------------->
        <div class="col-12 border rounded p-0">
            <div id="carouselMedecine" class="carousel carouselListeMission slide" data-ride="carousel" data-interval="10000">
                
                <ol class="carousel-indicators">
                    <?php 
                    $medecines=searchMissions(null,ID_MEDECINE,null,1);
                    foreach ($medecines as $key => $medecine) {
                        ?>
                        <li data-target="#carouselMedecine" data-slide-to="<?php echo $key; ?>"
                        <?php echo ($key==0) ? 'class="active"' : '' ?>></li>
                        <?php
                    } ?>
                </ol>
                <div class="text-center mx-auto my-1">
                    <a class="button btn pb-1 w-50" href="searchMissionsController?idTypeActivite=<?php echo ID_MEDECINE; ?>">
                        <h3>Médecine</h3>
                    </a>
                </div>
                <div class="carousel-inner w-100">
                        <?php
                        if (!empty($medecines)) {
                            foreach ($medecines as $key => $medecine) 
                            {
                                ?>                  
                                <div class="carousel-item <?php echo ($key==0) ? 'active' : ''; ?> mb-5">
                                    <div class="card cardListeMission col-10 col-md-6 p-0">
                                        <div class="imageMissionDiv rounded" style="background-image: url('data:image/png;base64,<?php echo $medecine->getImageMission(); ?>');"></div>
                                        <div class="card-body">
                                            <h5 class="card-title">Titre : <?php echo utf8_encode($medecine->getTitreMission()); ?></h5>
                                            <p class="card-text">Type d'activité : <?php searchNameTypeActivityById($medecine->getIdTypeActivite()); ?></p>
                                            <p class="card-text">Pays : <?php searchNamePaysById($medecine->getIdPays()); ?> (<?php searchContinentById($medecine->getIdPays()); ?>)</p>
                                            <p class="card-text">Date de début : <?php echo $medecine->getDateDebut()->format('d-m-Y'); ?></p>
                                        </div>                   
                                        <div class="card-footer">
                                            <a href="?q=MissionsController/detailsMissionController?idMission=<?php echo $medecine->getIdMission(); ?>" class="btn btn-primary">
                                            Voir la mission
                                            </a>
                                        </div>                 
                                    </div>
                                </div>
                            <?php  
                            } ?>
                            <div class="row my-4 mx-0">
                                <a class="carousel-control-prev" href="#carouselMedecine" role="button" data-slide="next">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselMedecine" role="button" data-slide="prev">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>                   
                        <?php
                        }else {
                        ?>
                            <div class="my-5 py-5 text-center">Pas de mission dans la catégorie médecine pour le moment</div>
                        <?php
                        }
                        ?>
                </div>
            </div>
        </div>

        <hr class="my-4 hrGreenLight">

        <div class="col-12 border rounded p-0">
            <div id="carouselDonations" class="carousel carouselListeMission slide" data-ride="carousel" data-interval="10000">
                <ol class="carousel-indicators">
                    <?php 
                    $donations=searchMissions(null,ID_DONATION,null,1);
                    foreach ($donations as $key => $donation) {
                        ?>
                        <li data-target="#carouselDonations" data-slide-to="<?php echo $key; ?>"
                        <?php echo ($key==0) ? 'class="active"' : '' ?>></li>
                        <?php
                    } ?>
                </ol>
                <div class="text-center mx-auto my-1">
                    <a class="button btn pb-1 w-50" href="searchMissionsController?idTypeActivite=<?php echo ID_DONATION; ?>">
                        <h3>Donations</h3>
                    </a>
                </div>
                
                <div class="carousel-inner w-100">

                    <?php 
                    if (!empty($donations)) {
                        foreach ($donations as $key => $donation) {
                        ?>
                        <div class="carousel-item <?php echo ($key==0) ? 'active' : ''; ?> mb-5">
                            <div class="card-group">
                                <div class="card cardListeMission col-10 col-md-6 p-0">
                                    <div class="imageMissionDiv rounded" style="background-image: url('data:image/png;base64,<?php echo $donation->getImageMission(); ?>');"></div>
                                    <div class="card-body">
                                        <h5 class="card-title">Titre : <?php echo utf8_encode($donation->getTitreMission()); ?></h5>
                                        <p class="card-text">Type d'activité : <?php searchNameTypeActivityById($donation->getIdTypeActivite()); ?></p>
                                        <p class="card-text">Pays : <?php echo searchNamePaysById($donation->getIdPays()); ?> (<?php searchContinentById($donation->getIdPays()); ?>)</p>
                                        <p class="card-text">Date de début : <?php echo $donation->getDateDebut()->format('d-m-Y'); ?></p>                                        
                                    </div>
                                    <div class="card-footer">
                                        <a href="detailsMissionController?idMission=<?php echo $donation->getIdMission(); ?>" class="btn btn-primary">
                                            Voir la mission
                                        </a>
                                    </div>
                                </div>                  
                            </div>
                        </div>
                        <?php  
                        }
                        ?>
                        <div class="row my-4">
                            <a class="carousel-control-prev" href="#carouselDonations" role="button" data-slide="next">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselDonations" role="button" data-slide="prev">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    <?php
                    }else {
                        ?>
                        <div class="my-3 py-3 text-center">Pas de mission dans la catégorie donation pour le moment</div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <hr class="my-4 hrGreenLight">

        <div class="col-12 border rounded p-0">
            <div id="carouselEnseignement" class="carousel carouselListeMission slide" data-ride="carousel" data-interval="10000">
                <ol class="carousel-indicators">
                    <?php 
                    $enseignements=searchMissions(null,ID_ENSEIGNEMENT,null,1);
                    foreach ($enseignements as $key => $enseignement) {
                        ?>
                        <li data-target="#carouselEnseignement" data-slide-to="<?php echo $key; ?>"
                        <?php echo ($key==0) ? 'class="active"' : '' ?>></li>
                        <?php
                    } ?>
                </ol>
                <div class="text-center mx-auto my-1">
                    <a class="button btn pb-1 w-50" href="searchMissionsController?idTypeActivite=<?php echo ID_ENSEIGNEMENT; ?>">
                        <h3>Enseignement</h3>
                    </a>
                </div>
                <div class="carousel-inner w-100">
                    <?php 
                    if (!empty($enseignements)) {
                        
                        foreach ($enseignements as $key => $enseignement) {
                        ?>
                            <div class="carousel-item <?php echo ($key==0) ? 'active' : ''; ?> mb-5">
                                <div class="card cardListeMission col-10 col-md-6 p-0">
                                    <div class="imageMissionDiv rounded" style="background-image: url('data:image/png;base64,<?php echo $enseignement->getImageMission(); ?>');"></div> 
                                    <div class="card-body">
                                        <h5 class="card-title">Titre : <?php echo utf8_encode($enseignement->getTitreMission()); ?></h5>
                                        <p class="card-text">Type d'activité : <?php searchNameTypeActivityById($enseignement->getIdTypeActivite()); ?></p>
                                        <p class="card-text">Pays : <?php searchNamePaysById($enseignement->getIdPays()); ?> (<?php searchContinentById($enseignement->getIdPays()); ?>)</p>
                                        <p class="card-text">Date de début : <?php echo $enseignement->getDateDebut()->format('d-m-Y'); ?></p>                                        
                                    </div>
                                    <div class="card-footer">
                                        <a href="detailsMissionController?idMission=<?php echo $donation->getIdMission(); ?>" class="btn btn-primary">
                                            Voir la mission
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        }
                        ?>
                        <div class="row my-4">
                            <a class="carousel-control-prev" href="#carouselEnseignement" role="button" data-slide="next">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselEnseignement" role="button" data-slide="prev">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    <?php
                    }else {
                    ?>
                        <div class="my-3 py-3 text-center">Pas de mission dans la catégorie enseignement pour le moment</div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <hr class="my-4 hrGreenLight">

        <div class="col-12 border rounded p-0">
            <div id="carouselConstructions" class="carousel carouselListeMission slide" data-ride="carousel" data-interval="10000">
                
                <ol class="carousel-indicators">
                    <?php 
                    $constructions=searchMissions(null,ID_CONSTRUCTION,null,1);
                    foreach ($constructions as $key => $construction) {
                        ?>
                        <li data-target="#carouselConstructions" data-slide-to="<?php echo $key; ?>"
                        <?php echo ($key==0) ? 'class="active"' : '' ?>></li>
                        <?php
                    } ?>
                </ol>
                <div class="text-center mx-auto my-1">
                    <a class="button btn pb-1 w-50" href="searchMissionsController?idTypeActivite=<?php echo ID_CONSTRUCTION; ?>">
                        <h3>Construction</h3>
                    </a>
                </div>
                <div class="carousel-inner w-100">
                        <?php
                    if (!empty($constructions)) 
                    {
                        foreach ($constructions as $key => $construction) 
                        {   ?>                  
                            <div class="carousel-item <?php echo ($key==0) ? 'active' : ''; ?> mb-5">
                                <div class="card cardListeMission col-10 col-md-6 p-0">
                                <div class="imageMissionDiv rounded" style="background-image: url('data:image/png;base64,<?php echo $construction->getImageMission(); ?>');"></div>
                                    <div class="card-body">
                                        <h5 class="card-title">Titre : <?php echo utf8_encode($construction->getTitreMission()); ?></h5>
                                        <p class="card-text">Type d'activité : <?php searchNameTypeActivityById($construction->getIdTypeActivite()); ?></p>
                                        <p class="card-text">Pays : <?php searchNamePaysById($construction->getIdPays()); ?> (<?php searchContinentById($construction->getIdPays()); ?>)</p>
                                        <p class="card-text">Date de début : <?php echo $construction->getDateDebut()->format('d-m-Y'); ?></p>
                                    </div>                   
                                    <div class="card-footer">
                                        <a href="detailsMissionController?idMission=<?php echo $construction->getIdMission(); ?>" class="btn btn-primary">
                                            Voir la mission
                                        </a>
                                    </div>                 
                                </div>
                            </div>
                        <?php 
                        }
                        ?>
                        <div class="row my-4 mx-0">
                            <a class="carousel-control-prev" href="#carouselConstructions" role="button" data-slide="next">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselConstructions" role="button" data-slide="prev">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div> 
                    <?php                  
                    }else {
                        ?>
                        <div class="my-3 py-3 text-center">Pas de mission dans la catégorie construction pour le moment</div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <hr class="my-4 hrGreenLight">

        <div class="col-12 border rounded p-0">
            <div id="carouselTraductions" class="carousel carouselListeMission slide" data-ride="carousel" data-interval="10000">
                
                <ol class="carousel-indicators">
                    <?php 
                    $traductions=searchMissions(null,ID_TRADUCTION,null,1);
                    foreach ($traductions as $key => $traduction) {
                        ?>
                        <li data-target="#carouselTraductions" data-slide-to="<?php echo $key; ?>"
                        <?php echo ($key==0) ? 'class="active"' : '' ?>></li>
                        <?php
                    } ?>
                </ol>
                <div class="text-center mx-auto my-1">
                    <a class="button btn pb-1 w-50" href="searchMissionsController?idTypeActivite=<?php echo ID_TRADUCTION; ?>">
                        <h3>Traductions</h3>
                    </a>
                </div>
                <div class="carousel-inner w-100">
                    <?php
                    if (!empty($traductions)) {
                        foreach ($traductions as $key => $traduction) 
                        {
                            ?>                  
                            <div class="carousel-item <?php echo ($key==0) ? 'active' : ''; ?> mb-5">
                                <div class="card cardListeMission col-10 col-md-6 p-0">
                                <div class="imageMissionDiv rounded" style="background-image: url('data:image/png;base64,<?php echo $traduction->getImageMission(); ?>');"></div>
                                    <div class="card-body">
                                        <h5 class="card-title">Titre : <?php echo utf8_encode($traduction->getTitreMission()); ?></h5>
                                        <p class="card-text">Type d'activité : <?php searchNameTypeActivityById($traduction->getIdTypeActivite()); ?></p>
                                        <p class="card-text">Pays : <?php searchNamePaysById($traduction->getIdPays()); ?> (<?php searchContinentById($traduction->getIdPays()); ?>)</p>
                                        <p class="card-text">Date de début : <?php echo $traduction->getDateDebut()->format('d-m-Y'); ?></p>
                                    </div>                   
                                    <div class="card-footer">
                                        <a href="detailsMissionController?idMission=<?php echo $traduction->getIdMission(); ?>" class="btn btn-primary">
                                            Voir la mission
                                        </a>
                                    </div>                 
                                </div>
                            </div>
                        <?php  
                        }       
                        ?>             
                        <div class="row my-4 mx-0">
                            <a class="carousel-control-prev" href="#carouselTraductions" role="button" data-slide="next">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselTraductions" role="button" data-slide="prev">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div> 
                        <?php                  
                    }else 
                    {   ?>
                        <div class="my-3 py-3 text-center">Pas de mission dans la catégorie traduction pour le moment</div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <hr class="my-4 hrGreenLight">
    </div>
<?php
}

function detailsMission($mission,$professionnel,$errorCode=null,$message=null)
{
    if($errorCode!=null && $errorCode == 1027){
        $message = "La mission n'a pas était modifiée, une erreur est survenue.";
        echo "<div class='alert alert-danger text-center'>Code : $errorCode,\n Message : $message</div>";
    } else if(isset($errorCode) && $errorCode == 9958) {
        echo "<div class='alert alert-success text-center'>$message</div>";
    }
    ?>
    <div class="container justify-content p-4">

        <h2 class="text-center my-4">Détails de la mission</h2>

        <hr class="my-4 hrGreenLight">
        <!-- section image details -->
        <div class="row">
            <div class="col-10 col-md-5 my-2 mx-auto p-0">
                <div class="imageMissionDiv rounded" style="background-image: url('data:image/png;base64,<?php echo $mission->getImageMission(); ?>');"></div>
                <hr class="hrGreen">
            </div>
            <div class="col-10 col-md-6 my-4">
                <ul class="liDetailsMission">
                    <li><strong>Titre de la mission :</strong> <?php echo utf8_encode($mission->getTitreMission()); ?></li>
                    <li><strong>Type d'activité :</strong> <?php searchNameTypeActivityById($mission->getIdTypeActivite()); ?></li>
                    <li><strong>Mission :</strong> <?php echo ($mission->getTypeFormation() == 0) ? 'à distance' : 'sur le terrain'; ?></li>
                    <li><strong>Pays :</strong> <?php searchNamePaysById($mission->getIdPays()); ?> (<?php searchContinentById($mission->getIdPays()); ?>)</li>
                    <li><strong>Organisateur :</strong> <?php searchDenominationById($mission->getIdEtablissement()); ?></li>
                    <li><strong>Durée de la mission :</strong> <?php echo $mission->getDuree(); ?> jours</li>
                    <li><strong>Date début :</strong> <?php echo $mission->getDateDebut()->format('d-m-Y'); ?></li>
                </ul>
            </div>
        </div>

        <hr class="my-4 hrGreenLight">

        <h2 class="my-4">Description :</h2>

        <div class="my-4"><?php echo $mission->getDescriptionMission(); ?></div>
            
        <hr class="my-4 hrGreenLight">

        <!-- COMMENTAIRES -->
        <div class="my-4">

            <h2 class="my-4">Commentaires :</h2>

            <div class="row border billet">
                <div class="col-12 col-md-4">
                    <strong>@Maurice</strong>, 38 ans, Montpellier:<br>
                    Le 27/10/2020 11:59
                </div>
                <div class="col-12 my-2 col-md-8">
                    <div class="row">
                        <div class="col-1 p-0">
                            "
                        </div>
                        <div class="col-10 p-0">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sed, temporibus doloremque? Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                        </div>
                        <div class="col-1 p-0">
                            "
                        </div>
                    </div>
                </div>            
            </div>
            
            <div class="row border billet">
                <div class="col-12 col-md-4">
                    <strong>@Bob</strong>, 72 ans, Toulouse:<br>
                    Le 01/11/2020 22:36
                </div>
                <div class="col-12 my-2 col-md-8">
                    <div class="row">
                        <div class="col-1 p-0">
                            "
                        </div>
                        <div class="col-10 p-0">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sed, temporibus doloremque? 
                        </div>
                        <div class="col-1 p-0">
                            "
                        </div>
                    </div>
                </div>            
            </div>

        </div>
        <!-- BOUTONS -->
        <hr class="mb-4 hrGreenLight">

        <div class="row mb-4">
            <div class="col-12 col-md-5 my-2">
                <a href="/HUMAN_HELP/?q=CommentCaMarcheController/CommentCaMarcheController?idMission=<?php echo $mission->getIdMission();?>" class="btn btnGreen w-100">
                    Comment y participer ?
                </a>
            </div>
            <div class="col-12 offset-md-2 col-md-5 my-2">
                <a href="/HUMAN_HELP/?q=ContactController/contactController" class="btn btnGreen w-100">
                    contactez nous
                </a>
            </div>
        </div>
        <?php
        if ($professionnel) 
        {
        ?>
            <div class="row mb-4">
                <div class="col-12 col-md-4 my-2">
                    <a href="/HUMAN_HELP/?q=MissionsController/formulairesMissionController?action=update&idMission=<?php echo $mission->getIdMission();?>" class="btn btn-primary w-100">
                        Modifier
                    </a>
                </div>
                <form class="col-12 col-md-4 my-2" action="?action=delete" method="POST">
                    <button type="submit" class="btn btn-danger w-100">
                        Supprimer
                    </button>
                </form>
                <div class="col-12 col-md-4 my-2">
                    <a href="/HUMAN_HELP/?q=MissionsController/listeMissionProController" class="btn btn-primary w-100">
                        Mes missions
                    </a>
                </div>
            </div>
        <?php  
        }
        ?>
        <div class="col-12 my-2 px-0">
            <a href="/HUMAN_HELP/?q=MissionsController/listeMissionController" class="btn btnGreen w-100">
                Retour à la liste des missions
            </a>
        </div>
        
    </div>
    <?php
}

function formulairesMission(array $tabAffichageFormMission,$mission=null,$message=null)
{
    $action = $tabAffichageFormMission['action'];
    $idMission = $tabAffichageFormMission['idMission'];
    $idEtablissement = $tabAffichageFormMission['idEtablissement'];
    ?>
    <div class="col-12 col-md-6 container pt-4 my-4 borderGreen rounded">

        <h2 class="text-center my-2 pb-2"><?php echo $tabAffichageFormMission['title']; ?></h2>

        <?php
            if ($message) {
                echo '<div class="alert alert-danger w-100 text-center">'.$message.'</div>';
            }
        ?>
        <div id="msg_erreur"></div>

        <form class="needs-validation p-3" id="formMission" role="form" action=<?php echo ($action=='update') ? "/HUMAN_HELP/?q=MissionsController/detailsMissionController?action=$action" 
                                                                                : "/HUMAN_HELP/?q=MissionsController/listeMissionProController?action=$action" ?> 
                                                                                method="POST"
                                                                                enctype="multipart/form-data"
                                                                                onsubmit="return VerifFormMission(this)">
            <input type="hidden" name="idMission" id="idMission" value="<?php echo isset($idMission) ? $idMission : '' ?>">

            <hr class="my-4 hrGreenLight">

            <input type="hidden" name="idEtablissement" value="<?php echo isset($idEtablissement) ? $idEtablissement : 1 ?>">
                
            <div class="mb-3 form-group">
                <label for="titreMission">Titre de la mission</label>
                <input type="text" class="form-control" name="titreMission" id="titreMission" placeholder="" value="<?php echo (($_GET['action']) == 'update') ? utf8_encode($mission->getTitreMission()) : '';?>" required>
                <div class="invalid-feedback">
                    Ce champ est requis.
                </div>
            </div> 
            <div class="row p-0 mb-3">
                <div class="form-group col-12 col-md-6 w-50 pl-3">
                    <label class="h-50" for="idPays">Pays concerné</label>
                    <select type="number" name="idPays" id="idPays" class="custom-select list-group d-block h-50 w-100" required>
                        <option class="list-group-item" value="<?php echo (($_GET['action']) == 'update') ? $mission->getIdPays() : '' ?>">
                            <?php echo (($_GET['action']) == 'update') ? searchNamePaysById($mission->getIdPays()) : 'Choisissez...' ?>
                        </option>

                        <?php 
                        $allPays = $tabAffichageFormMission['allPays'];
                        foreach ($allPays as $pays) : ?>
                            <option value="<?php echo $pays->getIdPays(); ?>" class="list-group-item">
                                <?php echo utf8_encode($pays->getNomPays()); ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                        Choisissez un pays valide.
                    </div>
                </div>
                
                <div class="form-group col-12 col-md-6 w-50 pl-3">
                    <label class=" h-50" for="idTypeActivite">Type d'activité</label>
                    <select name="idTypeActivite" id="idTypeActivite" class="custom-select list-group d-block h-50 w-100" required>
                        <option class="list-group-item" value="<?php echo (($_GET['action']) == 'update') ? $mission->getIdTypeActivite() : '' ?>">
                            <?php echo (($_GET['action']) == 'update') ? searchNameTypeActivityById($mission->getIdTypeActivite()) : 'Choisissez...' ?>
                        </option>
                        <?php 
                        $allTypeActivite = $tabAffichageFormMission['allTypeActivite'];
                        foreach ($allTypeActivite as $typeActivite) : ?>
                            <option value="<?php echo $typeActivite->getIdTypeActivite(); ?>" class="list-group-item">
                                <?php echo utf8_encode($typeActivite->getTypeActivite()); ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                        Ce champ est requis.
                    </div>
                </div>
            </div>
            <div class="mb-3 form-group">
                <label for="descriptionMission">Description de la mission</label>
                <textarea type="textarea" class="form-control" name="descriptionMission" id="descriptionMission" placeholder="" required><?php echo ($_GET['action'] == 'update') ? $mission->getDescriptionMission() : ''; ?></textarea>
                <div class="invalid-feedback">
                    Ce champ est requis.
                </div>
            </div>
            <div class="d-block mb-3 form-group">
                <label>Type de formation</label>
                <div class="row">
                    <div class="custom-control custom-radio col-10 col-md-3 mx-4">
                        <input name="typeFormation" id="distance" value="2" type="radio" class="custom-control-input" <?php echo ($action=='update' && $mission->getTypeFormation()==2) ? 'checked' : '' ?>>
                        <label for="distance" class="custom-control-label">Distance</label>                       
                    </div>
                    <div class="custom-control custom-radio col-10 col-md-3 mx-2">
                        <input name="typeFormation" id="terrain" value="1" type="radio" class="custom-control-input" <?php echo ($action=='update' && $mission->getTypeFormation()==1) ? 'checked' : '' ?>>
                        <label for="terrain" class="custom-control-label">Sur le terrain</label>                       
                    </div>
                </div>  
            </div>
            <div class="mb-3 form-group">
                <label for="dateDebut">Date de début de la mission</label>
                <div class="input-group"  data-provide="datepicker">
                    <input type="date" class="form-control" name="dateDebut" id="dateDebut" value="<?php echo ($_GET['action'] == 'update') ? $mission->getDateDebut()->format('Y-m-d') : ''; ?>" required>
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
                <div class="invalid-feedback">
                    Ce champ est requis.
                </div>
            </div>
            <div class="mb-3 form-group">
                <label for="duree">Durée de la mission<span class="text-muted"> (en jour)</span></label>
                <input type="number" class="form-control" name="duree" id="duree" placeholder="" value="<?php echo ($_GET['action'] == 'update') ? $mission->getDuree() : ''; ?>">
                <div class="invalid-feedback">
                    Ce champ est requis.
                </div>
            </div>
            <div class="mb-3 form-group">
                <label for="imageMission">Ajouter une image</label>
                <input type="file" class="form-control-file" name="imageMission" id="imageMission" placeholder="" capture>
            </div>

            <hr class="my-4 hrGreenLight">
            
            <button class="btn btnGreen btn-lg btn-block mb-5" type="submit"><?php echo $tabAffichageFormMission['titleBtn'];?></button>
            <a href="listeMissionController" class="btn btn-primary w-100">Retour à la liste des missions</a>
        </form>   
    </div>

    <script type="text/javascript">
        
    function VerifFormMission(form) {
        var titreMission=document.getElementById('formMission').titreMission.value;
        var idPays=document.getElementById('formMission').idPays.value;
        var idTypeActivite=document.getElementById('formMission').idTypeActivite.value;
        var descriptionMission=document.getElementById('formMission').descriptionMission.value;
        var typeFormation=document.getElementById('formMission').typeFormation.value;
        var dateDebut=document.getElementById('formMission').dateDebut.value;
        var duree=document.getElementById('formMission').duree.value;
        var imageMission=document.getElementById('formMission').imageMission.value;
        if (titreMission == "") {
            document.getElementById('msg_erreur').innerHTML= '<div class="alert alert-danger text-center w-100">Veuillez indiquer le titre de la mission !</div>';
            document.getElementById('msg_erreur').style.display='block';
            document.getElementById('msg_erreur').className='focus';
            form.titreMission.focus();
            return false;
        } else {
            document.getElementById('msg_erreur').style.display='none';
        }
        if (idPays == "") {
            document.getElementById('msg_erreur').innerHTML= '<div class="alert alert-danger text-center w-100">Veuillez indiquer le pays de la mission !</div>';
            document.getElementById('msg_erreur').style.display='block';
            document.getElementById('msg_erreur').className='focus';
            form.idPays.focus();
            return false;
        } else {
            document.getElementById('msg_erreur').style.display='none';
        }
        if (idTypeActivite == "") {
            document.getElementById('msg_erreur').innerHTML= '<div class="alert alert-danger text-center w-100">Veuillez indiquer le type d\'activité !</div>';
            document.getElementById('msg_erreur').style.display='block';
            document.getElementById('msg_erreur').className='focus';
            form.idTypeActivite.focus();
            return false;
        } else {
            document.getElementById('msg_erreur').style.display='none';
        }
        if (descriptionMission == "") {
            document.getElementById('msg_erreur').innerHTML= '<div class="alert alert-danger text-center w-100">Veuillez indiquer une description à la mission !</div>';
            document.getElementById('msg_erreur').style.display='block';
            document.getElementById('msg_erreur').className='focus';
            form.descriptionMission.focus();
            return false;
        } else {
            document.getElementById('msg_erreur').style.display='none';
        }
        if (typeFormation == "") {
            document.getElementById('msg_erreur').innerHTML= '<div class="alert alert-danger text-center w-100">Veuillez indiquer le type de formation de la mission !</div>';
            document.getElementById('msg_erreur').style.display='block';
            document.getElementById('msg_erreur').className='focus';
            form.typeFormation.focus();
            return false;
        } else {
            document.getElementById('msg_erreur').style.display='none';
        }
        if (dateDebut == "") {
            document.getElementById('msg_erreur').innerHTML= '<div class="alert alert-danger text-center w-100">Veuillez une date de début !</div>';
            document.getElementById('msg_erreur').style.display='block';
            document.getElementById('msg_erreur').className='focus';
            form.dateDebut.focus();
            return false;
        } else {
            document.getElementById('msg_erreur').style.display='none';
        }
        if (duree == "") {
            document.getElementById('msg_erreur').innerHTML= '<div class="alert alert-danger text-center w-100">Veuillez indiquer la durée de la mission !</div>';
            document.getElementById('msg_erreur').style.display='block';
            document.getElementById('msg_erreur').className='focus';
            form.duree.focus();
            return false;
        } else {
            document.getElementById('msg_erreur').style.display='none';
        }
        if (imageMission == "") {
            document.getElementById('msg_erreur').innerHTML= '<div class="alert alert-danger text-center w-100">Veuillez ajouter une image à la mission !</div>';
            document.getElementById('msg_erreur').style.display='block';
            document.getElementById('msg_erreur').className='focus';
            form.imageMission.focus();
            return false;
        } else {
            document.getElementById('msg_erreur').style.display='none';
        }
        return true;
    }

    </script>
    <?php
}

function formParticipationMission($mission, $successCode =null )
{
?>
    <div class="container col-12 col-md-6 formParticipationMission py-4 rounded">

        <h1 class="my-3 text-center">Titre de la mission : <?php echo $mission->getTitreMission(); ?></h1>

        <form class="needs-validation p-3" action="/HUMAN_HELP/?q=MissionsController/confirmationParticipationMission?action=send" method="POST" novalidate>
            <h2 class="text-center my-2 pb-2">Inscrivez vous</h2>

            <hr class="mb-4 mt-2 hrGreen">
            
            <div class="d-block my-4 form-group">
                <label>Civilité</label>
                <div class="row">
                    <div class="custom-control custom-radio col-5 mx-4">
                        <input name="civilite" id="monsieur" type="radio" class="custom-control-input">
                        <label for="monsieur" class="custom-control-label">Monsieur</label>
                    </div>
                    <div class="custom-control custom-radio col-5 mx-2">
                        <input name="civilite" id="madame" type="radio" class="custom-control-input">
                        <label for="madame" class="custom-control-label">Madame</label>
                    </div>
                </div>  
            </div>
            <div class="my-4 form-group">
                <label for="mail">Adresse mail</label>
                <input name="mail" type="mail" class="form-control" placeholder="mail@mail.com" value="<?php echo $_SESSION['mailUtil'] ?>" required>
                <div class="invalid-feedback">
                    Ce champ est requis.
                </div>
            </div>
            <div class="my-4 form-group date">
                    <label for="dateNaissance">Date de naissance</label>
                    <input name="dateNaissance" type="date" data-provide="datepicker" class="form-control" placeholder="jj/mm/aaaa" required>
                <div class="invalid-feedback">
                    Ce champ est requis.
                </div>
            </div>
            <div class="my-4 form-group">
                <label for="message">Message</label>
                <input name="message" type="textarea" class="form-control messageMission" placeholder="Ajouter un message"></input>
                <div class="invalid-feedback">
                    Ce champ est requis.
                </div>
            </div>
            
            <hr class="my-4 hrGreen">
            
            <button type="submit" class="btn btnGreen btn-lg btn-block mb-5">
                Envoyer
            </button>
            <a href="../CommentCaMarcheController/CommentCaMarcheController?idMission=<?php echo $mission->getIdMission();?>" class="btn btn-primary w-100">
                Retour aux informations
            </a>        
        </form>

    </div>
<?php
}