<?php
// src/AppBundle/Controller/TournamentController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Tournament;
use AppBundle\Form\Type\TournamentType;
use Symfony\Component\HttpFoundation\Request;
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

            return $this->redirectToRoute('tournament_by_id', array('id', $tournament->getId()));
        }

        return array(
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
}
