<?php

namespace App\Controller\API;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

final class RecipeController extends AbstractController
{
    //api pour tous les recttes 
    #[Route('/api/recettes', name: 'api', methods:['GET'])]
    public function index(RecipeRepository $repo)
    {
        $recettes=$repo->findAll();
        return $this->json($recettes,200,[],[
            'groups'=>['recipes.index']
        ]);//cela signifie envoyer dans l'api tous les attribut dans l'antite qui ont un tag de recipes.index 
    }
    //api pour une recette specifique 
    #[Route('/api/recettes/{id}', name: 'api1', methods:['GET'])]
    public function show(Recipe $recipe)
    {
        return $this->json($recipe,200,[],[
            'groups'=>['recipes.index','recipes.show']
        ]);//signifie que l'api contiendra la recette passe en parametre avec les attribut tag2 avec recipes.index et recipes.show 
    }
    //api post pour recuperer les recettes PS:il y'a une autre methode explique dans le video 19 grafikart 
    #[Route('/api/recettes', name: 'api2', methods:['POST'])]
    public function create(Request $request,SerializerInterface $serializer,EntityManagerInterface $em)
    {
        $recipe=new Recipe();
        $recipe->setCreatedat(new DateTimeImmutable());
        $recipe->setUpdatedAt(new DateTimeImmutable());
        $content=$request->getContent();
        $serializer->deserialize($content,Recipe::class,'json',[
            AbstractNormalizer::OBJECT_TO_POPULATE => $recipe,// on a cree une instance de recette et remplit les dates qui ne sont pas dans l'api et on a ajouter cette ligne pour que au lieu de cree une nouvelle instance il rempli cette instance deja cree 
            'groups'=>'recipes.create'//on vas specifier les champs avec les quels que la classe serait remplit pour interdire le remplissage des champs que je ne veux pas qu'elle soit remplit 
        ]);
        /*$em->persist($recipe);
          $em->flush()*/
         return $this->json($recipe,200,[],[
            'groups'=>['recipes.create']
        ]);
    }
    //supposon on a plusieur donner dans l'api donc il faut l'iterer comme ca 
    /*
    #[Route('/api/recettes', name: 'api_bulk_create', methods: ['POST'])]
    public function createMultiple(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em
    ): JsonResponse {
        $content = $request->getContent();

        // Désérialiser un tableau de recettes
        ///** @var Recipe[] $recipes */
        /*
        $recipes = $serializer->deserialize(
            $content,
            Recipe::class . '[]',
            'json',
            ['groups' => ['recipes.create']]
        );

        foreach ($recipes as $recipe) {
            $recipe->setCreatedAt(new \DateTimeImmutable());
            $recipe->setUpdatedAt(new \DateTimeImmutable());
            $em->persist($recipe);
        }

        $em->flush();

        return $this->json($recipes, 201, [], [
            'groups' => ['recipes.create']
        ]);
    }*/

}
