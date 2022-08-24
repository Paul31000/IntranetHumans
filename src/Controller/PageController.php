<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EditLienPagesType;
use App\Form\NouvellePageType;
use App\Entity\LienPage;
use App\Entity\Categorie;
use App\Service\FileUploader;
use App\Service\FormHandler;
use App\Entity\Page;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;


class PageController extends AbstractController
{

    /**
     * @Route("", name="accueil")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Page::class);
        $page = $repository->findByPage(
            ['page' => 'accueil']
        );
        $links=$page[0]->getLiens();
        return $this->render('pageLien/accueil.html.twig', [
            'controller_name' => 'PageLiensController',
            'tab_links'       => $links,
        ]);
    }

    /**
     * @Route("/page/{cat}/{title}", name="app_page_liens")
     */
    public function pageLien(String $cat,String $title): Response
    {
        $repositoryLien = $this->getDoctrine()->getRepository(LienPage::class);
        $links = $repositoryLien->findByPageAndCat( $cat ,$title);
        $repositoryPage = $this->getDoctrine()->getRepository(Page::class);
        $tabPages = $repositoryPage->findAll();
    
        return $this->render('pageLien/page_liens.html.twig', [
            'controller_name' => 'PageController',
            'tab_links'       => $links,
            'tab_page'        => $tabPages,
            'categorie'       => $cat,
            'title'           => $title,
        ]);
    }

    /**
     * @Route("/edit", name="edit")
     */
    public function edit(FormHandler $formHandler, Request $request, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $lien = new LienPage();
        $formLien = $this->createForm(EditLienPagesType::class, $lien);
        $page = new Page();
        $formPage = $this->createForm(NouvellePageType::class, $page);

        $formHandler->handleLienPageForm($request,$formLien,$lien);
        $formHandler->handlePageForm($request,$formPage,$page);
        
        $repository = $this->getDoctrine()->getRepository(Page::class);
        $pages = $repository->findAll();
        return $this->render('pageLien/page_edit.html.twig', [
            'form' => $formLien->createView(),
            'formPage' => $formPage->createView(),
            'controller_name' => 'PageController',
            'pages'       => $pages,
        ]);
    }
}
        
