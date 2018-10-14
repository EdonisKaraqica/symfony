<?php
/**
 * Created by PhpStorm.
 * User: Refresh
 * Date: 10/13/2018
 * Time: 3:15 PM
 */

namespace App\Repository\Interfaces;


use App\Entity\Article;

interface ArticleRepositoryInterface
{
    /**
     * @param int $articleId
     * @return Article
     */
    public function findById(int $articleId): ?Article;

    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param Article $article
     */
    public function save(Article $article): void;

    /**
     * @param Article $article
     */
    public function delete(Article $article): void;
}