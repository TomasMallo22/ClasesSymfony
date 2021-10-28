<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
//agrego la clase de la entidad post

use App\Entity\Post;

use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use App\Repository\PostRepository;

class BlogController extends AbstractController
{

    private $repoCat;
    private $repoTag;

    public function __construct(TagRepository $rt, CategoryRepository $rc){
        $this->repoCat = $rc;
        $this->repoTag = $rt;
    }
    
    #[Route('/blog', name: 'blog')]

    public function index(Request $request, PostRepository $repoPost): Response
    {
        $idCategoria = $request->query->get('cat');
        if(empty($idCategoria)){
            $idCategoria = 0;
        }
        $categoria = $this->repoCat->find($idCategoria);

        $idEtiqueta = $request->query->get('tag');
        if(empty($idEtiqueta)){
            $idEtiqueta = 0;
        }
        $etiqueta = $this->repoTag->find($idEtiqueta);

        $posts = $repoPost->findByFilter($categoria, $etiqueta);

        return $this->render('blog/blog.html.twig', [
            'controller_name' => 'BlogController',
            'category' => $this->repoCat->findAll(),
            'tags' =>  $this->repoTag->findAll(),
            'posts' => $posts,
            'filter' => ['cat'=>$idCategoria, 'tag'=>$idEtiqueta]
        ]);
    }

    #[Route('/blog/{id}', name: 'blog-detail')]

    public function detail(Request $request, Post $post): Response
    {
        return $this->render('blog/detail.html.twig',[
            'post' => $post,
            'category' => $this->repoCat->findAll(),
            'tags' =>  $this->repoTag->findAll(),

        ]);
    }

}
