<?php
namespace App\Service;

use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\LienPage;
use App\Entity\Categorie;
use App\Entity\Page;
use App\Entity\RemplissageQuestionnaire;

class QuestionnaireHandler
{

    public function __construct(EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
        $this->em = $em;
    }

    public function prepareResponseToView($questionnaire)
    {
        $reponses=$questionnaire->getRemplissages();
        $champs=$questionnaire->getChamps();
        $reponseFormate=array();
        $i=0;
        foreach($reponses as $reponse){
            $i++;
            $json= json_decode($reponse->getValeur(),true);
            $reponseReponse["pseudo"][0]=$reponse->getPseudo();
            $reponseReponse["id"][0]=$reponse->getId();
            
            $j=0;
            foreach($champs as $champ){
                $j++;
                $reponseElement=["libelle"=>$champ->getLibelle()];
                $reponseElement=$reponseElement+["reponse"=>$json[$champ->getNomTechnique()]];
                $reponseReponse["champs"][$j]=$reponseElement;
            }
            $reponseFormate[$i]=$reponseReponse;
        }
        return $reponseFormate;
    }


    public function prepareCSV($reponseFormate)
    {
        $fp = fopen('../public/file.csv', 'w');

        $tableauPseudo=[0=>"pseudo"];
        $i=0;
        foreach ($reponseFormate as $field) {
            $i++;
            $tableauPseudo[$i]=$field["pseudo"][0];
            
        } 
        fputcsv($fp,$tableauPseudo);

        $i=0;
        if(count($reponseFormate)!=0){
            foreach ($reponseFormate[1]["champs"] as $field) {
                $i++;
                $j=0;
                $tableauChamps[$i][$j]=$reponseFormate[1]["champs"][$i]["libelle"];
                foreach ($reponseFormate as $field) {
                    $j++;
                    $tableauChamps[$i][$j]=$field["champs"][$i]["reponse"];
                }
                fputcsv($fp,$tableauChamps[$i]);
            } 
        }
        fclose($fp);
    }
  
}