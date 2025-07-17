<?php

namespace App\DataFixtures;

use App\Entity\Category as CategoryEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class Category extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            [
                'name' => 'Entrée',
                'slug' => 'entree',
                'content' => 'Catégorie pour les entrées froides ou chaudes, comme les salades, soupes, bricks, etc.',
            ],
            [
                'name' => 'Plat principal',
                'slug' => 'plat-principal',
                'content' => 'Catégorie pour les plats principaux, comme les tajines, couscous, gratins, etc.',
            ],
            [
                'name' => 'Dessert',
                'slug' => 'dessert',
                'content' => 'Catégorie pour les desserts : pâtisseries, glaces, fruits, etc.',
            ],
        ];

        foreach ($categories as $data) {
            $category = new CategoryEntity();
            $category->setName($data['name'])
                     ->setSlug($data['slug'])
                     ->setContent($data['content'])
                     ->setCreatedAt(new \DateTimeImmutable())
                     ->setUpdateAt(new \DateTimeImmutable());

            $manager->persist($category);
        }

        $manager->flush();
    }

}
