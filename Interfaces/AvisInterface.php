<?php
include_once("DAOInterface.php");

interface AvisInterface extends DAOInterface
{
    public function searchByIdArticle($idBlog);
}