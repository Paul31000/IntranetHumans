<?php

namespace App\Controller;

use App\Entity\Conge;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AgendaConge;
use App\Repository\CongeRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CongeBookingType;
use \DateTime;

class BookingCongeController extends AbstractController
{
    /**
     * @Route("/agenda_conge", name="agenda_conge")
     */
    public function agenda(AgendaConge $congeSvc, CongeRepository $OCR): Response
    {
        //$OCR->removeAllOld();
        $agenda=$congeSvc->getAgenda();
        dump($agenda);
        $employes=$congeSvc->tabEmployePrenantConge();
        return $this->render('booking_conge/calendrier.html.twig', [
            'controller_name' => 'BookingSallesController',
            'agenda'=>$agenda,
            'employes'=>$employes,
        ]);
    }

    /**
     * @Route("/booking_conge", name="booking_conge")
     * @param Request $request
     */
    public function bookingConge(Request $request): Response
    {
        $conge= new Conge;
        $formBooking  = $this->createForm(CongeBookingType::class,$conge);
        if($request->isMethod('POST')){
            $formBooking->handleRequest($request);
            if ($formBooking->isSubmitted()) {
                $congeRepo = $this->getDoctrine()->getRepository(Conge::class);
                $conge->setDebut(DateTime::createFromFormat('d/m/Y\, H:i', $request->request->all()["conge_booking"]["debut"]));
                $conge->setFin(DateTime::createFromFormat('d/m/Y\, H:i', $request->request->all()["conge_booking"]["fin"]));
                $congeRepo->add($conge);
                return $this->redirectToRoute('agenda_conge');
            }            
        }
        return $this->render('booking_conge/booking.html.twig', [
            'controller_name' => 'LienController',
            'form' => $formBooking->createView()
        ]);
    }
}
