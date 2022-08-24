<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Conge;
use App\Repository\CongeRepository;
use App\Repository\EmployeeInformationRepository;

class AgendaConge
{
    private CongeRepository $congeRepository;


    public function __construct(EntityManagerInterface $em, CongeRepository $congeRepository, EmployeeInformationRepository $employeeIRepository)
    {
        $this->em = $em;
        $this->congeRepository = $congeRepository;
        $this->employeeIRepository = $employeeIRepository;
    }


    public function tabEmployePrenantConge()
    {
        $employeeIRepository = $this->employeeIRepository;
        $employees=$employeeIRepository->findAll();
        return $employees;
    }

    public function getAgenda()
    {
        $congeRepository = $this->congeRepository;
        $conges=$congeRepository->findAll();
        $aRetourner=[];
        $j=0;
        for($mois= strtotime('first day of this month midnight');$mois<strtotime('first day of this month +6 month');$mois=strtotime('+1 month',$mois)){
            $aRetourner[$j]=[
                "mois"=>$mois,
                "html"=>$this->getHtmlMois($mois)
            ];
            $j++;
        }  
        return $aRetourner; 
    }

    public function getHtmlMois(int $mois)
    {
        $j=0;
        $conges=$this->congeRepository->findAll();
        for($jour= $mois ; $jour< strtotime('+1 month',$mois) ; $jour=strtotime('+24 hour',$jour)){
            

            $j++;
            $ecrit=false;

            $aRetourner[$j]=[
                "jour"=>$jour,
                "html"=>[],                  
            ];
            $employes=$this->employeeIRepository->findAll();
            foreach ($employes as $employe){
                $index=$employe->__toString();
                $aRetourner[$j]["html"]["$index"]="";
            }

            if( $jour> time()){
                foreach ($conges as $conge){ 

                    $index=$conge->getEmployeInformation()->__toString();

                    if ($conge->getDebut()->getTimestamp()<=strtotime('+24 hour',$jour)
                    && $conge->getFin()->getTimestamp()>=$jour)
                    {
                        $aRetourner[$j]["html"]["$index"]="<div class='employe_cell ".$index."'></div>";
                        $ecrit=true;

                    }elseif($aRetourner[$j]["html"]["$index"]==""){
                        $aRetourner[$j]["html"]["$index"]=$aRetourner[$j]["html"]["$index"]."<div class='employe_cell'></div>";
                    }
                }
                if(!$ecrit){
                    $aRetourner[$j]["html"]="<div class></div>";
                }
            }else{
                $aRetourner[$j]["html"]["passe"]="<div class='passe'>passé</div>";
            }
        } 
        return $aRetourner;
    }
    
}