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

class FormHandler
{

    public function __construct(EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
        $this->em = $em;
    }

    public function handleLienPageForm($request,$formLien,$lien)
    {
        if($request->isMethod('POST')){
            $formLien->handleRequest($request);

            if ($formLien->isSubmitted() && $formLien->isValid()) {
                if(($formLien->get('image')->getData()) !== null){
                    $repositoryPages = $this->em->getRepository(LienPage::class);
                    $repositoryPages->removeImage($lien);
                    $fileUploader = new FileUploader('uploads/images', $this->slugger);
                    $lien->setImage($fileUploader->upload($formLien->get('image')->getData()));
                }
                $this->registerlien($request, $lien);
            }
        }
    }

    public function handlePageForm($request,$formPage,$page)
    {
        if($request->isMethod('POST')){
            $formPage->handleRequest($request);

            if ($formPage->isSubmitted() && $formPage->isValid()) {
                $fileUploader=new FileUploader('uploads/images',$this->slugger);
                $page->setImage($fileUploader->upload($formLien->get('image')->getData()));
                $pageRepository = $this->em->getRepository(Page::class);
                $pageRepository->add($page);
            }
        }
    }

    
    public function handleFormFinal($request,$questionnaire)
    {
        $postDone=false;
        if($request->isMethod('POST')){
            $postDone=true;

            $remplissageQuestionnaire = new RemplissageQuestionnaire();
            $remplissageQuestionnaire->setPseudo($request->get('questionnaire_final')['pseudo']);
            $remplissageQuestionnaire->setQuestionnaire($questionnaire);

            $result=array();
            $champs=$questionnaire->getChamps();
            foreach($champs as $champ){
                $nomTech=$champ->getNomTechnique();
                $value= $request->get('questionnaire_final')[$nomTech];
                $add= array( "$nomTech" => "$value");
                $result = $result + $add;
            }
            $remplissageQuestionnaire->setValeur(json_encode($result));

            $remplissageQuestionnaireRepository = $this->em->getRepository(RemplissageQuestionnaire::class);
            $remplissageQuestionnaireRepository->add($remplissageQuestionnaire);
        }
        return $postDone;
    }

    /**
     * @param Request $request
     * @param LienPage $lien
     * @return mixed|object|null
     */
    public function registerlien(Request $request, LienPage $lien)
    {
        $pageId = $request->request->get('edit_lien_pages')['pages'];
        $pageRepository = $this->em->getRepository(Page::class);
        $page = $pageRepository->find($pageId[0]);
        $page->addLien($lien);
        $lienRepository = $this->em->getRepository(LienPage::class);
        $lienRepository->add($lien);
        $lien->addPage($page);

        $categorieId = $request->request->get('edit_lien_pages')['categorie'];
        $categorieRepository = $this->em->getRepository(Categorie::class);
        $categorie = $categorieRepository->find($categorieId[0]);
        $categorie->addLienPage($lien);
        $lien->addCategorie($categorie);
        return $page;
    }

}