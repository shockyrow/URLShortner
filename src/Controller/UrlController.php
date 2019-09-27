<?php

namespace App\Controller;

use App\Entity\Url;
use App\Repository\UrlRepository;
use App\Service\HashGeneratorInterface;
use App\Service\ShortUrlGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class UrlController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var HashGeneratorInterface
     */
    private $hashGenerator;
    /**
     * @var ShortUrlGeneratorInterface
     */
    private $shortUrlGenerator;
    /**
     * @var UrlRepository
     */
    private $urlRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        RouterInterface $router,
        SessionInterface $session,
        HashGeneratorInterface $hashGenerator,
        ShortUrlGeneratorInterface $shortUrlGenerator,
        UrlRepository $urlRepository
    ) {
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->session = $session;
        $this->hashGenerator = $hashGenerator;
        $this->shortUrlGenerator = $shortUrlGenerator;
        $this->urlRepository = $urlRepository;
    }

    /**
     * @Route("/url/all", name="url_all")
     *
     * @return JsonResponse
     */
    public function getAll()
    {
        return $this->json($this->urlRepository->getAll());
    }

    /**
     * @Route("/url/current", name="url_current")
     *
     * @return JsonResponse
     */
    public function getCurrent()
    {
        $this->session->start();

        return $this->json(
            $this->urlRepository->getAllBySessionId(
                $this->session->getId()
            )
        );
    }

    /**
     * @Route("/url/create", name="url_create", methods={"POST"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $this->session->start();

        $urlHash = $this->hashGenerator->generate($request->get('url'));

        $url = $this->urlRepository->getOneByHash($urlHash);

        if ($url === null) {
            $url = (new Url())
                ->setHash($urlHash)
                ->setRealUrl($request->get('url'))
                ->setSessionId($this->session->getId())
            ;

            $this->entityManager->persist($url);
            $this->entityManager->flush();

            $url->setShortUrl(
                $this->shortUrlGenerator->generate($url->getId())
            );

            $this->entityManager->persist($url);
            $this->entityManager->flush();
        }

        return $this->json($url);
    }

    /**
     * @Route("/url/view/{id}", name="url_view")
     * @param string $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function view(string $id)
    {
        $url = $this->urlRepository->findOneBy([
            'short_url' => $this->router->generate('url_view', ['id' => $id])
        ]);

        if ($url != null) {
            $url->setViews($url->getViews() + 1);
            $this->entityManager->persist($url);
            $this->entityManager->flush();

            return $this->redirect($url->getRealUrl());
        } else {
            return $this->json('Not Found!', 404);
        }
    }
}
