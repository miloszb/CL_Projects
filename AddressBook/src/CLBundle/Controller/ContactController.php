<?php

namespace CLBundle\Controller;

use CLBundle\Entity\Address;
use CLBundle\Entity\CGroup;
use CLBundle\Entity\Contact;
use CLBundle\Entity\Email;
use CLBundle\Entity\Phone;
use CLBundle\Form\AddressType;
use CLBundle\Form\CGroupType;
use CLBundle\Form\ContactType;
use CLBundle\Form\EmailType;
use CLBundle\Form\PhoneType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * @Route("/")
     * @Method("GET")
     * @Template()
     */
    public function showAllAction()
    {
        $contacts = $this
            ->getDoctrine()
            ->getRepository('CLBundle:Contact')
            ->findBy([], ['surname' => 'ASC']);
        if (!$contacts) {
            $contacts = [];
        }
        return ['contacts' => $contacts];
    }

    /**
     * @Route("/")
     * @Method("POST")
     * @Template("CLBundle:Contact:showAll.html.twig")
     */
    public function showSearchAction(Request $request)
    {
        $searchstr = $request->request->get('search');
        $em = $this
            ->getDoctrine()
            ->getEntityManager();
        $contacts = $em
            ->getRepository('CLBundle:Contact')
            ->findBySearch($searchstr);
        if (!$contacts) {
            $contacts = [];
        }
        return ['contacts' => $contacts, 'searchmode' => true];
    }

    /**
     * @Route("/new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $contact = new Contact();

        $form = $this->createForm(new ContactType(), $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('cl_contact_show', ['id' => $contact->getId()]);
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{contactID}/addEmail")
     * @Template()
     */
    public function addEmailAction(Request $request, $contactID)
    {
        $email = new Email();
        $contact = $this
            ->getDoctrine()
            ->getRepository('CLBundle:Contact')
            ->find($contactID);
        if (!$contact) {
            throw $this->createNotFoundException('Nie znaleziono rekordu (addEmail)');
        }

        $form = $this->createForm(new EmailType(), $email);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email->setContact($contact);
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($email);
            $em->flush();

            return $this->redirectToRoute('cl_contact_show', ['id' => $contactID]);
        }

        return ['form' => $form->createView(), 'contact' => $contact];
    }

    /**
     * @Route("/{contactID}/addPhone")
     * @Template()
     */
    public function addPhoneAction(Request $request, $contactID)
    {
        $phone = new Phone();
        $contact = $this
            ->getDoctrine()
            ->getRepository('CLBundle:Contact')
            ->find($contactID);
        if (!$contact) {
            throw $this->createNotFoundException('Nie znaleziono rekordu (addPhone)');
        }

        $form = $this->createForm(new PhoneType(), $phone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $phone->setContact($contact);
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($phone);
            $em->flush();

            return $this->redirectToRoute('cl_contact_show', ['id' => $contactID]);
        }

        return ['form' => $form->createView(), 'contact' => $contact];
    }

    /**
     * @Route("/{contactID}/addAddress")
     * @Template()
     */
    public function addAddressAction(Request $request, $contactID)
    {
        $address = new Address();
        $contact = $this
            ->getDoctrine()
            ->getRepository('CLBundle:Contact')
            ->find($contactID);
        if (!$contact) {
            throw $this->createNotFoundException('Nie znaleziono rekordu (addAdress)!');
        }

        $form = $this->createForm(new AddressType(), $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setContact($contact);
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute('cl_contact_show', ['id' => $contactID]);
        }

        return ['form' => $form->createView(), 'contact' => $contact];
    }

    /**
     * @Route("/{id}/modify")
     * @Template()
     */
    public function modifyAction(Request $request, $id)
    {
        $contact = $this
            ->getDoctrine()
            ->getRepository('CLBundle:Contact')
            ->find($id);
        if (!$contact) {
            throw $this->createNotFoundException('Nie znaleziono (modify)');
        }
        $form = $this->createForm(new ContactType(), $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('cl_contact_show', ['id' => $contact->getId()]);
        }

        return ['form' => $form->createView(), 'contact' => $contact];
    }

    /**
     * @Route("/{id}/delete")
     */
    public function deleteAction($id)
    {
        $contact = $this->getDoctrine()->getRepository('CLBundle:Contact')->find($id);
        if (!$contact) {
            throw $this->createNotFoundException('Nie znaleziono (delete)');
        }

        $em = $this->getDoctrine()->getManager();

        foreach ($contact->getEmails() as $email) {
            $em->remove($email);
        }
        foreach ($contact->getPhones() as $phone) {
            $em->remove($phone);
        }
        foreach ($contact->getAddresses() as $address) {
            $em->remove($address);
        }
        $em->remove($contact);

        $em->flush();

        return $this->redirectToRoute('cl_contact_showall');
    }

    /**
     * @Route("/{contactId}/{id}/deleteEmail")
     */
    public function deleteEmailAction($contactId, $id)
    {
        $email = $this
            ->getDoctrine()
            ->getRepository('CLBundle:Email')
            ->find($id);
        if (!$email) {
            throw $this->createNotFoundException('Nie znaleziono rekordu (deleteEmail)');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($email);
        $em->flush();

        return $this->redirectToRoute('cl_contact_show', ['id' => $contactId]);
    }

    /**
     * @Route("/{contactId}/{id}/deletePhone")
     */
    public function deletePhoneAction($contactId, $id)
    {
        $phone = $this
            ->getDoctrine()
            ->getRepository('CLBundle:Phone')
            ->find($id);
        if (!$phone) {
            throw $this->createNotFoundException('Nie znaleziono (deletePhone)');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($phone);
        $em->flush();

        return $this->redirectToRoute('cl_contact_show', ['id' => $contactId]);
    }

    /**
     * @Route("/{contactId}/{id}/deleteAddress")
     */
    public function deleteAddressAction($contactId, $id)
    {
        $address = $this
            ->getDoctrine()
            ->getRepository('CLBundle:Address')
            ->find($id);
        if (!$address) {
            throw $this->createNotFoundException('Nie znaleziono rekordu (deleteAddress)');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($address);
        $em->flush();

        return $this->redirectToRoute('cl_contact_show', ['id' => $contactId]);
    }

    /**
     * @Route("/showGroups")
     * @Template()
     */
    public function showGroupsAction()
    {
        $groups = $this
            ->getDoctrine()
            ->getRepository('CLBundle:CGroup')
            ->findAll();
        if (!$groups) {
            $groups = [];
        }

        return ['groups' => $groups];
    }

    /**
     * @Route("/addGroup")
     * @Template("CLBundle:Contact:modifyGroup.html.twig")
     */
    public function addGroupAction(Request $request)
    {
        $group = new CGroup();

        $form = $this->createForm(new CGroupType(), $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('cl_contact_showgroups');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}/modifyGroup")
     * @Template()
     */
    public function modifyGroupAction(Request $request, $id)
    {
        $group = $this
            ->getDoctrine()
            ->getRepository('CLBundle:CGroup')
            ->find($id);
        if (!$group) {
            throw $this->createNotFoundException('Nie znaleziono rekordu (modifyGroup)');
        }

        $form = $this->createForm(new CGroupType(), $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('cl_contact_showgroups');
        }

        return ['form' => $form->createView(), 'group' => $group];
    }

    /**
     * @Route("/{id}/deleteGroup")
     */
    public function deleteGroupAction($id)
    {
        $group = $this
            ->getDoctrine()
            ->getRepository('CLBundle:CGroup')
            ->find($id);
        if (!$group) {
            throw $this->createNotFoundException('Nie znaleziono rekordu (deleteGroup)');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($group);
        $em->flush();

        return $this->redirectToRoute('cl_contact_showgroups');
    }

    /**
     * @Route("/{id}")
     * @Template()
     */
    public function showAction($id)
    {
        $contact = $this
            ->getDoctrine()
            ->getRepository('CLBundle:Contact')
            ->find($id);
        if (!$contact) {
            throw $this->createNotFoundException('Nie znaleziono rekordu (show)');
        }
        return ['contact' => $contact];
    }
}
