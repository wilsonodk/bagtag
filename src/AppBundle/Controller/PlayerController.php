<?php
// src/AppBundle/Controller/PlayerController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Entity\Players;
use AppBundle\Form\Type\PlayerType;
use AppBundle\Form\Type\PlayersType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PlayerController extends Controller
{
    /**
     * @Route("/players", name="players")
     * @Template("AppBundle:Player:list.html.twig")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $type = $request->query->get('type', 'active');

        $players = $this->getDoctrine()->getRepository('AppBundle:Player')->findAllOrderedByName($type);

        return array(
                'players' => $players,
                'picked_state' => $type,
            );
    }

    /**
     * @Route("/players/add", name="add_player")
     * @Template("AppBundle:Player:add.html.twig")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $player = new Player();
        $form = $this->createForm(new PlayerType(), $player);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();

            $this->addFlash('notice', 'New player added!');

            return $this->redirectToRoute('players');
        }

        return array(
                'action' => 'Create',
                'form' => $form->createView(),
            );
    }

    /**
     * @Route("/players/bulk", name="bulk_players")
     * @Template("AppBundle:Player:bulk.html.twig")
     * @Method({"GET", "POST"})
     */
    public function bulkPlayers(Request $request)
    {
        $all_players = $this->getDoctrine()->getRepository('AppBundle:Player')->findAllOrderedByName('all');

        $players = new Players();
        foreach ($all_players as $player) {
            $players->addPlayer($player);
        }

        $form = $this->createForm(new PlayersType(), $players);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            foreach ($players as $player) {
                $em->persist($player);
            }

            $em->flush();

            $this->addFlash('notice', 'Players bulk edited');

            return $this->redirectToRoute('homepage');
        }

        return array(
                'form' => $form->createView(),
            );
    }

    /**
     * @Route("/player/{id}", name="player_by_id")
     * @Template("AppBundle:Player:index.html.twig")
     * @Method("GET")
     */
    public function infoAction($id)
    {
        $player = $this->getDoctrine()->getRepository('AppBundle:Player')->find($id);

        if (!$player) {
            throw $this->createNotFoundException('No player found for id ' . $id);
        }

        return array(
                'player' => $player,
            );
    }

    /**
     * @Route("/player/{id}/edit", name="edit_player_by_id")
     * @Template("AppBundle:Player:add.html.twig")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $player = $this->getDoctrine()->getRepository('AppBundle:Player')->find($id);

        if (!$player) {
            throw $this->createNotFoundException('No player found for id ' . $id);
        }

        $form = $this->createForm(new PlayerType(), $player);

        return array(
                'form' => $form->createView(),
                'action' => 'Update',
                'player' => $player,
            );
    }

    /**
     * @Route("/player/{id}/edit", name="update_player_by_id")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $player = $em->getRepository('AppBundle:Player')->find($id);

        if (!$player) {
            throw $this->createNotFoundException('No player found for id ' . $id);
        }

        $form = $this->createForm(new PlayerType(), $player);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($player);
            $em->flush();

            $this->addFlash('notice', 'Player updated!');

            return $this->redirectToRoute('player_by_id', array('id' => $id));
        }

        return array(
                'form' => $form->createView(),
                'action' => 'Update',
            );

    }

    /**
     * @Route("/player/{id}/toggle", name="toggle_player_by_id")
     * @Method("GET")
     */
    public function toggleAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $player = $em->getRepository('AppBundle:Player')->find($id);

        if (!$player) {
            throw $this->createNotFoundException('No player found for id ' . $id);
        }

        $player->setActive(!$player->getActive());
        $em->persist($player);
        $em->flush();

        $state = $player->getActive() ? 'enabled' : 'disabled';

        $this->addFlash('notice', sprintf('Player %s (%s) is %s.', $player->getName(), $player->getId(), $state));

        return $this->redirectToRoute('players');
    }
}
