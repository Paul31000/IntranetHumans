<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Role;


class AdminController extends AbstractController
{
    /**
     * @Route("/adminUser", name="app_admin")
     */
    public function adminUser(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $repository   = $this->getDoctrine()->getRepository(Role::class);
        $listeRole  = $repository->findAll();
        return $this->render('admin/adminUser.html.twig', [
            'listeRole' => $listeRole,
            'controller_name' => 'AdminController'
        ]);
    }

    /**
    * @Route("/deletePrivilege", name="deletePrivilege")
    * @param Request $request
    */
    public function deleteAction(Request $request):Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($request->get('id'));
        $role = $em->getRepository(Role::class)->find($request->get('roleId'));
        $user->removeRole($role);
        $em->persist($user);
        $em->flush();

        if($request->get('roleId')=='3'){
            $em->remove($user);
            $em->flush();
        }
        
        return $this->redirectToRoute('app_admin');
    }

    /**
    * @Route("/addPrivilege", name="addPrivilege")
    * @param Request $request
    */
    public function addRoleAction(Request $request):Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($request->get('id'));
        $role = $em->getRepository(Role::class)->find($request->get('roleId'));
        $user->addRole($role);
        $em->persist($user);
        $em->flush();
        
        return $this->redirectToRoute('app_admin');
    }
}
