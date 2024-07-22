<?php

namespace App\Controller\Front;

use App\DTO\ContactDTO;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/Front/contact', name: 'front_contact')]
class ContactController extends AbstractController
{
    #[Route('/', 'index')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $contact = new ContactDTO();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $send = new Email();
            $send->from($contact->getEmail());
            $send->to($contact->getService())
                ->subject('New message')
                ->text($contact->getMessage());

            $mailer->send($send);
        }
        return $this->render('front/contact/index.html.twig', ['formulaire_contact' => $form]);
    }
}
