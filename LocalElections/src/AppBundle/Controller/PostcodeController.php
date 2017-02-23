<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Postcode;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Postcode controller.
 *
 * @Route("adm/kod")
 */
class PostcodeController extends Controller
{
    /**
     * Lists all postcode entities.
     *
     * @Route("/", name="postcode_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $postcodes = $em->getRepository('AppBundle:Postcode')->findAll();

        return $this->render('postcode/index.html.twig', array(
            'postcodes' => $postcodes,
        ));
    }

    /**
     * Creates a new postcode entity.
     *
     * @Route("/new", name="postcode_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $postcode = new Postcode();
        $form = $this->createForm('AppBundle\Form\PostcodeType', $postcode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($postcode);
            $em->flush($postcode);

            return $this->redirectToRoute('postcode_show', array('id' => $postcode->getId()));
        }

        return $this->render('postcode/new.html.twig', array(
            'postcode' => $postcode,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a postcode entity.
     *
     * @Route("/{id}", name="postcode_show")
     * @Method("GET")
     */
    public function showAction(Postcode $postcode)
    {
        $deleteForm = $this->createDeleteForm($postcode);

        return $this->render('postcode/show.html.twig', array(
            'postcode' => $postcode,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing postcode entity.
     *
     * @Route("/{id}/edit", name="postcode_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Postcode $postcode)
    {
        $deleteForm = $this->createDeleteForm($postcode);
        $editForm = $this->createForm('AppBundle\Form\PostcodeType', $postcode);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('postcode_edit', array('id' => $postcode->getId()));
        }

        return $this->render('postcode/edit.html.twig', array(
            'postcode' => $postcode,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a postcode entity.
     *
     * @Route("/{id}", name="postcode_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Postcode $postcode)
    {
        $form = $this->createDeleteForm($postcode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($postcode);
            $em->flush($postcode);
        }

        return $this->redirectToRoute('postcode_index');
    }

    /**
     * Creates a form to delete a postcode entity.
     *
     * @param Postcode $postcode The postcode entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Postcode $postcode)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('postcode_delete', array('id' => $postcode->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
