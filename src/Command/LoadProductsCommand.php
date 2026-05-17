<?php

namespace App\Command;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadProductsCommand extends Command
{
    protected static $defaultName = 'app:load-products';
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Load sample products into database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $products = [
            ['name' => 'Laptop', 'price' => 999.99, 'description' => 'High-performance laptop'],
            ['name' => 'Mouse', 'price' => 29.99, 'description' => 'Wireless mouse'],
            ['name' => 'Keyboard', 'price' => 79.99, 'description' => 'Mechanical keyboard'],
            ['name' => 'Monitor', 'price' => 299.99, 'description' => '4K Monitor'],
            ['name' => 'Headphones', 'price' => 159.99, 'description' => 'Noise-cancelling headphones'],
        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setPrice($productData['price']);
            $product->setDescription($productData['description']);
            
            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();
        
        $output->writeln('✓ ' . count($products) . ' products loaded successfully!');
        
        return Command::SUCCESS;
    }
}