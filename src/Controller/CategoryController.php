<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\ProductSearchType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{category}", name="category")
     */
    public function view(ProductRepository  $productRepository, Category $category, Request $request): Response
    {
        $form = $this->createForm(ProductSearchType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();


            $qb = $productRepository->createQueryBuilder('p')
                ->innerJoin('p.vendor','v');


            if (count($data['pret'])>0) {
                foreach ($data['pret'] as $key => $range){
                    $values = explode('-', $range);
                    $qb->orWhere("p.price BETWEEN :start$key AND :end$key")
                        ->setParameter("start$key", $values[0])
                        ->setParameter("end$key", $values[1]);
                }
            }


            if ($data['vendors']->count()>0) {
                $qb->andWhere('p.vendor in (:vendors)')
                    ->setParameter('vendors', $data['vendors']);
            }

            $products = $qb->getQuery()->getResult();
        } else {
            $products = $category->getProducts();
        }

        return $this->render('default/category.html.twig',['products'=>$products, 'category'=>$category, 'form' => $form->createView()]);
    }

}
