<?php

namespace App\Controller;

use App\Entity\Quotes;
use App\Message\ApiMessage;
use Predis\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ShoutquoteController extends AbstractController
{
    public function __construct()
    {
        $this->redis = new Client($_ENV['REDIS_DSN']);
    }
    /**
     * @Route("/shout/{author}", name="shout", methods={"GET"})
     */
    public function shout(MessageBusInterface $bus, Request $request, string $author): Response
    {
        $limit = $request->query->get('limit', 1);

        if ($limit > 10 or $limit <= 0) {
            throw new BadRequestHttpException('Prohibited quote limit. You need to specify a limit lower than or equal to (<=) 10 and greater than 0.', null, 400);
        }
        if (in_array($author, ['', ' ', 'undefined', null])) {
            throw new BadRequestHttpException('You need to specify a valid author, e.g. Steve Jobs as steve_jobs. You can also call the /shout/list endpoint for a list of valid authors.', null, 400);
        }

        $rediskey = "$author?limit=$limit";
        $item = $this->redis->get($rediskey);
        if ($item) {
            return new Response($item, Response::HTTP_OK);
        }
        $quotes = $this->getDoctrine()->getRepository(Quotes::class)->findBy(['route' => $author], null, $limit);
        if (!$quotes) {
            throw $this->createNotFoundException('There are no quotes for the given author.');
        } else {
            $theyshouted = [];
            foreach ($quotes as $q) {
                $theyshouted[] = $this->generatedshoutedquote($q->getQuote());
            }
        }
        $bus->dispatch(new ApiMessage($rediskey, json_encode($theyshouted)));
        return $this->json($theyshouted);
    }
    /**
     * @Route("/list", name="list", methods={"GET"})
     */
    public function list(MessageBusInterface $bus): Response
    {
        $rediskey = "list_author";
        $item = $this->redis->get($rediskey);
        if ($item) {
            return new Response($item, Response::HTTP_OK);
        }
        $qb = $this->getDoctrine()
            ->getRepository(Quotes::class)
            ->getRoutes();
        $list = array_column($qb, "route");
        $bus->dispatch(new ApiMessage($rediskey, json_encode($list)));

        return $this->json($list);
    }
    /**
     * @param string $quote
     * @return string
     * @throws \Exception
     */
    protected function generatedshoutedquote(string $quote)
    {
        $quote = str_replace(['“', '”'], '"', $quote);
        $quotelength = strlen($quote);
        if (\in_array(substr($quote, $quotelength - 1, $quotelength), ['!'])) {
            return strtoupper($quote);
        } else {
            return strtoupper(substr($quote, 0, $quotelength - 1) . '!');
        }
    }
}
