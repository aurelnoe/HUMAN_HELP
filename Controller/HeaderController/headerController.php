<?php
include_once(PATH_BASE . "Services/ServicePays.php");
include_once(PATH_BASE . "Services/serviceTypeActivite.php");
include_once(PATH_BASE . "Presentation/PresentationCommun.php");

$newPays = new ServicePays();
$newTypeActivite = new ServiceTypeActivite();
try {
    $allPays = $newPays->searchAll();
    
    $allTypeActivite = $newTypeActivite->searchAll();
    
    echo navbar($allPays,$allTypeActivite);
    
} catch (\ServiceException $se) {
    $allPays = $newPays->searchAll();
    
    $allTypeActivite = $newTypeActivite->searchAll();
    
    echo navbar($allPays,$allTypeActivite,$se->getMessage(),$se->getCode());
}