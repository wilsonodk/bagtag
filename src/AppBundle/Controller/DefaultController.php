<?php
// src/AppBundle/Controller/DefaultController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("AppBundle:default:index.html.twig")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $players = $this->getDoctrine()->getRepository('AppBundle:Player')->findAllOrderedByRank();

        return array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'players' => $players,
        );
    }
}
