<?php
// src/AppBundle/Entity/Repository/StoreRepository.php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * StoreRepository
 */
class StoreRepository extends EntityRepository
{
    /**
     * findAllOrderedByName
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function findAllOrderedByName($state)
    {
        if ($state === 'all') {
            $state = array();
        } else if ($state === 'disabled') {
            $state = array('active' => false);
        } else {
            $state = array('active' => true);
        }

        return $this->findBy($state, array('name' => 'ASC'));
    }
}
