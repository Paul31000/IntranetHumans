<?php

namespace App\Controller;

use App\Entity\LienPage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\LienPageRepository;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     */
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchBar()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn-rechercher'
                ]
            ])
            ->getForm();
        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/handleSearch", name="handleSearch")
     * @param Request $request
     */
    public function handleSearch(Request $request, LienPageRepository $repo)
    {
        $query = $request->request->get('form')['query'];
        if($query) {
            $liens = $repo->findLienByName($query);
        }
        if(empty($liens)){
            return $this->render('search/searchFail.html.twig', [
                'controller_name' => 'PageController',
            ]);
        }
        $categorieDuLien=$liens[0]->getCategorie();
        $pageDuLien=$liens[0]->getPages();
        return $this->render('search/resultSearch.html.twig', [
            'controller_name' => 'PageLiensController',
            'liens'       => $liens,
        ]);
        return $this->redirectToRoute('app_page_liens', array('cat' =>($categorieDuLien[0]->getNom()),'title' =>($pageDuLien[0])->getNomUrl()));
        
    }
}
