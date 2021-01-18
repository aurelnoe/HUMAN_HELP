<?php

interface TypeActiviteInterface
{
    public function searchAll(); 
    public function searchById(int $id);
    public function searchNameById(int $id);
}