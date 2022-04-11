<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Product;


class LuckyController extends AbstractController
{
	
	private $em;

    public function __construct(ManagerRegistry $registry)
    {
        $this->em = $registry;
    }
	
	public function number($locales, $defaultLocale)
	{
       // $locale = $this->getParameter('locale');
       // echo $locale;
		$product = $this->em->getRepository(Product::class);
		$products = $product->findAll();
		
		foreach($products as $pd) {
			echo $pd->getCategory()->getName();

			
}
		
		$number = random_int(0, 100);
		return new Response(
		'<html><body>Lucky number: '.$number.'</body></html>'
		);
	}
}