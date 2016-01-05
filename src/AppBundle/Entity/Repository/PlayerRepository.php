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
     * getActiveState
     *
     * @return array
     */
    private function getActiveState($state)
    {
        if ($state === 'all') {
            $state = array();
        } else if ($state === 'disabled') {
            $state = array('active' => false);
        } else {
            $state = array('active' => true);
        }

        return $state;
    }

    /**
     * findAllOrderedByName
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function findAllOrderedByName($state = 'active')
    {
        return $this->findBy(
            $this->getActiveState($state),
            array('name' => 'ASC')
        );
    }

    /**
     * findAllOrderedByRank
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function findAllOrderedByRank($state = 'active')
    {
        return $this->findBy(
            $this->getActiveState($state),
            array('rank' => 'ASC')
        );
    }

    /**
     * findByName
     *
     * @return Player
     */
    public function findByName($name)
    {
        return $this->findBy(array('name' => $name));
    }
}
