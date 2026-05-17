<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello', name: 'app_hello')]
    public function index(): Response
    {
        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
            'message' => 'Welcome to Symfony 6.4!'
        ]);
    }

    #[Route('/hello/{name}', name: 'app_hello_name')]
    public function helloName(string $name): Response
    {
        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
            'message' => "Hello $name! Welcome to Symfony!"
        ]);
    }
}