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
                'action' => 'Add',
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

    /**
     * @Route("/store/{id}/edit", name="edit_store_by_id")
     * @Template("AppBundle:Store:store_add.html.twig")
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

}
