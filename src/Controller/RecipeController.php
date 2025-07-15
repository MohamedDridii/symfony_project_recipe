<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'app_recipe')]
    public function index(): Response
    {
        return $this->render('recipe/recipe.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }
    #[Route('/recipe/{id}/edit', name: 'recipe.edit')]
    public function edit(Recipe $recipe,Request $request,EntityManagerInterface $em ): Response// le framework symfony connait que dans le route tu cherche sur l'id donc elle select l'entite avec l'id passer au parametre(cette methode n'est valable qu'avec le champ id)
    {
        $form=$this->createForm(RecipeType::class,$recipe);//j'ai cree un formulaire avec les donner de l'entite recipe passer en parametre dans la fonction
        
        $form->handleRequest($request);//ca modifie automatiquement les valeurs ajouter au formulaie dans l'entite puisque chaque champ du formulaire et lie a une entite lors de la creation du formulaire on peut voir les detail dans RecipeType dans la methode configureOptions
        
        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();//maintenant on va modifier lesdonner soummit par le formulfaire dans la base de donner 
            $this->addFlash('message','la recette a bien été modifiée ');
            return $this->redirectToRoute('app_recipe');//redirection vers la page avec le nom de route app_route
        }
        
        return $this->render('recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form'   => $form,
        ]);
    }
    #[Route('/recipe/create',name:'recipes.create')]
    public function create( Request $request,EntityManagerInterface $em,):Response{// on n'avait pas ajouter recipe au parametre de cette fonction car on vas cree et persister la recette or dans la fct precedante on a deja la recette et on veulent la modifier(l'utilisation de l'entite au parametre dans la fonction precedante etait une autre methode explique deja )
        $recipe= new Recipe();
        $form = $this->createForm(RecipeType::class,$recipe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $recipe->setCreatedat(new DateTimeImmutable());
            $recipe->setUpdatedAt(new DateTimeImmutable());
            $em->persist($recipe);
            $em->flush();
            $this->addFlash('success','la recette a bien été crée');
            return $this->redirectToRoute('app_recipe');
        }
        return $this->render('recipe/create.html.twig',[//ici on a passer seulement le formulaire au view car on n'affichera rien 
            'form'=>$form
        ]);
    }






}
