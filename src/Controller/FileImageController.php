<?php

namespace App\Controller;

use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "/image/{imageName}", name: "file_controller")]
class FileImageController extends AbstractController {

    public function __invoke($imageName) {
        $binaryFileResponse = new BinaryFileResponse(FileService::FILES_PATH . "/" . $imageName);

        return $binaryFileResponse;
    }
}
