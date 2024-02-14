<?php

namespace App\Repository;

use App\Entity\Courses;
use App\Entity\CoursesHistory;
use App\Entity\Participants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CoursesHistory>
 *
 * @method CoursesHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoursesHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoursesHistory[]    findAll()
 * @method CoursesHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursesHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoursesHistory::class);
    }

    public function findCoursesHistoryByCourseId(int $courseId): ?Courses
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT ch, c
            FROM App\Entity\CoursesHistory ch
            INNER JOIN ch.courseId c
            WHERE c.id = :id'
        )->setParameter('id', $courseId);

        return $query->getOneOrNullResult();
    }
    public function findCoursesHistoryByParticipantId(int $participantId): ?Participants
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT ch, p
            FROM App\Entity\CoursesHistory ch
            INNER JOIN ch.participant p
            WHERE p.id = :id'
        )->setParameter('id', $participantId);

        return $query->getOneOrNullResult();
    }
}
