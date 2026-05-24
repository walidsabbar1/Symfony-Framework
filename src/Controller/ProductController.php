<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\ProductFormType;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    #[Route('/', name: 'product_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        // Get all products from database
        $products = $entityManager->getRepository(Product::class)->findAll();
        
        return $this->render('product/list.html.twig', [
            'products' => $products
        ]);
    }
    
    #[Route('/product/{id}', name: 'product_show', requirements: ['id' => '\d+'])]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        // Get a single product by ID
        $product = $entityManager->getRepository(Product::class)->find($id);
        
        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }
        
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
    #[Route('/product/create', name: 'product_create')]
public function create(Request $request, EntityManagerInterface $entityManager): Response
{
    $product = new Product();
    $form = $this->createForm(ProductFormType::class, $product);
    
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($product);
        $entityManager->flush();
        
        $this->addFlash('success', 'Product created successfully!');
        return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
    }
    
    return $this->render('product/create.html.twig', [
        'form' => $form->createView()
    ]);
}

#[Route('/product/edit/{id}', name: 'product_edit', requirements: ['id' => '\d+'])]
public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
{
    $product = $entityManager->getRepository(Product::class)->find($id);
    
    if (!$product) {
        throw $this->createNotFoundException('Product not found');
    }
    
    $form = $this->createForm(ProductFormType::class, $product);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();
        
        $this->addFlash('success', 'Product updated successfully!');
        return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
    }
    
    return $this->render('product/edit.html.twig', [
        'form' => $form->createView(),
        'product' => $product
    ]);
}

#[Route('/product/delete/{id}', name: 'product_delete', requirements: ['id' => '\d+'])]
public function delete(int $id, EntityManagerInterface $entityManager): Response
{
    $product = $entityManager->getRepository(Product::class)->find($id);
    
    if ($product) {
        $entityManager->remove($product);
        $entityManager->flush();
        $this->addFlash('success', 'Product deleted successfully!');
    }
    
    return $this->redirectToRoute('product_list');
}
}