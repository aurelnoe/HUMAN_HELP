<?php
include_once("C:/xampp/htdocs/HUMAN_HELP/Controller/HeaderController/headerController.php");
?>

<div class="header mt-5">
	<div class="header_texture"></div>
	<!-- Arrondi -->
	<div class="header_mask">
		<svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
			<path d="M0 100 L 0 0 C 25 100 75 100 100 0 L 100 100" fill="#fff"></path>
		</svg>
	</div>
	<div class="container-fluid contant">
		<div id="test" class="row pt-4">
			<div id="BoutonBurgermenuTab">
				<div class="barre1"></div>
				<div class="barre2"></div>
			</div>
			<div class="BlockLogo col-md-12 col-lg-3 col-xl-5 pt-3">
				<a href="\HUMAN_HELP\">
					<img class="logo" src="\HUMAN_HELP\images\logo2.png" height="100px" alt="">
				</a>
			</div>
			<!---------------------- Barre de navigation ---------------------->
			<nav class="navbar col text-center menuTab mx-5">
				<a class="col-sm-12 col-lg-1 navLink" href="/HUMAN_HELP/Controller/MissionsController/listeMissionController.php">
					Projets
				</a>
				<!--Comment ça marche-->
				<a class="col-sm-12 col-lg-2 navLink" href="/HUMAN_HELP/Controller/CommentCaMarcheController/CommentCaMarcheController.php">
					Voir plus
				</a>
				<a class="col-sm-12 col-lg-1 navLink" href="/HUMAN_HELP/Controller/FaqController/faqController.php" tabindex="-1" aria-disabled="true">
					FAQ
				</a>
				<a class="col-sm-12 col-lg-1 navLink" href="/HUMAN_HELP/Controller/BlogController/listeBlogController.php" tabindex="-1" aria-disabled="true">
					Blog
				</a>
				<?php
				if (!isset($_SESSION)) {
				?>
					<a class="col-sm-12 col-lg-1 navLink" href="/HUMAN_HELP/Controller/UtilisateurController/FormulairesUtilisateurController.php?action=formAjout" tabindex="-1" aria-disabled="true">
						Inscription
					</a>
				<?php
				} else {
				?>
					<a class="col-sm-12 col-lg-1 navLink" href="/HUMAN_HELP/Controller/UtilisateurController/FormulairesUtilisateurController.php?action=connexion" tabindex="-1" aria-disabled="true">
						Connexion
					</a>
				<?php
				}
				?>
			</nav>
		</div>

		<div class="header_slogan">
			<h1 class="slogan">Aider comme vous ne l'avez encore jamais fait</h1>
			<form action="/HUMAN_HELP/Controller/MissionsController/searchMissionsController.php">
				<div class="row justify-content-md-center search_box">
					<div class="col-md-3 col-lg-3 my-1 btn-group">
						<select data-placeholder="Pays" name="idPays" id="selectPays" class="autosubmit chosen">
							<option value="">
							</option>
							<?php foreach ($allPays as $pays) { ?>
								<option class="" value="<?php echo $pays->getIdPays();?>" <?php echo isset($_GET['idPays']) && $_GET['idPays']==$pays->getIdPays() ? 'selected' : ''; ?>>
									<?php echo utf8_encode($pays->getNomPays()); ?>
								</option>
							<?php } ?>
						</select>
					</div>				
					<div class="col-md-3 col-lg-3 my-1 btn-group">
						<select data-placeholder="Activité" name="idTypeActivite" id="selectTypeActivite" class="autosubmit chosen">
							<option value="">
							</option>
							<?php foreach ($allTypeActivite as $typeActivite) { ?>
								<option class="" value="<?php echo $typeActivite->getIdTypeActivite(); ?>" <?php echo isset($_GET['idTypeActivite']) && $_GET['idTypeActivite']==$typeActivite->getIdTypeActivite() ? 'selected' : ''; ?>>
										<?php echo utf8_encode($typeActivite->getTypeActivite()); ?>
								</option>
							<?php } ?>
							</select>
					</div>
				</div>	
			</form>
		</div>
	</div>
</div>

