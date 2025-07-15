<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Recipe as RecipeEntity;

class Recipe extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $recipes = [
            [
                'title' => 'Spaghetti Carbonara',
                'slug' => 'spaghetti-carbonara',
                'content' => 'Des pâtes crémeuses avec du jaune d’œuf, du parmesan, du poivre et des lardons.',
                'duration' => 25,
            ],
            [
                'title' => 'Pizza Margherita',
                'slug' => 'pizza-margherita',
                'content' => 'Une pizza classique avec sauce tomate, mozzarella et basilic frais.',
                'duration' => 30,
            ],
            [
                'title' => 'Couscous Tunisien',
                'slug' => 'couscous-tunisien',
                'content' => 'Semoule cuite à la vapeur avec des légumes, pois chiches, et viande ou poisson.',
                'duration' => 90,
            ],
            [
                'title' => 'Tajine de Poulet au citron',
                'slug' => 'tajine-poulet-citron',
                'content' => 'Un tajine marocain aux olives, citron confit et épices.',
                'duration' => 75,
            ],
            [
                'title' => 'Paella Valencienne',
                'slug' => 'paella-valencienne',
                'content' => 'Plat espagnol avec riz, poulet, lapin, haricots verts et safran.',
                'duration' => 60,
            ],
        ];
        foreach ($recipes as $data) {
            $recipe = new RecipeEntity();
            $recipe->setTitle($data['title'])
                   ->setSlug($data['slug'])
                   ->setContent($data['content'])
                   ->setCreatedAt(new \DateTimeImmutable())
                   ->setUpdatedAt(new \DateTimeImmutable())
                   ->setDuration($data['duration']);

            $manager->persist($recipe);
        }
        $manager->flush();
        }   
        }

        

