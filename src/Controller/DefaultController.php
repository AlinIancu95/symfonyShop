<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Vendor;
use App\Service\CartService;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\VendorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(CartService $cartService, CategoryRepository $categoryRepository, VendorRepository $vendorRepository, ProductRepository $productRepository): Response
    {
        return $this->render('default/index.html.twig',
            ['categories'=>$categoryRepository->findAll(),
            'vendors'=>$vendorRepository->findAll(),
                'products'=>$productRepository->findBy([], ['id'=>'DESC'],4),
                'productsLaptop'=>$productRepository->findBy(['category'=>2], ['id'=>'DESC'], 4),
                'productsTV'=>$productRepository->findBy(['category'=>1], ['id'=>'DESC'], 4),
                'productsPhone'=>$productRepository->findBy(['category'=>3], ['id'=>'DESC'], 4),
                'cart' => $cartService->getCart()
            ]);
    }

    /**
     * @Route("/category/{category}", name="category")
     */
    public function category(CartService $cartService, Category $category, CategoryRepository $categoryRepository, VendorRepository $vendorRepository): Response
    {
        return $this->render('default/category.html.twig',
            ['category'=>$category, 'categories'=>$categoryRepository->findAll(),
                'vendors'=>$vendorRepository->findAll(),
                'cart' => $cartService->getCart()
            ]);
    }

    /**
     * @Route("/vendor/{vendor}", name="vendor")
     */
    public function vendor(CartService $cartService, Vendor $vendor, VendorRepository $vendorRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('default/vendor.html.twig',
            [   'vendor'=>$vendor,
                'vendors'=>$vendorRepository->findAll(),
                'categories'=> $categoryRepository->findAll(),
                'cart' => $cartService->getCart()
            ]);
    }

    /**
     * @Route("/header/{header}", name="header")
     */
    public function header(CategoryRepository $categoryRepository, CartService $cartService): Response
    {
        return $this->render('default/parts/header.html.twig', [
            'categories'=>$categoryRepository->findAll(),
            'cart' => $cartService->getCart()
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
