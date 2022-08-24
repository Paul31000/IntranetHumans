<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\LienPage;
use App\Form\EditLienPagesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Page;
use App\Service\FileUploader;
use App\Service\FormHandler;
use App\controller\PageController;
use Symfony\Component\String\Slugger\SluggerInterface;

class LienController extends AbstractController
{
    /**
     * @Route("/editlien/{id}", name="app_lien")
     * @param Request $request
     */
    public function editLien(int $id,Request $request, SluggerInterface $slugger, FormHandler $formHandler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $lien = $em->getRepository(LienPage::class)->find($id);
        $formLien = $this->createForm(EditLienPagesType::class, $lien);
        $formHandler->handleLienPageForm($request,$formLien,$lien);
        
        $repositoryPages = $this->getDoctrine()->getRepository(Page::class);
        $pages = $repositoryPages->findAll();
        $repositoryCat = $this->getDoctrine()->getRepository(Categorie::class);
        $categories = $repositoryCat->findAll();
        return $this->render('lien/editLien.html.twig', [
            'controller_name' => 'LienController',
            'form' => $formLien->createView(),
            'lienVise' => $lien,
            'pages' => $pages,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/ajouterlienpage", name="AjouterLienAPage")
     * @param Request $request
     */
    public function ajouterLienAPage(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $lien=$em->getRepository(LienPage::class)->find($request->get('idLien'));
        $page=$em->getRepository(Page::class)->find($request->get('idPage'));
        $page->addLien($lien);
        $lien->addPage($page);
        $em->persist($lien);
        $em->persist($page);
        $em->flush();
        return $this->redirectToRoute('app_lien', array('id' =>$request->get('idLien')));
    }

    /**
     * @Route("/supprimerLienRedirectLien", name="SupprimerLienRedirectLien")
     * @param Request $request
     */
    public function supprimerLienRedirectLien(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $totaliteDuLien = $this->supprimerLienPage($request);
        if (! $totaliteDuLien){
            return $this->redirectToRoute('app_lien', array('id' =>$request->get('idLien')));
        }
        return $this->redirectToRoute('edit');
    }


    /**
     * @Route("/supprimerLienRedirectPage", name="SupprimerLienRedirectPage")
     * @param Request $request
     */
    public function supprimerLienRedirectPage(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $this->supprimerLienPage($request);
        return $this->redirectToRoute('edit');
    }

    /**
     * @param Request $request
     * @return bool
     * true si la totalité du lien à étée suprimée
     */
    public function supprimerLienPage(Request $request): bool
    {
        $em = $this->getDoctrine()->getManager();
        $lien = $em->getRepository(LienPage::class)->find($request->get('idLien'));
        $page = $em->getRepository(Page::class)->find($request->get('idPage'));
        $page->removeLien($lien);
        $lien->removePage($page);
        $em->persist($lien);
        $em->persist($page);
        $em->flush();
        if(($lien->getPages())->isEmpty()){
            $em->getRepository(LienPage::class)->remove($lien);
            return true;
        }
        return false;
    }

    /**
     * @Route("/ajoutercategorielien", name="AjouterCategorieLien")
     * @param Request $request
     */
    public function ajouterCategorieLien(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $lien=$em->getRepository(LienPage::class)->find($request->get('idLien'));
        $categorie=$em->getRepository(Page::class)->find($request->get('idCategorie'));
        $categorie->addLienPage($lien);
        $lien->addCategorie($categorie);
        $em->persist($lien);
        $em->persist($categorie);
        $em->flush();
        return $this->redirectToRoute('app_lien');
    }

    /**
     * @Route("/supprimercategorielien", name="SupprimerCategorieLien")
     * @param Request $request
     */
    public function supprimerCategorieLien(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $lien=$em->getRepository(LienPage::class)->find($request->get('idLien'));
        $categorie=$em->getRepository(Page::class)->find($request->get('idCategorie'));
        $categorie->removeLienPage($lien);
        $lien->removeCategorie($categorie);
        $em->persist($lien);
        $em->persist($categorie);
        $em->flush();
        return $this->redirectToRoute('app_lien', array('id' =>$request->get('idLien')));
    }


}
