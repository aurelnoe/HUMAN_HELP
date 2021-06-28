<?php
include_once(PATH_BASE . "Presentation/PresentationMission.php");

// echo formParticipationMission();

if (isset($_GET['action'])) 
{

    if ($_GET['action'] == 'send') 
    { 
        
        $successCode = 16000;
        $to="samir-mekhloufi@hotmail.fr";
        //$to = $_POST['mail'];
        $mail="testHumanHelp@gmail.com";
        $civilite=$_POST['civilite']; 
        $header='MIME-version: 1.0' . "/r/n";
        $header .='Content-type: text/html; charset=utf-8' . "/r/n"; 
        $header .='To : Samir <' .$to. ">" ."/r/n";
        $header .='From :'. "<".$mail.">" . "/r/n";
        $sujet="Candidature Mission";
        $confirmation="l'équipe Human Help vous confirme que votre demande concernant cette mission a bien été prise en compte. Nous vous remercions pour votre engagement et vous allez etre contacté au plus vite";
        $message= $civilite. ',' . $confirmation ." ";
        
                    mail($to, $sujet, $message, $header);
                    header("Location: ../../index.php");
                    die;
                    
    }
}