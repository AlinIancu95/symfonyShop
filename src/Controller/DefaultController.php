<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Vendor;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('default/index.html.twig',
            [   'products'=>$productRepository->findBy([], ['id'=>'DESC'],4),
                'productsLaptop'=>$productRepository->findBy(['category'=>2], ['id'=>'DESC'], 4),
                'productsTV'=>$productRepository->findBy(['category'=>1], ['id'=>'DESC'], 4),
                'productsPhone'=>$productRepository->findBy(['category'=>3], ['id'=>'DESC'], 4),
            ]);
    }

    /**
     * @Route("/category/{category}", name="category")
     */
    public function category(Category $category): Response
    {
        return $this->render('default/category.html.twig',
            ['category'=>$category
            ]);
    }

    /**
     * @Route("/vendor/{vendor}", name="vendor")
     */
    public function vendor(Vendor $vendor): Response
    {
        return $this->render('default/vendor.html.twig',
            [   'vendor'=>$vendor,
            ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/adminPanel/", name="adminPanel")
     */
    public function adminPanel(): Response
    {
        return $this->render('default/adminPanel.html.twig', [

        ]);
    }
}
