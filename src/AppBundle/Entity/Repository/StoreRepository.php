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
    public function findAllOrderedByName()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }
}
