<?php


namespace Tudublin;


use Mattsmithdev\PdoCrudRepo\DatabaseTableRepository;

class MovieController
{
    const PATH_TO_TEMPLATES = __DIR__ . '/../templates';
    private $twig;
    private $movieRepository;

    public function __construct()
    {
        $this->twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(self::PATH_TO_TEMPLATES));
        $this->movieRepository = new MovieRepository();
    }

    public function listMovies()
    {
        $movies = $this->movieRepository->findAll();

        $template = 'list.html.twig';
        $args = [
            'movies' => $movies
        ];
        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function delete()
    {
        $id = filter_input(INPUT_GET, 'id');
        $success = $this->movieRepository->delete($id);

        if($success){
            $this->listMovies();
        } else {
            $message = 'there was a problem trying to delete Movie with ID = ' . $id;
            $this->error($message);
        }
    }

    public function error($errorMessage)
    {
        $template = 'error.html.twig';
        $args = [
        'errorMessage' => $errorMessage
        ];
        $html = $this->twig->render($template, $args);
        print $html;
    }
}

