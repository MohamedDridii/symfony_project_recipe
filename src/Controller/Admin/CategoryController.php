<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;



#[Route('/admin/category',name:'admin.category.')]
final class CategoryController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $listCategory=$categoryRepository->findAll();
        return $this->render('admin/category/index.html.twig', [
            'categories' => $listCategory,
        ]);
    }

    #[Route('/create',name:'create')]
    public function create(Request $request,EntityManagerInterface $em): Response
    {
        $category=new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $category->setCreatedAt(new DateTimeImmutable());
            $category->setUpdateAt(new DateTimeImmutable());
            $em->persist($category);
            $em->flush();
            $this->addFlash('success','la category a été cree avec sucess ');
            return $this->redirectToRoute('admin.category.index');
        }
        return $this->render('admin/category/create.html.twig',[
            'form'=> $form
        ]);
    }

    #[Route('/{id}/edit',name:'edit')]
    public function edit (Category $category,Request $request,EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $em->persist($category);
            $em->flush();
            $this->addFlash('sucess','la categorie a été bien modifier');
            return $this->redirectToRoute('admin.category.index');
        }

        return $this->render('admin/category/edit.html.twig',[
            'form'=>$form,
            'category'=>$category
        ]);
    }

    #[Route('/{id}/delete',name:'delete')]
    public function delete (Category $category,EntityManagerInterface $em): Response
    {
        $em->remove($category);
        $em->flush();
        $this->addFlash('success','Category deleted succesfuly');
        return $this->redirectToRoute('admin.category.index');
    }
}
