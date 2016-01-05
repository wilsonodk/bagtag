<?php
// src/AppBundle/Entity/Player.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Player
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PlayerRepository")
 */
class Player
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=128, unique=true, nullable=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Store")
     * \Doctrine\ORM\Mapping\JoinTable(name="player_stores",
     *      joinColumns={@JoinColumn(name="player_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="store_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $stores;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\Type("integer")
     */
    private $rank;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer")
     */
    private $previous;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /* Constructor */
    public function __construct()
    {
        $this->stores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->active = true;
    }

    /**
     * Return a string representation of a Player
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Player
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add store
     *
     * @param \AppBundle\Entity\Store $store
     *
     * @return Player
     */
    public function addStore($store)
    {
        $this->stores[] = $store;

        return $this;
    }

    /**
     * Remove store
     *
     * @param \AppBundle\Entity\Store $store
     *
     * @return Player
     */
    public function removeStore($store)
    {
        $this->stores->removeElement($store);

        return $this;
    }

    /**
     * Set stores
     *
     * @param \Doctrine\Common\Collections\Collection
     *
     * @return Player
     */
    public function setStores($stores)
    {
        $this->$stores = $stores;

        return $this;
    }

    /**
     * Get stores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStores()
    {
        return $this->stores;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     *
     * @return Player
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set previous
     *
     * @param integer $previous
     *
     * @return Player
     */
    public function setPrevious($previous)
    {
        $this->previous = $previous;

        return $this;
    }

    /**
     * Get previous
     *
     * @return integer
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * Set active
     *
     * @param integer $active
     *
     * @return Player
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }
}
