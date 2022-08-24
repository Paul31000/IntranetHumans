<?php

namespace App\Controller;

use App\Entity\OccupationSalle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Salle;
use App\Repository\SalleRepository;
use App\Service\AgendaSalle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\BookingSalleType;
use App\Repository\OccupationSalleRepository;
use Symfony\Contracts\Translation\TranslatorInterface;
use \DateTime;


class BookingSallesController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/agenda_salles", name="agenda_salles")
     */
    public function agenda(agendaSalle $SalleSvc, OccupationSalleRepository $OCR): Response
    {
        $OCR->removeAllOld();
        $agenda=$SalleSvc->getAgenda();
        return $this->render('reservationSalle/calendrier.html.twig', [
            'controller_name' => 'BookingSallesController',
            'agenda'=>$agenda,
        ]);
    }


    /**
     * @Route("/booking_salle", name="booking_salle")
     * @param Request $request
     */
    public function bookingSalle(Request $request,agendaSalle $SalleSvc): Response
    {
        $status="chargement";
        $occupationSalle= new OccupationSalle;
        $formBooking  = $this->createForm(BookingSalleType::class,$occupationSalle);

        if($request->isMethod('POST')){
            $formBooking->handleRequest($request);
            if ($formBooking->isSubmitted()) {
                $status="mauvaise_requete";
                $OccupationSalleRepo = $this->getDoctrine()->getRepository(OccupationSalle::class);
                $SalleRepo = $this->getDoctrine()->getRepository(Salle::class);
                $occupationSalle->setCreneau(DateTime::createFromFormat('d/m/Y\, H:i', $request->request->all()["booking_salle"]["creneau"]));
                $occupationSalle->setfinCreneau(DateTime::createFromFormat('d/m/Y\, H:i', $request->request->all()["booking_salle"]["finCreneau"]));
                if(! $SalleSvc->isAlreadyBooked($occupationSalle)){
                    $OccupationSalleRepo->add($occupationSalle);
                    $occupationSalle->getSalle()[0]->setOccupationSalle($occupationSalle);
                    $SalleRepo->add($occupationSalle->getSalle()[0]);
                    return $this->redirectToRoute('agenda_salles');
                }            
            }
        }
        return $this->render('reservationSalle/booking.html.twig', [
            'controller_name' => 'LienController',
            'form' => $formBooking->createView(),
            'status'=>$status,
        ]);
    }
}
