<?php

namespace App\tests;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductPostTest extends TestCase
{
	public function testSetPriceInteger(): void
	{
		$product = new Product();
		$product->setPrice(50);
		$this->assertTrue($product->getPrice() == 50);
	}
	public function testSetPriceString(): void
	{
		$product = new Product();
		$exceptionTriggered = false;
		try {
			$product->setPrice('something');
		}catch (\TypeError $error){
			$exceptionTriggered = true;
		}
		$this->assertTrue($exceptionTriggered );
	}
}