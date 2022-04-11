<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements
    DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i = 0;$i<20;$i++) {
            $product = new Product();
            $product->setName('product '.$i);
            $product->setSlug('product-'.$i);
            $product->setPrice(mt_rand(10,100));
            $time = new \DateTime();

            $product->setPublishedAt($time);
            $product->setCategory(
            $this->getReference(
                CategoryFixtures::CATEGORY_REFERENCE)
        );
$manager->persist($product);
}
        $manager->flush();
    }
    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
