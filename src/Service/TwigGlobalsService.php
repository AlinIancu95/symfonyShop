<?php

namespace App\Service;

use App\Repository\CategoryRepository;
use App\Repository\VendorRepository;
use App\Service\CartService;

class TwigGlobalsService
{
    /** @var CategoryRepository */
    private $categoryRepository;

    /** @var VendorRepository */
    private $vendorRepository;

    /** @var \App\Service\CartService */
    private $cartService;

    /**
     * TwigGlobalsService constructor.
     * @param CategoryRepository $categoryRepository
     * @param VendorRepository $vendorRepository
     * @param \App\Service\CartService $cartService
     */
    public function __construct(CategoryRepository $categoryRepository, VendorRepository $vendorRepository, \App\Service\CartService $cartService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->vendorRepository = $vendorRepository;
        $this->cartService = $cartService;
    }


    public function getMenuCategories()
    {
        return $this->categoryRepository->findAll();
    }

    public function getMenuVendors()
    {
        return $this->vendorRepository->findAll();
    }

    public function getMenuCart()
    {
        return $this->cartService->getCart();
    }
}