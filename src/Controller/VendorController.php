<?php

namespace App\Controller;

use App\Entity\Vendor;
use App\Form\ProductSearchType;
use App\Form\ProductSearchVendorsType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class VendorController extends AbstractController
{
    /**
     * @Route("/vendor/{vendor}", name="vendor")
     */
    public function view(ProductRepository  $productRepository, Vendor $vendor, Request $request): Response
    {
        $form = $this->createForm(ProductSearchVendorsType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();


            $qb = $productRepository->createQueryBuilder('p')
                ->innerJoin('p.category','c');

            if (count($data['price_range'])>0) {
                foreach ($data['price_range'] as $key => $range){
                    $values = explode('-', $range);
                    $qb->orWhere("p.price BETWEEN :start$key AND :end$key")
                        ->setParameter("start$key", $values[0])
                        ->setParameter("end$key", $values[1]);
                }
            }

            if ($data['categories']->count()>0) {
                $qb->andWhere('p.category in (:categories)')
                    ->setParameter('categories', $data['categories']);
            }

            $products = $qb->getQuery()->getResult();
        } else {
            $products = $vendor->getProducts();
        }

        return $this->render('default/vendor.html.twig',['products'=>$products, 'vendor'=>$vendor, 'form' => $form->createView()]);
    }


}
