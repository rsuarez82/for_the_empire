<?php

namespace App\Repository;

use App\Entity\Courses;
use App\Entity\CoursesHistory;
use App\Entity\Participants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
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

    public function findCoursesHistoryByCourseId(int $courseId): ?array
    {
        $entityManager = $this->getEntityManager();
        $resultSetMapping = new ResultSetMapping();

        $query = $entityManager->createNativeQuery(
            'SELECT p.id, p.firstname, p.lastname, p.email, p.unit '
            . 'FROM participants AS p '
            . 'JOIN courses_history AS ch ON p.id = ch.participant_id '
            . 'JOIN courses AS c ON c.id = ch.course_id '
            . 'WHERE ch.course_id = :courseId',
            $resultSetMapping
        );
        $query->setParameter('courseId', $courseId);

        return $query->getResult();
    }

    /**
     * @param int $participantId
     * @return array|null
     */
    public function findCoursesHistoryByParticipantId(int $participantId): ?array
    {
        $entityManager = $this->getEntityManager();
        $resultSetMapping = new ResultSetMapping();

        $query = $entityManager->createNativeQuery(
                'SELECT c.id, c.title, c.course_date, c.content, c.description, c.course_leader, c.free_slots '
                . 'FROM courses AS c '
                . 'JOIN courses_history AS ch ON c.id = ch.course_id '
                . 'JOIN participants AS p ON p.id = ch.participant_id '
                . 'WHERE ch.participant_id = :participantId',
            $resultSetMapping
        );
        $query->setParameter('participantId', $participantId);

        return $query->getResult();
    }
}
