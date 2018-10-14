<?php

namespace App\Controller\Rest;

use App\Entity\Article;
use App\Repository\Interfaces\ArticleRepositoryInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ArticleController extends FOSRestController
{
    private $articleRepository;
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Creates an Article resource
     * @Rest\Post("/articles")
     * @param Request $request
     * @return object
    */
    public function postArticle(Request $request) : object
    {
//        $encoders = array(new XmlEncoder(), new JsonEncoder());
//        $normalizers = array(new ObjectNormalizer());
//
//        $serializer = new Serializer($normalizers, $encoders);

        $article = new Article();
        $article->setTitle($request->get('title'));
        $article->setBody($request->get('body'));
        $this->articleRepository->save($article);

        return View::create($article, Response::HTTP_CREATED);


        $jsonContent = $serializer->serialize($article, 'json');
        return new Response($jsonContent);

        return $this->json($article);

        dd($article);

        return View::create($article, Response::HTTP_CREATED);
    }

    /**
     * Retrieves an Article resource
     * @Rest\Get("/articles/{articleId}")
     * @param $articleId
     * @return View
     */
    public function getArticle(int $articleId): View
    {
        $article = $this->articleRepository->findById($articleId);
        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($article, Response::HTTP_OK);
    }

    /**
     * Retrieves a collection of Article resource
     * @Rest\Get("/articles")
     */
    public function getArticles(): View
    {
        $articles = $this->articleRepository->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of article object
        return View::create($articles, Response::HTTP_OK);
    }

    /**
     * Removes the Article resource
     * @Rest\Delete("/articles/{articleId}")
     * @param $articleId
     * @return View
     */
    public function deleteArticle(int $articleId): View
    {
        $article = $this->articleRepository->findById($articleId);
        if ($article) {
            $this->articleRepository->delete($article);
        }
        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return View::create([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Replaces Article resource
     * @Rest\Put("/articles/{articleId}")
     * @param $articleId
     * @param $request
     * @return View
     */
    public function putArticle(int $articleId, Request $request): View
    {
        $article = $this->articleRepository->findById($articleId);
        if ($article) {
            $article->setTitle($request->get('title'));
            $article->setBody($request->get('body'));
            $this->articleRepository->save($article);
        }
        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return View::create($article, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/article", name="article")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ArticleController.php',
        ]);
    }
}
