<?php

namespace App\Controller;

use App\Entity\Quotes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InitController extends AbstractController
{
    /**
     * @Route("/init", name="init", methods={"POST"})
     */
    public function inittable(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $providedquotefile = json_decode(file_get_contents(__DIR__ . '/../../resources/quotes.json'), true);
        foreach ($providedquotefile['quotes'] as $providedquote) {
            $author = trim($providedquote['author']);
            $route = preg_replace('/[^\p{L}\p{N}_]/u', '', str_replace(' ', '_', strtolower($author)));
            $quote = new Quotes();
            $quote->setQuote($providedquote['quote']);
            $quote->setAuthor($author);
            $quote->setRoute($route);
            $em->persist($quote);
            $em->flush();
        }
        return new Response('Initialisation is complete.', Response::HTTP_OK);
    }
}
