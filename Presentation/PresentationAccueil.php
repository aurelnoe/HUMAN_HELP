<?php

function Accueil(array $articles=null,array $missionsADistance=null,array $allMissions=null,array $session=null)
{
	?>
	<div class="container">
		<h1 class="text-center my-5">Bienvenue sur Human Helps</h1>
		<div class="row my-4 w-100">
			<div class="col-12 col-md-3 m-auto">
				<div class="card cardEspaceUtil my-2 mx-2 w-100">
					<div class="card-header">
						<?php
						if ($session) {
						?>
							<div>
								<p>Bonjour</p>
								<h3 class="ml-3 "><?php (isset($session['idUtil'])) ? searchUserNameById($session['idUtil']) : ""; ?></h3>
							</div>	
						<?php
						}else { ?>
							<a class="btn btnGreen w-100" href="/HUMAN_HELP/?q=UtilisateurController/FormulairesUtilisateurController?action=connexion">
								Connexion
							</a>
							<p class="pt-3 mb-0">Nouveau client ?</p> 
							<a class="pt-0 linkCreateCompte" href="/HUMAN_HELP/?q=UtilisateurController/FormulairesUtilisateurController?action=formAjout">
								Crée un compte
							</a>
						<?php } ?>
					</div>
					<div class="card-body">	
					<?php if ($session) { ?>
						<a class="btn btnGreen w-100 my-1" href="/HUMAN_HELP/?q=UtilisateurController/UtilisateurController?action=detailUtilisateur">
							Espace personnel
						</a>
						<?php if ($session['role'] == 'professionnel') { ?>
							<a class="btn btnGreen w-100 my-1" href="/HUMAN_HELP/?q=MissionsController/listeMissionProController">
								Espace Pro
							</a>
						<?php } ?>
						<a class="btn btn-danger w-100 my-1" href="/HUMAN_HELP/?q=AccueilController?action=deconnection">
							Déconnexion
						</a>
					<?php } else { ?>
						<div class="text-center">Vous devez être connecté</div>
					<?php } ?>		
					</div>
				</div>
			</div>
			<div class="col-12 col-md-9 pl-5 pr-2">
				<h2>Qui somme nous ?</h2>
				<p>
					Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed ex hic exercitationem vitae necessitatibus consectetur quaerat, commodi pariatur voluptate. Cum, suscipit. Sunt officia incidunt omnis. Nam quasi asperiores beatae incidunt?
					Voluptatibus optio est architecto quaerat quas quam reprehenderit quasi natus, ipsam inventore! Aut cupiditate sunt omnis id molestias a natus ut atque distinctio mollitia libero architecto, voluptatibus et voluptatum nulla.
					Vero soluta eos fugiat quasi omnis est doloribus repellat minima nulla magni pariatur, aspernatur ab voluptatibus voluptates reprehenderit architecto minus eius. Odit, reprehenderit at voluptas alias quia laudantium vel molestiae.
				</p>
			</div>
		</div>

		<hr class="my-4 hrGreenLight">

		<div class="col-12 border rounded p-0">
			<div id="carouselDistanceAccueil" class="carousel carouselListeMission slide" data-ride="carousel" data-interval="10000">
				<div>
					<ol class="carousel-indicators">
                        <?php foreach ($missionsADistance as $key => $mission) {
                            ?>
                            <li data-target="#carouselDistanceAccueil" data-slide-to="<?php echo $key; ?>"
                            	<?php echo ($key==0) ? 'class="active"' : '' ?>>
							</li>
                        <?php } ?>
                    </ol>
				</div>

				<div class="text-center mx-auto my-1">
					<a class="button btn pb-1 w-50" href="/HUMAN_HELP/?q=MissionsController/searchMissionsController?idTypeActivite=1">
						<h3>Une mission à distance avec Human Helps :</h3>
					</a>
				</div>
					
				<div class="carousel-inner w-100">
					<?php
					if (!empty($missionsADistance)) {
						foreach ($missionsADistance as $key => $mission) 
						{
							?> 
							<div class="carousel-item <?php echo ($key==0) ? 'active' : ''; ?> mb-5">
                                <div class="card cardListeMission col-10 col-md-6 p-0">
								<div class="imageMissionDiv rounded" style="background-image: url('data:image/png;base64,<?php echo $mission->getImageMission(); ?>');"></div>						
									<div class="card-body">
										<h5 class="card-title">Titre : <?php echo utf8_encode($mission->getTitreMission()); ?></h5>
										<p class="card-text">Type d'activité : <?php searchNameTypeActivityById($mission->getIdTypeActivite()); ?></p>
										<p class="card-text">Pays : <?php searchNamePaysById($mission->getIdPays()); ?> (<?php searchContinentById($mission->getIdPays()); ?>)</p>
										<p class="card-text">Date de début : <?php echo $mission->getDateDebut()->format('d-m-Y'); ?></p>
									</div>
									<div class="card-footer">
										<a href="/HUMAN_HELP/?q=MissionsController/detailsMissionController?idMission=<?php echo $mission->getIdMission(); ?>" class="btn btn-primary">
											Voir la mission
										</a>
									</div>
								</div>
							</div>
						<?php  
						} 
						?>
							<div class="row my-4">
								<a class="carousel-control-prev" href="#carouselDistanceAccueil" role="button" data-slide="next">
									<span class="carousel-control-prev-icon"></span>
									<span class="sr-only">Previous</span>
								</a>
								<a class="carousel-control-next" href="#carouselDistanceAccueil" role="button" data-slide="prev">
									<span class="carousel-control-next-icon"></span>
									<span class="sr-only">Next</span>
								</a>
							</div>
						<?php
					}else {	
					?>
						<div class="my-5 py-5 text-center">
							Pas de mission à distance pour le moment
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>

		<hr class="my-4 hrGreenLight">

		<div class="row mb-4 p-0 w-100">
			<div class="col-12 col-md-4 mt-4">
				<h2 class="pl-4">Ophélie, 22 ans</h2>
				<h4 class="font-italic pl-4">10/11/2020</h4>
				<div class="row">
					<div class="col-1 px-0 pt-3 text-center">
						"
					</div>
					<div class="col-10 p-0 my-3">
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed exercitationem vitae necessitatibus consectetur quaerat
					</div>
					<div class="col-1 px-0 pt-3 text-center">
						"
					</div>
				</div>
				<hr>
			</div>
			<div class="col-12 col-md-4 mt-4">
				<h2 class="pl-4">Lucas, 36 ans</h2>
				<h4 class="font-italic pl-4">11/11/2020</h4>
				<div class="row">
					<div class="col-1 px-0 pt-3 text-center">
						"
					</div>
					<div class="col-10 p-0 my-3">
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed exercitationem vitae necessitatibus consectetur quaerat,						
					</div>
					<div class="col-1 px-0 pt-3 text-center">
						"
					</div>
				</div>
				<hr>
			</div>
			<div class="col-12 col-md-4 mt-4">
				<h2 class="pl-4">Kamel, 30 ans</h2>
				<h4 class="font-italic pl-4">12/11/2020</h4>
				<div class="row">
					<div class="col-1 px-0 pt-3 text-center">
						"
					</div>
					<div class="col-10 p-0 my-3">
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed exercitationem vitae necessitatibus consectetur quaerat,
					</div>
					<div class="col-1 px-0 pt-3 text-center">
						"
					</div>
				</div>
				<hr>
			</div>
		</div>

		<hr class="my-4 hrGreenLight">

		<div class="col-12 border rounded p-0">
			<div id="carouselArticleAccueil" class="carousel carouselListeMission slide" data-ride="carousel" data-interval="10000">
				<div>
					<ol class="carousel-indicators">
						<?php foreach ($articles as $key => $article) {
						?>
							<li data-target="#carouselArticleAccueil" data-slide-to="<?php echo $key; ?>" <?php echo ($key == 0) ? 'class="active"' : '' ?>></li>
						<?php
						} ?>
					</ol>
				</div>
				<div class="text-center mx-auto my-1">
					<a class="button btn pb-1 w-50" href="Controller/BlogController/listeBlogController.php">
						<h3>Les actualités avec Human Helps :</h3>
					</a>
				</div>

				<div class="carousel-inner w-100">
					<?php
					if (!empty($articles)) {
						foreach ($articles as $key => $article) {
						?>
							<div class="carousel-item  <?php echo ($key == 0) ? 'active' : ''; ?> mb-5">
								<div class="card cardListeMission col-10 col-md-6 p-0">
									<div class="imageMissionDiv rounded" style="background-image: url('data:image/png;base64,<?php echo $article->getImageArticle(); ?>');"></div>
									<div class="card-body">
										<h5 class="card-title">Titre : <?php echo $article->getTitreArticle() ?></h5>
										<p class="card-text">Description : <?php echo $article->getDescriptionArticle() ?></p>
										<p class="card-text">Pays : Ghana (Afrique)</p>
										<p class="card-text">Date : <?php echo $article->getDateArticle()->format('d-m-Y'); ?></p>
									</div>
									<div class="card-footer">
										<a href="/HUMAN_HELP?q=/BlogController/detailsBlogController.php?idArticle=<?php echo $article->getIdArticle(); ?>" class="btn btn-primary">
											Voir plus
										</a>
									</div>
								</div>
							</div>
						<?php
						}
						?>
						<div class="row my-4 mx-0">
							<a class="carousel-control-prev" href="#carouselArticleAccueil" role="button" data-slide="next">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#carouselArticleAccueil" role="button" data-slide="prev">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
					<?php
					}else 
					{	
					?>
						<div class="my-5 py-5 text-center">
							Pas d'article pour le moment
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		
		<hr class="my-4 hrGreenLight">
	
		<div class="col-12 border rounded p-0">
			<div id="carouselMissionAccueil" class="carousel carouselListeMission slide" data-ride="carousel" data-interval="10000">
				<div>
					<ol class="carousel-indicators">
						<?php foreach ($allMissions as $key => $mission) {
							if ($key < 6) {
							?>
							<li data-target="#carouselMissionAccueil" data-slide-to="<?php echo $key; ?>"
							<?php echo ($key==0) ? 'class="active"' : '' ?>></li>
							<?php
							}  
						} 
						?>
					</ol>
				</div>
				<div class="text-center mx-auto my-1">
					<a class="button btn pb-1 w-50" href="Controller/MissionsController/searchMissionsController.php?idTypeActivite=1">
						<h3>Une mission humanitaire avec Human Helps:</h3>
					</a>
				</div>
	
				<div class="carousel-inner w-100">
					<?php
					if (!empty($allMissions)) {
						foreach ($allMissions as $key => $mission) 
						{
							?> 
							<div class="carousel-item <?php echo ($key==0) ? 'active' : ''; ?> mb-5">
								<div class="card cardListeMission col-10 col-md-6 p-0">
									<div class="imageMissionDiv rounded" style="background-image: url('data:image/png;base64,<?php echo $mission->getImageMission(); ?>');"></div>
									<div class="card-body">
										<h5 class="card-title">Titre : <?php echo utf8_encode($mission->getTitreMission()); ?></h5>
										<p class="card-text">Type d'activité : <?php searchNameTypeActivityById($mission->getIdTypeActivite()); ?></p>
										<p class="card-text">Pays : <?php searchNamePaysById($mission->getIdPays()); ?> (<?php searchContinentById($mission->getIdPays()); ?>)</p>
										<p class="card-text">Date de début : <?php echo $mission->getDateDebut()->format('d-m-Y'); ?></p>
									</div>
									<div class="card-footer">
										<a href="Controller/MissionsController/detailsMissionController.php?idMission=<?php echo $mission->getIdMission(); ?>" class="btn btn-primary">Voir la mission</a>
									</div>
								</div>
							</div>
							<?php
						} 
						?>
						<div class="row my-4">
							<a class="carousel-control-prev" href="#carouselMissionAccueil" role="button" data-slide="next">
								<span class="carousel-control-prev-icon"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#carouselMissionAccueil" role="button" data-slide="prev">
								<span class="carousel-control-next-icon"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
					<?php
					}else 
					{	
					?>
						<div class="my-5 py-5 text-center">Pas de mission humanitaire pour le moment</div>
					<?php
					}
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>