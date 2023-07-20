<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReaderController extends AbstractController
{
    #[Route('/', name: 'app_reader')]
    public function index(): Response
    {
        $file = new Filesystem();

        $fileWeWannaRead = 'books/kek-64b9578a20474.txt';

        if ($file->exists('books/kek-64b9578a20474.txt')) {
            $text = file_get_contents($fileWeWannaRead);
        } else {
            $text = file_get_contents('test_text.txt');
        }

        $filteredText = trim(str_replace([PHP_EOL, "\t", "\n", '"', "'"], [' ', ' ', ' ', '`', '`'], $text));

        return $this->render('reader/index.html.twig', [
            'controller_name' => 'ReaderController',
            'text' => array_values(
                array_filter(
                    explode(' ', $filteredText),
                    function ($item) { return $item !== ''; }
                )
            ),
        ]);
    }
}
