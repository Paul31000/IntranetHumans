<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\EditeurMessageType;
use App\Entity\Message;


class MessageController extends AbstractController
{
    /**
     * @Route("/modifMessage", name="Modif_message")
     * @param Request $request
     */
    public function editLien(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $repository = $this->getDoctrine()->getRepository(Message::class);
        $Messages = $repository->findAll();
       
        if(empty($Messages)){
            $Message=new Message();
        }else{
            $Message=$Messages[0];
        }
        
        $formMessage  = $this->createForm(EditeurMessageType::class, $Message);

        if($request->isMethod('POST')){
            $formMessage->handleRequest($request);

            if ($formMessage->isSubmitted() && $formMessage->isValid()) {
                $MessageRepository = $this->getDoctrine()->getRepository(Message::class);
                $MessageRepository->add($Message);
                
            }
        }

        return $this->render('message/editMessage.html.twig', [
            'controller_name' => 'LienController',
            'form' => $formMessage->createView(),
        ]);
    }

    public function getMessage(){
        $MessageRepository = $this->getDoctrine()->getRepository(Message::class);
        if(!empty($MessageRepository->getmessage())){
            $message= $MessageRepository->getmessage()[0];
        }else{
            $message=new Message();
        }
        return $this->render('message/displayMessage.html.twig',[
        'message' => $message
        ]);
    }
}
