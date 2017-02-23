<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Committee;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Committee controller.
 *
 * @Route("kom")
 */
class CommitteeController extends Controller
{
    /**
     * Lists all committee entities.
     *
     * @Route("/", name="committee_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $committees = $em->getRepository('AppBundle:Committee')->findAll();

        return $this->render('committee/index.html.twig', array(
            'committees' => $committees,
        ));
    }

    /**
     * Creates a new committee entity.
     *
     * @Route("/new", name="committee_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $committee = new Committee();
        $form = $this->createForm('AppBundle\Form\CommitteeType', $committee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($committee);
            $em->flush($committee);

            return $this->redirectToRoute('committee_show', array('id' => $committee->getId()));
        }

        return $this->render('committee/new.html.twig', array(
            'committee' => $committee,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a committee entity.
     *
     * @Route("/{id}", name="committee_show")
     * @Method("GET")
     */
    public function showAction(Committee $committee)
    {
        $deleteForm = $this->createDeleteForm($committee);

        return $this->render('committee/show.html.twig', array(
            'committee' => $committee,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing committee entity.
     *
     * @Route("/{id}/edit", name="committee_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Committee $committee)
    {
        $deleteForm = $this->createDeleteForm($committee);
        $editForm = $this->createForm('AppBundle\Form\CommitteeType', $committee);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('committee_edit', array('id' => $committee->getId()));
        }

        return $this->render('committee/edit.html.twig', array(
            'committee' => $committee,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a committee entity.
     *
     * @Route("/{id}", name="committee_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Committee $committee)
    {
        $form = $this->createDeleteForm($committee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($committee);
            $em->flush($committee);
        }

        return $this->redirectToRoute('committee_index');
    }

    /**
     * Creates a form to delete a committee entity.
     *
     * @param Committee $committee The committee entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Committee $committee)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('committee_delete', array('id' => $committee->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
