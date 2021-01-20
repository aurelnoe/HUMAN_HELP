<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/HUMAN_HELP/Security/config.php");
include_once(PATH_BASE . "/Presentation/PresentationCommun.php");
// include_once(PATH_BASE . "/Controller/AvisController/formulaireAvisController.php");
include_once(PATH_BASE . "/Services/ServiceUtilisateur.php");




function formulaireArticle(string $title, $article = null, string $titleBtn, string $action, int $idArticle = null)
{
    echo head();
?>

    <body>
        <?php

        echo navbar();

        ?>
        <div class="container col-12 col-md-6 pt-4 my-4 border rounded">

            <h2 class="text-center my-2 pb-2"><?php echo $title; ?></h2>

            <form class="needs-validation  p-3" action="/HUMAN_HELP//Controller/BlogController/listeBlogController.php?action=<?php echo $action; ?>" method="POST" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="idArticle" value="<?php echo isset($idArticle) ? $idArticle : '' ?>">

                <hr class="mb-4 mt-2">

                <div class="mb-3 form-group">
                    <label for="titleArticle">Titre de l'article</label>
                    <input type="text" class="form-control" name="titreArticle" placeholder="" value="<?php if (($_GET['action']) == 'update') {
                                                                                                            echo $article->getTitreArticle();
                                                                                                        } ?>" required>
                    <div class="invalid-feedback">
                        Ce champ est requis.
                    </div>
                </div>

                <div class="mb-3 form-group">
                    <label for="descriptionArticle">Description de l'article</label>
                    <textarea type="textarea" class="form-control" name="descriptionArticle" placeholder="" required><?php echo ($_GET['action'] == 'update') ? $article->getDescriptionArticle() : ''; ?> </textarea>
                    <div class="invalid-feedback">
                        Ce champ est requis.
                    </div>
                </div>

                <div class="mb-3 form-group">
                    <label for="imageArticle">Ajouter une image</label>
                    <input type="file" class="form-control-file" name="imageArticle" placeholder="" accept="image/png, image/jpeg" value="<?php echo ($_GET['action'] == 'update') ? $article->getImageArticle() : ''; ?>" required>
                </div>

                <div class="mb-3 form-group">
                    <label for="dateArticle">Date de l'article</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="date" class="form-control" name="dateArticle" placeholder="jj/mm/aaaa" value="<?php echo ($_GET['action'] == 'update') ? $article->getDateArticle()->format('Y-m-d') : ''; ?>" required>
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        Ce champ est requis.
                    </div>
                </div>

                <hr class="mb-4 mt-4">

                <button class="btn btnGreen btn-lg btn-block mb-5" type="submit"><?php echo $titleBtn; ?></button>
                <a href="listeBlogController.php" class="btn btn-primary w-100">Retour à la liste des articles</a>
            </form>
        </div>
        <?php
        echo footer();
        ?>
    </body>

    </html>
<?php
}

function listeArticle($articles, $admin, $errorCode = null, $message = null)
{
    echo head();
?>

    <body>
        <?php

        echo navbar();
        if ($errorCode) {
            if ($errorCode == 9999) {    //Error Article not found
                echo "<div class='alert alert-danger text-center'>Code : $errorCode,\n Message : $message</div>";
            } else if ( $errorCode == 1027) {
                $message = "L'article n'a pas était modifiée, une erreur est survenue.";
                echo "<div class='alert alert-danger text-center'>Code : $errorCode,\n Message : $message</div>";
            }else if($errorCode == 9998){
                echo "<div class='alert alert-danger text-center'>Code : $errorCode,\n Message : $message</div>";
            } 
        }
        ?>
        <div class="container">
            <h2 class="text-center my-4">Liste des articles</h2>
            <?php

            foreach ($articles as $article) {
            ?>
                <div class="card cardBorder m-auto px-0 col-12 my-5">
                    <div class="row card-body">

                        <div class="col-10 col-md-5 m-auto p-0">
                            <img src="data:image/jpg;base64,<?php echo $article->getImageArticle(); ?>" class="imageDetailsMission rounded border" width="100" height="360" />
                            <hr class="hrGreen">
                        </div>

                        <div class="col-12 col-md-6">
                            <h4>Date : <?php echo $article->getDateArticle()->format('d-m-Y'); ?> </h4>
                            <hr class="my-2">
                            <div>
                                <h4>Description</h4>
                                <p><?php echo $article->getDescriptionArticle(); ?>
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer text-center w-100">
                        <h4 class="card-title"><?php echo $article->getTitreArticle() ?></h4>
                        <div class="m-auto my-1">
                            <a href="/HUMAN_HELP/Controller/BlogController/detailsBlogController.php?idArticle=<?php echo $article->getIdArticle(); ?>" class="btn btnGreen w-50">Lire l'article</a>
                        </div>
                        <?php if ($admin) { ?>
                            <div class="m-auto">
                                <a href="/HUMAN_HELP/Controller/BlogController/listeBlogController.php?action=delete&idArticle=<?php echo $article->getIdArticle(); ?>" class="btn btn-danger w-50">Supprimer</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <hr class="my-4">

            <?php
            }
            ?>
        </div>
        <?php if ($admin) { ?>
            <div class="col-10 col-md-6 m-auto">
                <a class="btn btnGreen w-100 mb-4" href="/HUMAN_HELP/Controller/BlogController/formulaireArticleController.php?action=add">Ajouter un nouvel article</a>
            </div>
        <?php } ?>
        <?php
        echo footer();
        ?>
    </body>

    </html>
<?php
}

function detailArticle($article, $avis, $admin = null, $idUtil = null, $pseudoUtil = null, $errorCode = null, $message = null)
{
    echo head();
?>

    <body>
        <?php

        echo navbar();
        if ($errorCode != null && $errorCode == 1027) {
            $message = "L'article n'a pas était modifiée, une erreur est survenue.";
            echo "<div class='alert alert-danger text-center'>Code : $errorCode,\n Message : $message</div>";
        } elseif (isset($errorCode) && $errorCode == 9958) {
            echo "<div class='alert alert-success text-center'>$message</div>";
        }
        ?>
        <div class="container">


            <h2 class="text-center my-5"><?php echo $article->getTitreArticle(); ?></h2>

            <div class="p-2">
                <p>
                    <?php echo $article->getDescriptionArticle(); ?>
                </p>
            </div>


            <hr class="my-4">

            <div class="row my-4 m-auto">
                <div class="*col-12 col-md-6 m-auto">
                    <h3>Description :</h3>
                    <p>
                        <?php echo $article->getDescriptionArticle(); ?>
                    </p>
                    <p>Date : <?php echo $article->getDateArticle()->format('d-m-Y'); ?> </p>
                </div>
                <div class="col-10 col-md-5 m-auto p-0">
                            <img src="data:image/jpg;base64,<?php echo $article->getImageArticle(); ?>" class="imageDetailsMission rounded border" width="100" height="360" />
                            <hr class="hrGreen">
                </div>
            </div>


            <hr class="my-4">

            <div class="text-center my-3">
                <a href="/HUMAN_HELP/Controller/BlogController/listeBlogController.php" class="btn btnGreen w-50">Retour à la liste des articles</a>
            </div>
            <?php if ($admin) { ?>
                <div class="offset-4">
                    <a href="/HUMAN_HELP/Controller/BlogController/formulaireArticleController.php?action=update&idArticle=<?php echo $article->getIdArticle(); ?>" class="btn btn-primary col-12 col-md-3 my-2 w-50">Modifier</a>
                    <a href="/HUMAN_HELP/Controller/BlogController/listeBlogController.php?action=delete&idArticle=<?php echo $article->getIdArticle(); ?>" class="btn btn-danger col-12 col-md-3 my-2 w-50">Supprimer</a>
                </div>
            <?php } ?>
            <?php
            if (!empty($_SESSION)) {
                echo FormulaireAvis($article->getIdArticle(), $idUtil, $pseudoUtil);
            }
            echo listeAvis($avis, $article->getIdArticle());


            ?>
        </div>

        </div>
        <?php
        echo footer();
        ?>
    </body>

    </html>
<?php
}

function FormulaireAvis(int $idArticle, $idUtil = null, $pseudoUtil = null)
{
?>
    <div class="container col-12 col-md-10 pt-2 my-2 border rounded">

        <h2 class="text-center my-2 pb-2">Commenter l'article</h2>

        <form class="col-5 offset-3" action="/HUMAN_HELP//Controller/AvisController/listeAvisController.php?action=add&idArticle=<?php echo $idArticle; ?>" method="POST">
            <input type="hidden" id="idArticle" name="idArticle" value="<?php echo $idArticle; ?>">
            <input type="hidden" id="auteurAvis" name="auteurAvis" value="<?php echo $pseudoUtil; ?>">
            <input type="hidden" name="dateCommentaire" value="<?php echo date("F j, Y, g:i a"); ?>">
            <input type="hidden" id="idUtilisateur" name="idUtilisateur" value="<?php echo $idUtil; ?>">

            <textarea class="col mb-3 offset-2" name="temoignage" placeholder="Ecrivez votre commentaire..." id="temoignage" required> </textarea>
            <button class="btn btnGreen btn-lg btn-block mb-3 offset-2" type="submit">Poster un commentaire</button>
        </form>

    </div>
<?php
}
function listeAvis($avis, $idArticle)
{

?>
    <?php if (!empty($avis)) { ?>
        <h1 style="font-size: 24px;">Commentaires : </h1>
    <?php } ?>
    <div>
        <?php foreach ($avis as $commentaire) { ?>
            <input type=hidden id="<?php echo "idAvis" . $commentaire->getIdAvis(); ?>" name="idAvis" value="<?php echo $commentaire->getIdAvis(); ?>">
            <input type=hidden id="idUtil" value="<?php echo $commentaire->getIdUtilisateur(); ?>">

            <div class="avis" style="background: #eee ; border-radius:10px;">
                <p><span style="font-weight: bold;"> De <?php echo (searchUserNameById($commentaire->getIdUtilisateur())); ?> :</span><span id="<?php echo "modifTemoignage" . $commentaire->getIdAvis(); ?>"> <?php echo $commentaire->getTemoignage(); ?></span> . </br> <span style="font-size:12px;"> Le <?php echo $commentaire->getDateCommentaire()->format('d-m-Y'); ?></span> </p>
            </div>

            <?php if (!empty($_SESSION) && $_SESSION['idUtil'] == $commentaire->getIdUtilisateur()) { ?>
                <div>
                    <a href="/HUMAN_HELP/Controller/AvisController/listeAvisController.php?action=delete&idAvis=<?php echo $commentaire->getIdAvis(); ?>&idArticle=<?php echo $idArticle; ?>" class="btn btn-danger w-25">Supprimer</a>
                    <button id = "btnModif" class="btn btn-success w-25" onclick="update()">Modifier</button>
                </div>
            <?php } ?>
            <hr class="my-4">

        <?php } ?>

    </div>
    <script>
        function update() {
            // window.alert("cliquez sur votre commentaire pour le modifier");
            // alert("cliquez sur votre commentaire pour le modifier");
            $('.avis span').click(function(e) {

                var currentId = e.currentTarget.id;
                var temoignage = document.getElementById(currentId);
                var auteur = document.getElementById("auteurAvis").value;
                var avisId = currentId.replace("modifTemoignage", "");
                var idAvis = document.getElementById("idAvis" + avisId).value;
                var idUtilisateur = document.getElementById("idUtilisateur").value;
                var idArticle = document.getElementById("idArticle").value;
                
                temoignage.addEventListener('click', function(e) {

                    this.setAttribute('data-clicked', 'yes');
                    this.setAttribute('data-text', this.innerHTML);


                    var input = document.createElement("input");
                    input.type = "text";
                    input.value = this.innerText; // garder la valeur de la cellule dans l'input
                    //***************************************************************************************** */
                    var input2 = document.createElement("input");
                    input2.name = "auteur";
                    input2.type = "hidden";
                    input2.value = auteur;
                    input2.textContent = auteur;

                    var input3 = document.createElement("input");
                    input3.name = "idAvis";
                    input3.type = "hidden";
                    input3.value = idAvis;
                    input3.textContent = idAvis;

                    var input4 = document.createElement("input");
                    input4.name = "idUtilisateur";
                    input4.type = "hidden";
                    input4.value = idUtilisateur;
                    input4.textContent = idUtilisateur;

                    var input5 = document.createElement("input");
                    input5.name = "idArticle";
                    input5.type = "hidden";
                    input5.value = idArticle;
                    input5.textContent = idArticle;


                    // *********************************************************************************************

                    input.onblur = function() { // onblur éxécute le code quand la personne sort d'un input il y a aussi change et focusOut
                        var temoignage = input.parentElement;
                        var originalText = input.parentElement.getAttribute("data-text");
                        var currentText = this.value;

                        if (originalText != currentText) {
                            temoignage.removeAttribute('data-clicked');
                            temoignage.removeAttribute('data-text');
                            temoignage.innerHTML = currentText;

                            var my_form = document.createElement('FORM');
                            my_form.name = 'myForm';
                            my_form.method = 'POST';
                            my_form.action = "/HUMAN_HELP/Controller/AvisController/listeAvisController.php?action=update" + "&idArticle=" + idArticle + "&temoignage=" + this.value;
                            document.body.appendChild(my_form);
                            my_form.appendChild(input2);
                            my_form.appendChild(input3);
                            my_form.appendChild(input4);
                            my_form.appendChild(input5);
                            console.log(my_form);

                            my_form.submit();
                        }
                    }


                    this.innerHTML = ""; // clear la td quand on clique

                    var myClickedElement = e.target;
                    myClickedElement.appendChild(input);
                    this.firstElementChild.select();
                    // console.log(temoignage);


                })
            })
        }
    </script>

<?php
}
?>