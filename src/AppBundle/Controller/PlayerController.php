<?php
// src/AppBundle/Controller/PlayerController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Form\Type\PlayerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PlayerController extends Controller
{
    /**
     * @Route("/players", name="players")
     * @Template("AppBundle:Player:players.html.twig")
     * @Method("GET")
     */
    public function listAction()
    {
        $players = $this->getDoctrine()->getRepository('AppBundle:Player')->findAllOrderedByName();

        return array(
                'players' => $players,
            );
    }

    /**
     * @Route("/players/add", name="add_player")
     * @Template("AppBundle:Player:player_add.html.twig")
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
                'form' => $form->createView(),
            );
    }

    /**
     * @Route("/player/{id}", name="player_by_id")
     * @Template("AppBundle:Player:player.html.twig")
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
}
