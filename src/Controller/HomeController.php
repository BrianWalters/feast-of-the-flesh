<?php

namespace App\Controller;

use App\Entity\Movie;
use App\OMDB\API;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(MovieRepository $movieRepository, API $api)
    {
        $year = (int)(new \DateTime('now'))->format('Y');

        $movies = $movieRepository->findBy(
            [
                'yearFeasted' => $year,
            ],
            [
                'startTime' => 'ASC',
            ]
        );

        $description = implode(', ', array_map(fn(Movie $movie) => $movie->getTitle(), $movies));

        $title = count($movies) > 0 ? $movies[0]->getTitle() : "Feast of the Flesh has not been scheduled yet";

        return $this->render('home/index.html.twig', [
            'title' => $title,
            'description' => $description,
            'movies' => $movies,
        ]);
    }
}
