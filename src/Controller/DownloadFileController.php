<?php

namespace App\Controller;

use App\Form\BookDownloadFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloadFileController extends AbstractController
{
    #[Route('/download/file', name: 'app_download_file')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(BookDownloadFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();

            //TODO move all save file functionality to separate service

            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL

                $newFilename = sprintf('%s%s%s', $originalFilename, uniqid(), $file->guessExtension());

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        'books',
                        $newFilename
                    );
                } catch (FileException $e) {
                    dd($e->getMessage());
                }

                $fileUploaded = true;
            }
        }

        return $this->render('download_file/index.html.twig', [
            'controller_name' => 'DownloadFileController',
            'form' => $form->createView(),
            'fileUploaded' => $fileUploaded ?? false,
        ]);
    }
}
