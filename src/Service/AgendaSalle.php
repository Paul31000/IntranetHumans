<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\OccupationSalle;
use App\Repository\SalleRepository;

class AgendaSalle
{
    private SalleRepository $salleRepository;


    public function __construct(EntityManagerInterface $em, SalleRepository $salleRepository)
    {
        $this->em = $em;
        $this->salleRepository = $salleRepository;
    }


    public function isAlreadyBooked(OccupationSalle $occupationSalle): Bool
    {
        $salleCreneaux= $occupationSalle->getSalle()[0]->getOccupationSalle();
        foreach ($salleCreneaux as $creneau){
            if ($creneau->getCreneau()->getTimestamp()<$occupationSalle->getFinCreneau()->getTimestamp()
             && $occupationSalle->getCreneau()->getTimestamp()<$creneau->getFinCreneau()->getTimestamp()){
                return true;
            }
        }
        return false;
    }

    public function getAgenda()
    {
        $repositorySalle = $this->salleRepository;
        $salles=$repositorySalle->findAll();
        $aRetourner=[];
        foreach($salles as $j => $salle) {
            $salleCreneau= $salle->getOccupationSalle();
            $aRetourner[$j]=[
                "nomSalle"=>$salle->getNom(),
                "tabOccupation"=>$this->constructDispo($salleCreneau)
            ];
        }
        return $aRetourner;  
    }

    public function constructDispo($salleCreneaux)
    {
        $aRetourner=[];
        $j=0;
        $monday=strtotime('monday this week');
        for($jour= $monday;$jour<strtotime('+14 day',$monday);$jour=strtotime('+1 day',$jour)){
            $aRetourner[$j]=[
                "jour"=>$jour,
                "html"=>$this->getHtmlJour($jour,$salleCreneaux)
            ];
            $j++;
        }  
        return $aRetourner;
    }


    public function getHtmlJour(int $jour,$salleCreneaux)
    {
        $aRetourner=[];
        $j=0;
        for($heure= strtotime('+8 hours',$jour);$heure< strtotime('+19 hours',$jour );$heure=strtotime('+15 minutes',$heure)){
            $ecrit=false;
            $j++;
            if( $heure> time()){
                foreach ($salleCreneaux as $creneau){
                    if ($creneau->getCreneau()->getTimestamp()<strtotime('+15 minutes',$heure)
                    && $creneau->getFinCreneau()->getTimestamp()>$heure ){
                        $aRetourner[$j]=[
                            "heure"=>$heure,
                            "html"=>"<div class='occupe'>".$creneau->getEmployeOccupant()->getNom()."</div>",                  
                        ];
                        $ecrit=true;
                    }
                }
                if (! $ecrit){
                    $aRetourner[$j]=[
                        "heure"=>$heure,
                        "html"=>"<div class='libre'>libre</div>"              
                    ];
                }
            }else{
                $aRetourner[$j]=[
                    "heure"=>$heure,
                    "html"=>"<div class='passe'>passé</div>"              
                ];
            }
        } 
        return $aRetourner;
    }
    
}