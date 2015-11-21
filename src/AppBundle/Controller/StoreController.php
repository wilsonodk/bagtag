<?php
// src/AppBundle/Controller/StoreController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Store;
use AppBundle\Form\Type\StoreType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StoreController extends Controller
{
    /**
     * @Route("/stores", name="stores")
     * @Template("AppBundle:Store:stores.html.twig")
     * @Method("GET")
     */
    public function listAction()
    {
        $stores = $this->getDoctrine()->getRepository('AppBundle:Store')->findAllOrderedByName();

        return array(
                'stores' => $stores,
            );
    }

    /**
     * @Route("/stores/add", name="add_store")
     * @Template("AppBundle:Store:store_add.html.twig")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $store = new Store();
        $form = $this->createForm(new StoreType(), $store);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($store);
            $em->flush();

            $this->addFlash('notice', 'New store added!');

            return $this->redirectToRoute('stores');
        }

        return array(
                'form' => $form->createView(),
            );
    }

    /**
     * @Route("/store/{id}", name="store_by_id")
     * @Template("AppBundle:Store:store.html.twig")
     * @Method("GET")
     */
    public function infoAction($id)
    {
        $store = $this->getDoctrine()->getRepository('AppBundle:Store')->find($id);

        if (!$store) {
            throw $this->createNotFoundException('No store found for id ' . $id);
        }

        return array(
                'store' => $store,
            );
    }

}
