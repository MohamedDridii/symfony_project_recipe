<?php

namespace App\DataFixtures;

use App\Entity\Category as CategoryEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Bundle\FixturesBundle\Attribute\AsFixture;

class Category extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $categories = [
            [
                'name' => 'Italien',
                'slug' => 'italien',
                'content' => 'Recettes typiques italiennes comme les pizzas, pâtes, risottos...',
            ],
            [
                'name' => 'Tunisien',
                'slug' => 'tunisien',
                'content' => 'Plats traditionnels tunisiens à base de semoule, harissa, légumes, etc.',
            ],
            [
                'name' => 'Espagnol',
                'slug' => 'espagnol',
                'content' => 'Recettes espagnoles populaires comme la paella, tapas, tortilla.',
            ],
            [
                'name' => 'Marocain',
                'slug' => 'marocain',
                'content' => 'Cuisine marocaine riche en épices : tajines, couscous, pastillas...',
            ],
            [
                'name' => 'Français',
                'slug' => 'francais',
                'content' => 'Gastronomie française : quiches, gratins, croissants et plus.',
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
