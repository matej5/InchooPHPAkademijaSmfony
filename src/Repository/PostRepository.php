<?php


namespace App\Repository;


use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function getAllInLastWeek()
    {
        return $this->createQueryBuilder('p')
            ->where('p.createdAt <= :endWeek')
            ->setParameter('endWeek', new \DateTime('now +7 day'))
            ->setMaxResults(100)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }


    public function getByTag($tag)
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('App\Entity\Tag','b','WITH','a.id = b.post')
            ->where('b.content = :tag')
            ->setParameter('tag', $tag)
            ->setMaxResults(100)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
