<?php
// src/AppBundle/Controller/ChallengeController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Entity\Challenge;
use AppBundle\Form\Type\ChallengeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ChallengeController extends Controller
{
    /**
     * @Route("/challenges", name="challenges")
     * @Template("AppBundle:Challenge:challenges.html.twig")
     * @Method("GET")
     */
    public function listAction()
    {
        $challenges = $this->getDoctrine()
            ->getRepository('AppBundle:Challenge')
            ->findAllActiveOrderedByHostedDate();

        return array(
                'challenges' => $challenges,
            );
    }

    /**
     * @Route("/challenges/add", name="add_challenge")
     * @Template("AppBundle:Challenge:challenge_add.html.twig")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $challenge = new Challenge();
        $form = $this->createForm(new ChallengeType(), $challenge);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($challenge);
            $em->flush();

            $this->addFlash('notice', 'New challenge added!');

            return $this->redirectToRoute('challenge_by_id', array('id' => $challenge->getId()));
        }

        return array(
                'action' => 'Create',
                'form' => $form->createView(),
            );
    }

    /**
     * @Route("/challenge/{id}", name="challenge_by_id")
     * @Template("AppBundle:Challenge:challenge.html.twig")
     * @Method("GET")
     */
    public function infoAction($id)
    {
        $challenge = $this->getDoctrine()
                    ->getRepository('AppBundle:Challenge')
                    ->find($id);

        if (!$challenge) {
            throw $this->createNotFoundException('No challenge with id ' . $id);
        }

        return array(
                'challenge' => $challenge,
            );
    }

    /**
     * @Route("challenge/{id}/complete", name="complete_challenge")
     * @Method("POST")
     */
    public function completeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $challenge = $em->getRepository('AppBundle:Challenge')->find($id);
        $challenge->setActive(false);
        $em->persist($challenge);

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
        $this->addFlash('notice', 'Challenge "' . $challenge->getName() . '" updated and closed!');

        # Return success
        $response = new JsonResponse();
        $response->setData(array('success' => true, 'challenge' => $challenge->getName(), 'ranks' => $ranks));
        return $response;
    }
}
