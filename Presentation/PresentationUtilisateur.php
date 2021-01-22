<?php 
require_once("../../Presentation/PresentationCommun.php");

function connexion($message=null,$errorCode=null) 
{
    echo head();
    ?> 
    <?php
        echo navbar();

        if ($errorCode && $errorCode == 1081) { //Mauvaises informations de connection
            echo "<div class='alert alert-danger text-center my-5'>$message</div>";
        }else if (!$errorCode && $message ) {   //Doit etre Professionnel
            echo "<div class='alert alert-danger text-center my-5'>$message</div>";
        }
    ?>
    <body>
        <div class="container col-12 col-md-6 col-lg-4 pt-2 my-5 borderGreen rounded">  

            <form class="form-signin m-auto text-center p-3 formConnexion" action="/HUMAN_HELP/Controller/UtilisateurController/utilisateurController.php?action=connexion" method="POST">

                <div class="logo1 m-auto"></div>

                <h2 class="my-3 font-weight-normal">Connectez vous</h2>

                <div class="form-label-group my-4">
                    <label for="mailUtil" class="sr-only">Adresse mail</label>
                    <input type="email" name="mailUtil" class="form-control m-auto w-75" placeholder="email@mail.com" required>
                </div>

                <div class="form-label-group my-4">
                    <label for="password" class="sr-only">Mot de passe</label>
                    <input type="password" name="password" class="form-control m-auto w-75" placeholder="mot de passe" required>
                </div>

                <button class="btn btnGreen btn-block mb-4 w-75" type="submit">Connexion</button>

                <div class="m-auto text-left">
                    <a href="/HUMAN_HELP/Controller/UtilisateurController/FormulairesUtilisateurController.php?action=formAjout" >
                        Créer un compte
                    </a>
                </div>
                <div class="m-auto text-left">
                    <a href="formulairesUtilisateurController.php?action=modifMdp">Mot de passe oublié</a>
                </div>
            </form>
        </div>
        <?php      
        echo footer();
        ?>
    </body>
    </html>
    <?php
}

function formulairesUtilisateur(array $tabAffichageFormUser,$utilisateur=null,$message=null)
{
    echo head();
    ?>
    <body>
        <?php
        echo navbar();
        ?>
        <div class="col-12 col-md-5 container my-4 borderGreen rounded">    
            
            ​<form class="form p-4" action="utilisateurController.php?action=<?php echo $tabAffichageFormUser['action']; ?>" method="POST" novalidate>
                ​<h2 class="text-center pb-2"><?php echo $tabAffichageFormUser['title']; ?></h2>

                <?php
                    if ($message) {
                        echo '<div class="alert alert-danger w-100 text-center">'.$message.'</div>';
                    }
                ?>
                        
                <hr class="mb-4 hrGreen">
      
                <input type="hidden" name="idUtilisateur" value="<?php echo (isset($_GET['action']) && $_GET['action']=="formModif" ) ? $utilisateur->getIdUtilisateur() : "" ?>">
                <input type="hidden" name="dateInscriptionUtil" value="<?php echo (isset($_GET['action']) && $_GET['action']=="formModif" ) ? $utilisateur->getDateInscriptionUtil()->format("Y-m-d") : "" ?>">

                <div class="d-block mb-2 form-group">
                    <label class="text-center w-100 my-2" for="idRole">Vous êtes ?</label>
                    <div class="row justify-content-between">
                        <div class="custom-control col-4 col-md-3 custom-radio mx-4">
                            <input name="idRole" value="1" id="particulier" type="radio" class="custom-control-input" <?php echo (($_GET['action'] == 'formModif') && $utilisateur->getIdRole()==1) ? 'checked' : '' ?>>
                            <label for="particulier" class="custom-control-label">Particulier</label>
                        </div>
                        <div class="custom-control col-4 col-md-3 custom-radio mx-2">
                            <input name="idRole" value="2" id="professionnel" type="radio" class="custom-control-input" <?php echo (($_GET['action'] == 'formModif') && $utilisateur->getIdRole()==2) ? 'checked' : '' ?>>

                            <label for="professionnel" class="custom-control-label">Professionnel</label>
                        </div>
                    </div>  
                </div>
                <hr class="hrGreenLight w-75 mx-auto">
                <div class="d-block my-3 form-group">
                    <label for="civilite">Civilité</label>
                    <div class="row">
                        <div class="custom-control col-4 col-md-2 custom-radio mx-4">
                            <input name="civilite" value="1" id="homme" type="radio" class="custom-control-input" <?php echo (($_GET['action'] == 'formModif') && $utilisateur->getCivilite()==1) ? 'checked' : '' ?>>
                            <label for="homme" class="custom-control-label">Homme</label>
                        </div>
                        <div class="custom-control col-4 col-md-2 custom-radio mx-2">
                            <input name="civilite" value="2" id="femme" type="radio" class="custom-control-input" <?php echo (($_GET['action'] == 'formModif') && $utilisateur->getCivilite()==2) ? 'checked' : '' ?>>
                            <label for="femme" class="custom-control-label">Femme</label>
                        </div>
                    </div>  
                </div>

                <div class="form-group mb-0">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" class="form-control" name="pseudo" placeholder="" value="<?php echo ($_GET['action'] == 'formModif') ? $utilisateur->getPseudo() : ''; ?>" required>
                </div>

                <div class="form-group mb-0">
                    <label for="nomUtil">Nom</label>
                    <input type="text" class="form-control" name="nomUtil" placeholder="" value="<?php echo ($_GET['action'] == 'formModif') ? $utilisateur->getNomUtil() : ''; ?>" required>
                </div>
            ​
                <div class="mb-2 form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" name="prenomUtil" placeholder="" value="<?php echo ($_GET['action'] == 'formModif') ? $utilisateur->getPrenomUtil() : ''; ?>" required>
                </div>   

                <div class="mb-2 form-group">
                    <label for="dateNaissance">Date de naissance</label>
                    <div class="input-group"  data-provide="datepicker">
                        <input type="date" class="form-control" name="dateNaissance" placeholder="jj/mm/aaaa" value="<?php echo ($_GET['action'] == 'formmodif') ? $utilisateur->getDateNaissance()->format('Y-m-d')  : ''; ?>" required>
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                        
                <div class="mb-2 form-group">
                    <label for="mailUtil">email</label>
                    <input type="email" name="mailUtil" value="<?php if(($_GET['action']) == 'formModif'){echo $_SESSION['mailUtil'];} else ''?>" class="form-control" id="emailUser" aria-describedby="emailHelp" required pattern="^\w{2,}@\w{2,}\.\w{2,}$">
                </div>

                <div class="form-group">
                    <label for="telUtil">Numéro de téléphone:</label>    ​
                    <input class="form-control" type="phone" id="phone" name="telUtil" value="<?php echo ($_GET['action'] == 'formModif') ? $utilisateur->getTelUtil() : ''; ?>">
                </div>  

                <div class="mb-2 form-group">
                    <label for="passwordUtil">Mot de passe</label>
                    <input type="password" name="passwordUtil" class="form-control" id="password">
                </div>

                <div class="mb-2 form-group">
                    <label for="adresseUtil">Num et libellé de la voie</label>
                    <input type="text" class="form-control" name="adresseUtil" id="adresseUtil" value="<?php echo ($_GET['action'] == 'formModif') ? $utilisateur->getAdresseUtil() : ''; ?>">
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-2 form-group">
                        <label for="villeUtil">Ville</label>
                        <input type="text" class="form-control" name="villeUtil" id="villeUtil" value="<?php echo ($_GET['action'] == 'formModif') ? $utilisateur->getVilleUtil() : ''; ?>" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="codePostalUtil">Code postal</label>
                        <input name="codePostalUtil" type="number" class="form-control" id="codePostalUtil" value="<?php echo ($_GET['action'] == 'formModif') ? $utilisateur->getCodePostalUtil() : ''; ?>" required>
                    </div>
                </div>

                <div class="form-group col-12 col-md-6 w-50 pl-0">
                    <label class="h-50" for="idPays">
                        Pays de résidence
                    </label>
                    <select type="number" name="idPays" class="custom-select list-group d-block h-50 w-100" required>
                        <option class="list-group-item" value="<?php echo (($_GET['action']) == 'formModif') ? $utilisateur->getIdPays() : '' ?>">
                            <?php echo (($_GET['action']) == 'formModif') ? searchNamePaysById($utilisateur->getIdPays()) : 'Choisissez...' ?>
                        </option>
                        <?php 
                        $allPays = $tabAffichageFormUser['allPays'];
                        foreach ($allPays as $pays) : ?>
                            <option value=<?php echo $pays->getIdPays(); ?> class="list-group-item">
                                <?php echo utf8_encode($pays->getNomPays()); ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                        Choisissez un pays valide.
                    </div>
                </div>

                <div class="mb-2 form-group form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">
                        se souvenirs de moi
                    </label>
                </div>

                <hr class="mb-4 mt-4">
                
                <button class="btn btnGreen btn-lg btn-block mb-5 w-100 text-center mx-auto" type="submit">
                    <?php echo $tabAffichageFormUser['titleBtn'];?>
                </button>
                <div class="w-100 m-auto text-center">
                    <a href="../../index.php" class="btn btn-primary w-100 text-center mx-auto">
                        Retour à l'accueil
                    </a>    
                </div>
            </form>
        </div>
        <?php      
        echo footer(); 
        ?>
    </body>
    </html>
    <?php
}

function modifMotDePasse()
{
    echo head();
    ?>
    <body>
        <?php
        echo navbar();
        ?>

        <div class="col-md-6 col-lg-4 container pt-2 my-5 border rounded">

        <form class="form-signin m-auto text-center p-3 formConnexion" action="../index.php" method="POST">

            <div class="logo1 mb-4"></div>

            <h1 class="h3 mb-3 font-weight-normal">Modifier votre mot de passe</h1>

            <div class="form-label-group mb-4">
                <label for="password" class="sr-only">Ancien mot de passe</label>
                <input type="password" name="password" class="form-control inputConnexion" placeholder="Ancien mot de passe" required>
            </div>

            <div class="form-label-group mb-4">
                <label for="newPassword" class="sr-only">Nouveau mot de passe</label>
                <input type="password" name="newPassword" class="form-control inputConnexion" placeholder="Nouveau mot de passe" required>
            </div>

            <div class="form-label-group mb-4">
                <label for="confirmPassword" class="sr-only">Confirmer mot de passe</label>
                <input type="password" name="confirmPassword" class="form-control inputConnexion" placeholder="Confirmer mot de passe" required>
            </div>

            <button class="btn btnGreen btn-block mb-4" type="submit" value="Envoyer">Enregistrement des modifications</button>

        </form>
            
        </div>

        <?php      
        echo footer(); 
        ?>
    </body>
    </html>
    <?php
}

function detailUtilisateur($utilisateur = null)
{
    echo head();
    ?>
    <body>
        <?php
        echo navbar();
        ?>
    <div class="container">
        <div>
            <h2>Détail des informations personnelles</h2> 
        </div>
        <hr class="my-4">
        <div class="row">
            <div class="col-sm-12 m-5">
                <h3>Mes coordonnées:</h3>
                <div class="row">
                    <div class="col-9">
                        <p>Civilité :</p>
                        <p>Nom :</p>
                        <p>Prénom :</p>
                        <p>Adresse mail :</p>
                        <p>Numéro de téléphone :</p>
                    </div></br>
                    <div class="col-3">
                        <p><?php echo civilite($utilisateur->getCivilite()) ?></p>
                        <p><?php echo $utilisateur->getNomUtil() ?></p>
                        <p><?php echo $utilisateur->getPrenomUtil() ?></p>
                        <p><?php echo $utilisateur->getMailUtil() ?></p>
                        <p><?php echo $utilisateur->getTelUtil() ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 m-5">
                <h3>Votre adresse :</h3>
                <div class="row">
                    <div class="col-9 mr-auto">
                        <p>Numéro, libellé de la voie :</p>
                        <p>Ville</p>
                        <p>Code postale :</p>
                        <p>Complément d'adresse :</p>
                    </div>
                    <div class="col-3">
                        <p><?php echo $utilisateur->getAdresseUtil() ?></p>
                        <p><?php echo $utilisateur->getVilleUtil() ?></p>
                        <p><?php echo $utilisateur->getCodePostalUtil() ?></p>
                        <p>-</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-10 col-md-6 m-auto">
                    <a class="btn btnGreen w-100 my-4 " href="/HUMAN_HELP/Controller/UtilisateurController/FormulairesUtilisateurController.php?action=formModif">
                        Modifier les informations personnelles
                    </a>
        </div>
        <div class="col-10 col-md-6 m-auto">
                    <a class="btn btnGreen w-100 my-4 " href="/HUMAN_HELP/Controller/UtilisateurController/UtilisateurController.php?action=delete&idUtilisateur=<?php echo $utilisateur->getIdUtil() ?>">
                        Supprimer mon compte
                    </a>
        </div>
        <hr class="my-4">
    </div>
    <?php      
        echo footer();
        ?>
    </body>
    </html>
    <?php
}
