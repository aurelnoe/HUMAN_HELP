<?php

interface RoleInterface
{
    public function searchAll(); 
    public function searchById(int $id);
}