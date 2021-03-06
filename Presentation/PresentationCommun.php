<?php 

function footer()
{ 
	?>
    <footer class="mt-4" style="background-color: #F8F8FF;">
		<div class="row text-center w-100 mx-0">
			<div class="col-10 col-md-4 mx-0 px-0">
				<ul class="list-footer list-group list-group-flush">
					<li class="list-group-item" style="background-color: #F8F8FF;" >
						<a class="nav-link" href="/HUMAN_HELP/?q=UtilisateurController/UtilisateurController?action=detailUtilisateur">
							Détail compte perso
						</a>
					</li>
					<li class="list-group-item" style="background-color: #F8F8FF;">
						<a class="nav-link" href="#">
							Espace pro
						</a>
					</li>
					<li class="list-group-item" style="background-color: #F8F8FF;">
						<a class="nav-link" href="/HUMAN_HELP/?q=CommentCaMarcheController/CommentCaMarcheController">
							Comment ça marche
						</a>
					</li>
					<?php if (empty($_SESSION)) { ?>
							<li class="list-group-item" style="background-color: #F8F8FF;">
								<a class="nav-link" href="/HUMAN_HELP/?q=UtilisateurController/FormulairesUtilisateurController?action=formAjout">
									Inscription
								</a>
							</li>
						<?php 
						}else{ ?>
							<li class="list-group-item" style="background-color: #F8F8FF;">
								<a class="nav-link" href="/HUMAN_HELP/?q=AccueilController?action=deconnection" tabindex="-1" aria-disabled="true">
									Deconnexion
								</a>
							</li>  
					<?php } ?>
					<li class="list-group-item" style="background-color: #F8F8FF;">
						<a class="nav-link" href="/HUMAN_HELP/?q=MissionsController/listeMissionController" tabindex="-1" aria-disabled="true">
							Projets
						</a>
					</li> 
				</ul>
			<!-- changer les liens ancres pour les mettres sur la banière -->
			</div>
			<div class="col-10 col-md-4 mx-0">
				<ul class="list-footer list-group list-group-flush">
					<li class="list-group-item" style="background-color: #F8F8FF;"><a class="nav-link" href="#">Politiques de confidentialités</a></li>
					<li class="list-group-item" style="background-color: #F8F8FF;"><a class="nav-link" href="#">Politique d'utilisation des cookies</a></li>
					<li class="list-group-item" style="background-color: #F8F8FF;"><a class="nav-link" href="#">Conditions générales</a></li> 
					<li class="list-group-item" style="background-color: #F8F8FF;"><a class="nav-link" href="/HUMAN_HELP/?q=FaqController/faqController">FAQ</a></li>
					<li class="list-group-item" style="background-color: #F8F8FF;"><a class="nav-link" href="/HUMAN_HELP/?q=BlogController/listeBlogController">Blog</a></li>
				</ul>
			</div>
			<div class="col-10 col-md-4 button-footer mx-0">
				<a href="#" class="btn btnGreen btn-lg  mb-5 button-footer1 text-center" type="submit">
					S'inscrire à la Newsletter
				</a>
				<a href="#" class="btn btnGreen btn-lg  mb-5 button-footer1 text-center" type="submit">
					Faire un don
				</a>
				<a href="/HUMAN_HELP/?q=ContactController/contactController" 
					class="btn btnGreen btn-lg  mb-5 button-footer2 text-center">
					Contact
				</a>
			</div>
		</div>
	</footer>
	<?php
}

function navbar(array $allPays,array $allTypeActivite,$message=null,$errorCode=null)
{
	?>
	<div class="header">
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
					<a class="col-sm-12 col-lg-1 navLink" href="/HUMAN_HELP/?q=MissionsController/listeMissionController">
						Projets
					</a>
					<!--Comment ça marche-->
					<a class="col-sm-12 col-lg-2 navLink" href="/HUMAN_HELP/?q=CommentCaMarcheController/CommentCaMarcheController">
						Voir plus
					</a>
					<a class="col-sm-12 col-lg-1 navLink" href="/HUMAN_HELP/?q=FaqController/faqController" tabindex="-1" aria-disabled="true">
						FAQ
					</a>
					<a class="col-sm-12 col-lg-1 navLink" href="/HUMAN_HELP/?q=BlogController/listeBlogController" tabindex="-1" aria-disabled="true">
						Blog
					</a>
					<?php
					if (empty($_SESSION)) {
					?>
						<a class="col-sm-12 col-lg-1 navLink" href="/HUMAN_HELP/?q=UtilisateurController/FormulairesUtilisateurController?action=connexion" tabindex="-1" aria-disabled="true">
							Connexion
						</a>
					<?php
					} else {
						?>
						<a class="navLink" href="/HUMAN_HELP/?q=AccueilController?action=deconnection" tabindex="-1" aria-disabled="true">
							Deconnexion
						</a>
					<?php
					}
					?>
				</nav>
			</div>

			<div class="header_slogan">
				<h1 class="slogan">Aider comme vous ne l'avez encore jamais fait</h1>
				<form action="/HUMAN_HELP/?q=MissionsController/searchMissionsController">
					<div class="row justify-content-md-center search_box">
						<div class="col-md-3 col-lg-3 my-1 btn-group rounded">
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
	<?php 
}
?>