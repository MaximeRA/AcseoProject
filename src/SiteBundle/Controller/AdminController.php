<?php

namespace SiteBundle\Controller;

use SiteBundle\Entity\Admin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SiteBundle\Form\AdminType;


class AdminController extends Controller
{

    public function connectAdminAction(Request $request) {

        $admin = new Admin();

        $form = $this->get('form.factory')->create(AdminType::class, $admin);


        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            if ($admin->getPassword()=="admin" && $admin->getPseudo()=="admin") {

               return $this->redirectToRoute('admin_ticket');
            }

        } else {

            // Affichage du formulaire
            return $this->render('SiteBundle:admin:connect.html.twig', array(
                'form' => $form->createView(),
            ));
        }
        // Affichage du formulaire
        return $this->render('SiteBundle:admin:connect.html.twig', array(
            'form' => $form->createView(),
        ));


    }

    public function showAction()
    {

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('SiteBundle:Contact');
            $contacts = $repository->findAll();

            return $this->render('SiteBundle:Admin:show.html.twig', array(
                'contacts' => $contacts)
        );

        return $this->redirectToRoute('admin_form');

    }

    public function updateAction ($contactId, $status) {

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SiteBundle:Contact');

        $contact = $repository->find($contactId);

        if ($status == "false"){
            $contact->setIsAnswered(true);
        }
        else {
            $contact->setIsAnswered(false);
        }

        $em->persist($contact);
        $em->flush();

        return $this->redirectToRoute('admin_ticket');

    }

}


