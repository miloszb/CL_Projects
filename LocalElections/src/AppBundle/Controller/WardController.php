<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ward;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Ward controller.
 *
 * @Route("adm/obw")
 */
class WardController extends Controller
{
    /**
     * Lists all ward entities.
     *
     * @Route("/", name="ward_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $wards = $em->getRepository('AppBundle:Ward')->findAll();

        return $this->render('ward/index.html.twig', array(
            'wards' => $wards,
        ));
    }

    /**
     * Creates a new ward entity.
     *
     * @Route("/new", name="ward_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ward = new Ward();
        $form = $this->createForm('AppBundle\Form\WardType', $ward);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ward);
            $em->flush($ward);

            return $this->redirectToRoute('ward_show', array('id' => $ward->getId()));
        }

        return $this->render('ward/new.html.twig', array(
            'ward' => $ward,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ward entity.
     *
     * @Route("/{id}", name="ward_show")
     * @Method("GET")
     */
    public function showAction(Ward $ward)
    {
        $deleteForm = $this->createDeleteForm($ward);

        return $this->render('ward/show.html.twig', array(
            'ward' => $ward,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ward entity.
     *
     * @Route("/{id}/edit", name="ward_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ward $ward)
    {
        $deleteForm = $this->createDeleteForm($ward);
        $editForm = $this->createForm('AppBundle\Form\WardType', $ward);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ward_edit', array('id' => $ward->getId()));
        }

        return $this->render('ward/edit.html.twig', array(
            'ward' => $ward,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ward entity.
     *
     * @Route("/{id}", name="ward_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ward $ward)
    {
        $form = $this->createDeleteForm($ward);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ward);
            $em->flush($ward);
        }

        return $this->redirectToRoute('ward_index');
    }

    /**
     * Creates a form to delete a ward entity.
     *
     * @param Ward $ward The ward entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ward $ward)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ward_delete', array('id' => $ward->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
