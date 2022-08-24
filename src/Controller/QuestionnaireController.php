<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\QuestionnaireType;
use App\Form\ChampType;
use App\Form\QuestionnaireFinalType;
use App\Entity\Questionnaire;
use App\Entity\Champ;
use App\Entity\RemplissageQuestionnaire;
use App\Service\FormHandler;
use App\Service\QuestionnaireHandler;

class QuestionnaireController extends AbstractController
{
    /**
     * @Route("/editChamp/{id}", name="edit_Champ")
     */
    public function editChamp(Request $request,int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $champRepository = $em->getRepository(Champ::class);
        $champ=$champRepository-> findOneBy( array('id' => $id));
        $formChamp = $this->createForm(ChampType::class, $champ);
        
        if($request->isMethod('POST')){
            $formChamp->handleRequest($request);
            if ($formChamp->isSubmitted() && $formChamp->isValid()) {
                $champRepository->add($champ);
                return $this->redirectToRoute('editTousChamps', array('nom' =>$champ->getQuestionnaire()->getNomTechnique()));
            }
        }

        return $this->render('questionnaire/edit_champ.html.twig', [
            'controller_name' => 'QuestionnaireController',
            'form' => $formChamp->createView(),
            'champ'=>$champ,
        ]);
    }

    /**
     * @Route("/handleform/{nom}", name="handle_form")
     */
    public function handleform(String $nom, Request $request, FormHandler $formHandler): Response
    {
        $em = $this->getDoctrine()->getManager();
        $questionnaire=$em->getRepository(Questionnaire::class)-> findOneBy( array('nomTechnique' => $nom));

        $postDone=$formHandler->handleFormFinal($request,$questionnaire);

        $formQuestionnaire = $this->createForm(QuestionnaireFinalType::class,null,['questionnaire' =>$questionnaire,]);
        
        return $this->render('questionnaire/questionnaireFinal.html.twig', [
            'controller_name' => 'QuestionnaireController',
            'titreForm'=>$questionnaire->getSujet(),
            'form' => $formQuestionnaire->createView(),
            'postDone'=>$postDone,
        ]);
    }

     /**
     * @Route("/reponses/{nom}", name="reponses_form")
     */
    public function reponsesform(String $nom, QuestionnaireHandler $QuestionnaireHandler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $em = $this->getDoctrine()->getManager();
        $questionnaire=$em->getRepository(Questionnaire::class)-> findOneBy( array('nomTechnique' => $nom));
        $reponseFormate= $QuestionnaireHandler->prepareResponseToView($questionnaire);

        $fichierCSV= $QuestionnaireHandler->prepareCSV($reponseFormate);
        
        return $this->render('questionnaire/reponsesQuestionnaireFinal.html.twig', [
            'controller_name' => 'QuestionnaireController',
            'form'=>$questionnaire->getSujet(),
            'formId'=>$questionnaire->getId(),
            'reponses'=>$reponseFormate,
            'fichierCSV'=>$fichierCSV,
        ]);
    }

    /**
     * @Route("/accueilform", name="accueil_form")
     */
    public function accueilform(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $questionnaire=new Questionnaire();
        $formQuestionnaire = $this->createForm(QuestionnaireType::class, $questionnaire);
        if($request->isMethod('POST')){
            $formQuestionnaire->handleRequest($request);
            if ($formQuestionnaire->isSubmitted() && $formQuestionnaire->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $QuestionnaireRepository = $em->getRepository(Questionnaire::class);
                $QuestionnaireRepository->add($questionnaire);
            }
        }

        $em = $this->getDoctrine()->getManager();
        $questionnaires=$em->getRepository(Questionnaire::class)->findAll();
        
        return $this->render('questionnaire/accueilForm.html.twig', [
            'controller_name' => 'QuestionnaireController',
            'form' => $formQuestionnaire->createView(),
            'questionnaires'=>$questionnaires,
        ]);
    }
 
    /**
     * @Route("/editTousChamps/{nom}", name="editTousChamps")
     */
    public function editTousChamps(String $nom,Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $champ=new Champ();
        $formChamp = $this->createForm(ChampType::class, $champ);
        if($request->isMethod('POST')){
            $formChamp->handleRequest($request);
            if ($formChamp->isSubmitted() && $formChamp->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $champRepository = $em->getRepository(Champ::class);
                $champRepository->add($champ);
            }
        }

        $em = $this->getDoctrine()->getManager();
        $questionnaire=$em->getRepository(Questionnaire::class)-> findOneBy( array('nomTechnique' => $nom));
        $champs=$questionnaire->getChampsOrdered();
        return $this->render('questionnaire/editTousChamps.html.twig', [
            'controller_name' => 'QuestionnaireController',
            'form' => $formChamp->createView(),
            'questionnaire'=>$questionnaire,
            'champs'=>$champs,
        ]);
    }

    /**
     * @Route("/supprimerQuestionnaire/{id}", name="SupprimerQuestionnaire")
     */
    public function supprimerQuestionnaire(int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $questionnaireRepository = $em->getRepository(Questionnaire::class);
        $questionnaire=$questionnaireRepository-> findOneBy( array('id' => $id));
        $questionnaireRepository->remove($questionnaire);
        
        return $this->redirectToRoute('accueil_form');
    }

    /**
     * @Route("/supprimerChamp/{id}{idQuestionnaire}", name="supprimerChamp")
     */
    public function supprimerChamp(int $id,int $idQuestionnaire): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $champRepository = $em->getRepository(Champ::class);
        $champ=$champRepository-> findOneBy( array('id' => $id));
        $champRepository->remove($champ);

        $questionnaire=$em->getRepository(Questionnaire::class)-> findOneBy( array('id' => $idQuestionnaire));
        
        return $this->redirectToRoute('editTousChamps', array('nom' =>$questionnaire->getNomTechnique()));
    }

    /**
     * @Route("/supprimerReponse/{id}/{idQuestionnaire}", name="supprimerReponse")
     */
    public function supprimerReponse(int $id,int $idQuestionnaire): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $rQRepository = $em->getRepository(RemplissageQuestionnaire::class);
        $rQ=$rQRepository -> findOneBy( array('id' => $id));
        $rQRepository ->remove($rQ);

        $questionnaire=$em->getRepository(Questionnaire::class)-> findOneBy( array('id' => $idQuestionnaire));
        
        return $this->redirectToRoute('reponses_form', array('nom' =>$questionnaire->getNomTechnique()));
    }
}
