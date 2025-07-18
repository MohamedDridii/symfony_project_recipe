<?php

namespace App\Controller\API;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipeController extends AbstractController
{
    #[Route('/api/recettes', name: 'api', methods:['GET'])]
    public function index(RecipeRepository $repo)
    {
        $recettes=$repo->findAll();
        return $this->json($recettes,200,[],[
            'groups'=>['recipes.index']
        ]);//cela signifie envoyer dans l'api tous les attribut dans l'antite qui ont un tag de recipes.index 
    }

    #[Route('/api/recettes/{id}', name: 'api1', methods:['GET'])]
    public function show(Recipe $recipe)
    {
        return $this->json($recipe,200,[],[
            'groups'=>['recipes.index','recipes.show']
        ]);//signifie que l'api contiendra la recette passe en parametre avec les attribut tage en recipes.index et recipes.show 
    }
}
