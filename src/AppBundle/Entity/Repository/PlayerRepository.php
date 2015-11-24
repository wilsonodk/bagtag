<?php
// src/AppBundle/Entity/Repository/PlayerRepository.php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PlayerRepository
 */
class PlayerRepository extends EntityRepository
{
    /**
     * findAllOrderedByName
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function findAllOrderedByName()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }

    /**
     * findAllOrderedByRank
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function findAllOrderedByRank()
    {
        return $this->findBy(array(), array('rank' => 'ASC'));
    }

    /**
     * findByName
     *
     * @return Player
     */
    public function findByName($name) {
        return $this->findBy(array('name' => $name));
    }
}
