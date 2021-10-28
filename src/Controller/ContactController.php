<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact', methods: ['GET', 'POST'] )]
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {
        //creando objeto para manipular la informarcion de contacto
        $contacto = new Contact();
        $form = $this->createForm(ContactFormType::class, $contacto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message())
                ->setSubject('Contacto')
                ->setFrom([$contacto->getEmail()])
                ->setTo(['tomasmallolaino@gmail.com' => 'Toto'])
                ->setBody(
                    $this->renderView('contact/contact.mailer.html.twig', [
                        'contact' => $contacto]),
                    'text/html'
                )
                ->addPart(
                    'Esto es texto pelado.',
                    'text/plain'
                );
            $mailer->send($message);
            return $this->redirectToRoute('home_page');
        }

        return $this->render('contact/contact.html.twig', [
            'contact' => $contacto,
            'form' => $form->createView()
        ]);
    }
}
