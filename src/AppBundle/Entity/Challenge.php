<?php
// src/AppBundle/Entity/Challenge.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Challenge
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ChallengeRepository")
 */
class Challenge
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Player")
     * \Doctrine\ORM\Mapping\JoinTable(name="challenge_players",
     *      joinColumns={@JoinColumn(name="challenge_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="player_id", referencedColumnName="id", unique=true)}
     *      )
     * @Assert\Count(min = 2, minMessage = "You must select at least two players")
     */
    private $players;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     * @Assert\DateTime()
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hosted", type="datetime", nullable=false)
     * @Assert\DateTime()
     */
    private $hosted;

    public function __construct()
    {
        $this->name    = 'Dogfight';
        $this->active  = true;
        $this->hosted  = new \DateTime();
        $this->created = new \DateTime();
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();

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
     * @return Challenge
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
     * Add player
     *
     * @param \AppBundle\Entity\Player $player
     *
     * @return Challenge
     */
    public function addPlayer($player)
    {
        $this->players[] = $player;

        return $this;
    }

    /**
     * Remove player
     *
     * @param \AppBundle\Entity\Player $player
     *
     * @return Challenge
     */
    public function removePlayer($player)
    {
        $this->player->removeElement($player);

        return $this;
    }

    /**
     * Set players
     *
     * @param \Doctrine\Common\Collections\Collection
     *
     * @return Challenge
     */
    public function setPlayers($players)
    {
        $this->$players = $players;

        return $this;
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Challenge
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Challenge
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set hosted
     *
     * @param \DateTime $hosted
     *
     * @return Challenge
     */
    public function setHosted($hosted)
    {
        $this->hosted = $hosted;

        return $this;
    }

    /**
     * Get hosted
     *
     * @return \DateTime
     */
    public function getHosted()
    {
        return $this->hosted;
    }
}
