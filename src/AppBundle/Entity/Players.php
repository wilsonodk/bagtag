<?php
// src/AppBundle/Entity/Players.php
namespace AppBundle\Entity;

/**
 * Players
 *
 * Simple, non-persisted entity to enable bulk edit of player ranks
 */
class Players
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $players;

    /* Constructor */
    public function __construct()
    {
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayers()
    {
        return $this->players;
    }
}
