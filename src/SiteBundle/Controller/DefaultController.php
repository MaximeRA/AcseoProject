<?php
// src/OC/PlatformBundle/Controller/AdvertController.php


namespace SiteBundle\Controller;

use SiteBundle\Entity\Contact;
use SiteBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function addAction(Request $request)
    {
        // On crée un objet Contact
        $contact = new Contact();

        $form = $this->get('form.factory')->create(ContactType::class, $contact);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->render('SiteBundle:Default:validate.html.twig', array(
                'contact' => $contact
            ));
        }


        // Affichage du formulaire
        return $this->render('SiteBundle:Contact:add.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}