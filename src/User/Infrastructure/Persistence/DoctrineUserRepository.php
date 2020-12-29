<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Persistence;

use App\User\Domain\Model\User;
use App\User\Domain\Model\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method User find($id, $lockMode = null, $lockVersion = null)
 */
final class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($registry, User::class);
    }

    public function findById(int $id): ?User
    {
        return $this->find($id);
    }

    public function findByUsername(string $username): ?User
    {
        return $this->findOneBy(['username' => $username]);
    }

    public function save(User $user): void
    {
        // @see we do not have to $entityManager->flush($user) because we used transactional middleware
        $this->entityManager->persist($user);
    }
}
