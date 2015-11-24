<?php
// src/AppBundle/Controller/TournamentController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Entity\Tournament;
use AppBundle\Form\Type\TournamentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TournamentController extends Controller
{
    /**
     * @Route("/tournaments", name="tournaments")
     * @Template("AppBundle:Tournament:tournaments.html.twig")
     * @Method("GET")
     */
    public function listAction()
    {
        $tournaments = $this->getDoctrine()
            ->getRepository('AppBundle:Tournament')
            ->findAllActiveOrderedByHostedDate();

        return array(
                'tournaments' => $tournaments,
            );
    }

    /**
     * @Route("/tournaments/add", name="add_tournament")
     * @Template("AppBundle:Tournament:tournament_add.html.twig")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $tournament = new Tournament();
        $form = $this->createForm(new TournamentType(), $tournament);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tournament);
            $em->flush();

            $this->addFlash('notice', 'New tournament added!');

            return $this->redirectToRoute('tournament_by_id', array('id' => $tournament->getId()));
        }

        return array(
                'action' => 'Create',
                'form' => $form->createView(),
            );
    }

    /**
     * @Route("/tournament/{id}", name="tournament_by_id")
     * @Template("AppBundle:Tournament:tournament.html.twig")
     * @Method("GET")
     */
    public function infoAction($id)
    {
        $tournament = $this->getDoctrine()
                    ->getRepository('AppBundle:Tournament')
                    ->find($id);

        if (!$tournament) {
            throw $this->createNotFoundException('No tournament with id ' . $id);
        }

        return array(
                'tournament' => $tournament,
            );
    }

    /**
     * @Route("tournament/{id}/complete", name="complete_tournament")
     * @Method("POST")
     */
    public function completeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $tournament = $em->getRepository('AppBundle:Tournament')->find($id);
        $tournament->setActive(false);
        $em->persist($tournament);

        # Get ranks of players, and sort them
        $data = $request->request->get('players');

        $ranks = array();
        foreach ($data as $val) {
            $ranks[] = $val['rank'];
        }
        sort($ranks);

        # Using order of POST-players, update all the players
        $repo = $em->getRepository('AppBundle:Player');
        foreach ($data as $i => $val) {
            var_dump($val['name']);
            $player = $repo->findOneByName($val['name']);
            $prev   = $player->getRank();

            $player
                ->setRank($ranks[$i])
                ->setPrevious($prev)
                ;

            $em->persist($player);
        }
        $em->flush();

        # Flash a success
        $this->addFlash('notice', 'Tournament "' . $tournament->getName() . '" updated and closed!');

        # Return success
        $response = new JsonResponse();
        $response->setData(array('success' => true, 'tournament' => $tournament->getName(), 'ranks' => $ranks));
        return $response;
    }
}
