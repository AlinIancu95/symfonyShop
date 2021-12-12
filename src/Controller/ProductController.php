<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Product;
use App\Form\VendorProductType;
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
    public function product(Product $product): Response
    {
        return $this->render('product/index.html.twig',
            ['product'=>$product,
            ]);
    }

    /**
     *
     * @IsGranted("ROLE_VENDOR")
     * @Route("vendorProduct/create", name="vendorProduct_form")
     */
    public function create(Request $request): Response
    {
        $product = new Product();
        $product->setType('product');
        $vendorProductForm = $this->createForm(VendorProductType::class, $product);

        $vendorProductForm->handleRequest($request);
        if ($vendorProductForm->isSubmitted() && $vendorProductForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $imageFiles = $vendorProductForm->get('productImages')->getData();
            foreach ($imageFiles as $imageFile){
                $imageFile->move('/var/www/html/national02/alin/symfonyShop/public/images', $imageFile->getClientOriginalName());
                $productImage = new Image();
                $productImage->setFile($imageFile->getClientOriginalName());
                $productImage->setProduct($product);
                $em->persist($productImage);
            }
            $em->persist($product);
            $em->flush();

        }
        return $this->render('product/vendorProduct.html.twig', [
            'vendorProductForm' => $vendorProductForm->createView()
        ]);

    }

    /**
     * @IsGranted("ROLE_VENDOR")
     * @Route("vendorProduct/edit/{product}", name="vendorProduct_edit")
     */
    public function edit(Product $product,Request $request): Response
    {
        $vendorProductForm = $this->createForm(VendorProductType::class, $product);

        $vendorProductForm->handleRequest($request);
        if ($vendorProductForm->isSubmitted() && $vendorProductForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $imageFiles = $vendorProductForm->get('productImages')->getData();
            foreach ($imageFiles as $imageFile){
                $imageFile->move('/var/www/html/national02/alin/symfonyShop/public/images', $imageFile->getClientOriginalName());
                $productImage = new Image();
                $productImage->setFile($imageFile->getClientOriginalName());
                $productImage->setProduct($product);
                $em->persist($productImage);
            }
            $em->persist($product);
            $em->flush();

        }
        return $this->render('product/vendorProduct.html.twig', [
            'vendorProductForm' => $vendorProductForm->createView(),
        ]);

    }
}
