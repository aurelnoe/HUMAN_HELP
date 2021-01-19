<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/Security/config.php");
include_once(PATH_BASE . "/Presentation/PresentationContact.php");

echo formulaireContact();

if (isset($_GET['action'])) 
{

    if ($_GET['action'] == 'send') 
    { 
       
        $to="samir-mekhloufi@hotmail.fr";
        $mail="testHumanHelp@gmail.com";
        $nom=$_POST['nomContact']; 
        $prenom=$_POST['prenomContact'];
        $header='MIME-version: 1.0' . "/r/n";
        $header .='Content-type: text/html; charset=utf-8' . "/r/n"; 
        $header .='To : Samir <' .$to. ">" ."/r/n";
        $header .='From :'. "<".$mail.">" . "/r/n";
        $tel=$_POST['NumContact'];
        $sujet=$_POST['objetContact'];
        $demande=$_POST['messageContact'];
        $message= $nom. ',' . $prenom . ', Tel :' . $tel . ', Sujet : ' . $sujet . ', Message : ' . $demande ." ";
        
                    mail($to, $sujet, $message, $header);
    }
}