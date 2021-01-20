<?php
include_once("DAOInterface.php");

interface BlogInterface extends DAOInterface
{
    public function searchAllArticle(int $getPage);
    public function countPageArticles();
}