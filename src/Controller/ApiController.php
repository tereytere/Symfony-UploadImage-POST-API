<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\MyProfile;



class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api', methods: ['POST'])]
    public function index(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): JsonResponse
    {
        $myProfile = new MyProfile();

        $safeFileName = $request->files->get('image');

                $fileName = md5(uniqid()).'.'.$safeFileName->guessExtension();

                    $safeFileName->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );

                $myProfile->setImage($fileName);

            $em = $doctrine->getManager();
            $em->persist($myProfile);
            $em->flush();

        $response = new JsonResponse(['It was uploaded succesfully!!!']);

        $response->headers->add([
            'Access-Control-Allow-Origin' => '*',
        ]);

        return $response;
    }
}
