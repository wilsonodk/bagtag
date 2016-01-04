<?php
// src/AppBundle/Entity/Repository/ChallengeRepository.php
namespace AppBundle\Entity\Repository;

use \Doctrine\ORM\EntityRepository;

/**
 * ChallengeRepository
 */
class ChallengeRepository extends EntityRepository
{
    /**
     * findAllActiveOrderedByHostedDate
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function findAllActiveOrderedByHostedDate()
    {
        return $this->findBy(
            array('active' => 1),
            array('hosted' => 'ASC')
        );
    }
}
