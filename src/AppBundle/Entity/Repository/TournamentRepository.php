<?php
// src/AppBundle/Entity/Repository/TournamentRepository.php
namespace AppBundle\Entity\Repository;

use \Doctrine\ORM\EntityRepository;

/**
 * TournamentRepository
 */
class TournamentRepository extends EntityRepository
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
