<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
    * @return User[]
    */
    public function findIfExist($nick): array
    {
      $entityManager = $this->getEntityManager();

      $query = $entityManager->createQuery(
        'SELECT n.Nick, n.Password, n.Permission from App\Entity\User n
        WHERE  n.Nick = :nick ORDER BY n.Nick ASC'
        )->setParameter('nick',$nick);
        return $query->getResult();
    }

    public function findAllWorkers(): array {
      $entityManager = $this->getEntityManager();

      $query = $entityManager->createQuery(
        'SELECT n.id, n.Nick, n.email from App\Entity\User n WHERE
        n.Permission = :permission ORDER BY n.Nick ASC
        '
      )->setParameter('permission', 2);
      return $query->getResult();
    }
    public function findAllUsers(): array {
      $entityManager = $this->getEntityManager();

      $query = $entityManager->createQuery(
        'SELECT n.id, n.Nick, n.email from App\Entity\User n WHERE
        n.Permission = :permission ORDER BY n.Nick ASC
        '
      )->setParameter('permission', 1);
      return $query->getResult();
    }


    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
