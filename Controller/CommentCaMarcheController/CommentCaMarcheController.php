<?php
include_once(PATH_BASE . "/Presentation/PresentationCommentCaMarche.php");

try {
    echo commentCaMarche();
}
catch (ServiceException $se) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}