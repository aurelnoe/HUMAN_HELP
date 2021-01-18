<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/Security/config.php");
session_start();
include_once(PATH_BASE . "/Presentation/PresentationCommentCaMarche.php");

try {
    echo commentCaMarche();
}
catch (ServiceException $se) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}