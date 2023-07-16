<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloadFileController extends AbstractController
{
    #[Route('/download/file', name: 'app_download_file')]
    public function index(): Response
    {
        return $this->render('download_file/index.html.twig', [
            'controller_name' => 'DownloadFileController',
        ]);
    }
}
