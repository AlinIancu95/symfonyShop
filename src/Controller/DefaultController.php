<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Vendor;
use App\Entity\Product;
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
    public function index(CategoryRepository $categoryRepository, VendorRepository $vendorRepository, ProductRepository $productRepository): Response
    {
        return $this->render('default/index.html.twig',
            ['categories'=>$categoryRepository->findAll(),
            'vendors'=>$vendorRepository->findAll(),
                'products'=>$productRepository->findBy([], ['id'=>'DESC'],4),
                'productsLaptop'=>$productRepository->findBy(['category'=>2], ['id'=>'DESC'], 4),
                'productsTV'=>$productRepository->findBy(['category'=>1], ['id'=>'DESC'], 4),
                'productsPhone'=>$productRepository->findBy(['category'=>3], ['id'=>'DESC'], 4)
            ]);
    }

    /**
     * @Route("/category/{category}", name="category")
     */
    public function category(Category $category, CategoryRepository $categoryRepository, VendorRepository $vendorRepository): Response
    {
        return $this->render('default/category.html.twig',
            ['category'=>$category, 'categories'=>$categoryRepository->findAll(),
                'vendors'=>$vendorRepository->findAll()
            ]);
    }

    /**
     * @Route("/vendor/{vendor}", name="vendor")
     */
    public function vendor(Vendor $vendor, VendorRepository $vendorRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('default/vendor.html.twig',
            [   'vendor'=>$vendor,
                'vendors'=>$vendorRepository->findAll(),
                'categories'=> $categoryRepository->findAll()
            ]);
    }

    /**
     * @Route("/header/{header}", name="header")
     */
    public function header(CategoryRepository $categoryRepository): Response
    {
        return $this->render('default/parts/header.html.twig', ['categories'=>$categoryRepository->findAll()]);
    }

    /**
     * @Route("/product/{product}", name="product")
     */
    public function product(Product $product, CategoryRepository $categoryRepository, VendorRepository $vendorRepository): Response
    {
        return $this->render('default/product.html.twig',
            [   'categories'=>$categoryRepository->findAll(),
                'vendors'=>$vendorRepository->findAll(),
                    'product'=>$product
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
