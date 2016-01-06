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
     * @Template("AppBundle:Store:list.html.twig")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $type = $request->query->get('type', 'active');

        $stores = $this->getDoctrine()->getRepository('AppBundle:Store')->findAllOrderedByName($type);

        return array(
                'stores' => $stores,
                'picked_state' => $type,
            );
    }

    /**
     * @Route("/stores/add", name="add_store")
     * @Template("AppBundle:Store:add.html.twig")
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
                'action' => 'Add',
            );
    }

    /**
     * @Route("/store/{id}", name="store_by_id")
     * @Template("AppBundle:Store:index.html.twig")
     * @Method("GET")
     */
    public function infoAction($id)
    {
        $store = $this->getDoctrine()->getRepository('AppBundle:Store')->find($id);

        if (!$store) {
            throw $this->createNotFoundException('No store found for id ' . $id);
        }

        $players = $this->getDoctrine()->getRepository('AppBundle:Player')->findAllByStore($id);

        return array(
                'store' => $store,
                'players' => $players,
            );
    }

    /**
     * @Route("/store/{id}/edit", name="edit_store_by_id")
     * @Template("AppBundle:Store:add.html.twig")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $store = $this->getDoctrine()->getRepository('AppBundle:Store')->find($id);

        if (!$store) {
            throw $this->createNotFoundException('No store found for id ' . $id);
        }

        $form = $this->createForm(new StoreType(), $store);

        return array(
                'form' => $form->createView(),
                'action' => 'Update',
                'store' => $store,
            );
    }

    /**
     * @Route("/store/{id}/edit", name="update_store_by_id")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $store = $em->getRepository('AppBundle:Store')->find($id);

        if (!$store) {
            throw $this->createNotFoundException('No store found for id ' . $id);
        }

        $form = $this->createForm(new StoreType(), $store);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($store);
            $em->flush();

            $this->addFlash('notice', 'Store updated!');

            return $this->redirectToRoute('store_by_id', array('id' => $id));
        }

        return array(
                'form' => $form->createView(),
                'action' => 'Update',
            );
    }

    /**
     * @Route("/store/{id}/toggle", name="toggle_store_by_id")
     * @Method("GET")
     */
    public function toggleAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $store = $em->getRepository('AppBundle:Store')->find($id);

        if (!$store) {
            throw $this->createNotFoundException('No store found for id ' . $id);
        }

        $store->setActive(!$store->getActive());
        $em->persist($store);
        $em->flush();

        $state = $store->getActive() ? 'enabled' : 'disabled';

        $this->addFlash('notice', sprintf('Store %s (%s) is %s.', $store->getName(), $store->getId(), $state));

        return $this->redirectToRoute('stores');
    }
}
