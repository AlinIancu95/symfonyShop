<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use App\Repository\CategoryRepository;
use App\Repository\VendorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(CartService $cartService, CategoryRepository $categoryRepository, VendorRepository $vendorRepository): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getCart(),
            'categories'=>$categoryRepository->findAll(),
            'vendors'=>$vendorRepository->findAll()
        ]);
    }

    /**
     * @Route("/cart/{product}/add", name="cart_add")
     */
    public function add(Product $product, CartService $cartService): Response
    {
        $cartService->add($product);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/{product}/update", name="cart_item_update")
     */
    public function update(Product $product, \Symfony\Component\HttpFoundation\Request $request, CartService $cartService): Response
    {
        $cartService->update($product, $request->request->get('quantity'));
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/{product}/delete", name="cart_item_delete")
     */
    public function delete(Product $product, CartService $cartService): Response
    {
        $cartService->delete($product);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/empty", name="cart_empty")
     */
    public function empty(CartService $cartService): Response
    {
        $cartService->empty();
        return $this->redirectToRoute('cart');
    }


}
