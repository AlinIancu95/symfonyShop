<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\VendorProductType;
use App\Repository\CategoryRepository;
use App\Repository\VendorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ProductController extends AbstractController
{
    /**
     *
     * @Route("/product/{product}", name="product")
     */
    public function product(Product $product, CategoryRepository $categoryRepository, VendorRepository $vendorRepository): Response
    {
        return $this->render('product/index.html.twig',
            [   'categories'=>$categoryRepository->findAll(),
                'vendors'=>$vendorRepository->findAll(),
                'product'=>$product
            ]);
    }

    /**
     *
     * @IsGranted("ROLE_VENDOR")
     * @Route("vendorProduct/create", name="vendorProduct_form")
     */
    public function create(Request $request, VendorRepository $vendorRepository, CategoryRepository $categoryRepository): Response
    {
        $product = new Product();
        $product->setType('product');
        $vendorProductForm = $this->createForm(VendorProductType::class, $product);

        $vendorProductForm->handleRequest($request);
        if ($vendorProductForm->isSubmitted() && $vendorProductForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

        }
        return $this->render('product/vendorProduct.html.twig', [
            'vendorProductForm' => $vendorProductForm->createView(),
            'vendors'=>$vendorRepository->findAll(),
            'categories'=> $categoryRepository->findAll()
        ]);

    }

    /**
     * @IsGranted("ROLE_VENDOR")
     * @Route("vendorProduct/edit/{product}", name="vendorProduct_edit")
     */
    public function edit(Product $product,Request $request, VendorRepository $vendorRepository, CategoryRepository $categoryRepository): Response
    {
        $vendorProductForm = $this->createForm(VendorProductType::class, $product);

        $vendorProductForm->handleRequest($request);
        if ($vendorProductForm->isSubmitted() && $vendorProductForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

        }
        return $this->render('product/vendorProduct.html.twig', [
            'vendorProductForm' => $vendorProductForm->createView(),
            'vendors'=>$vendorRepository->findAll(),
            'categories'=> $categoryRepository->findAll()
        ]);

    }
}
