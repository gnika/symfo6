<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture implements
    DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i = 0;$i<20;$i++) {
            $post = new Post();
            $post->setName('post '.$i);
            $post->setSlug('post-'.$i);
            $post->setPrice(mt_rand(10,100));
            $time = new \DateTime();

            $post->setPublishedAt($time);
            $post->setCategory(
            $this->getReference(
                CategoryFixtures::CATEGORY_REFERENCE)
        );
$manager->persist($post);
}
        $manager->flush();
    }
    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
