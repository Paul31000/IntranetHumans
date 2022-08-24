<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\EmployeeInformation;
use App\Form\EmployeeInformationType;

class EmployeeInformationController extends AbstractController
{

    /**
     * @Route("/employee_submit", name="employee_submit")
     * @param Request $request
     */
    public function editEmployee(Request $request): Response
    {
        $postDone=false;
        $employee=new EmployeeInformation();
       
        $formEmployee  = $this->createForm(EmployeeInformationType::class, $employee);

        if($request->isMethod('POST')){
            $formEmployee->handleRequest($request);

            if ($formEmployee->isSubmitted() && $formEmployee->isValid()) {
                $employeeRepository = $this->getDoctrine()->getRepository(EmployeeInformation::class);
                $employeeRepository->add($employee);
                $postDone=true;
            }
        }
        $employeeRepository = $this->getDoctrine()->getRepository(EmployeeInformation::class);
        return $this->render('employee_information/page.html.twig',[
            'controller_name' => 'EmployeeInformationController',
            'form' => $formEmployee->createView(),
            'postDone'=>$postDone, 
            
        ]);
    }

    /**
     * @Route("/employee_information", name="employee_information")
     * @param Request $request
     */
    public function employeeAdminPage()
    {
        $employeeRepository = $this->getDoctrine()->getRepository(EmployeeInformation::class);
        $employees= $employeeRepository->findAll();
        return $this->render('employee_information/pageAdmin.html.twig',[
            'controller_name' => 'EmployeeInformationController',
            'employees'=>$employees, 
            
        ]);
    }

    /**
     * @Route("/supprimerAnniversaire", name="supprimerAnniversaire")
     * @param Request $request
     */
    public function supprimerLienRedirectLien(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $employeeRepository = $this->getDoctrine()->getRepository(EmployeeInformation::class);
        $employeeInformation = $employeeRepository->find($request->get('idEmployee'));
        $employeeRepository->remove($employeeInformation);
        return $this->redirectToRoute('employee_information');
    }


    public function getBirthdays(){
        $birthdaysRepository = $this->getDoctrine()->getRepository(EmployeeInformation::class);
        $birthdays= $birthdaysRepository->getbirthdays();
        return $this->render('employee_information/displayBirthdays.html.twig',[
            'birthdays' => $birthdays
        ]);
    }
}
