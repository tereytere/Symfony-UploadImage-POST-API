<?php
namespace App\Controller\Api;

use App\Entity\MyProfile;
use App\Form\MyProfile1Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

// use Vich\UploaderBundle\Handler\UploadHandler;
use Doctrine\Persistence\ManagerRegistry;
// use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/api')]
class MyProfileController extends AbstractController
{

     #[Route('/my/profile', name: 'my_profile_upload', methods: ['POST'])]
    public function uploadImage(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): JsonResponse
    {
        // $em = $this->$doctrine->getManager();

        $myProfile = new MyProfile();

        $fileRetrieve = $this->createForm(MyProfile1Type::class, $myProfile);
        $fileRetrieve->handleRequest($request);
        $file = $fileRetrieve['image']->getData();

        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFileName = $slugger->slug($originalFileName);
        $fileName = $safeFileName.'-'.uniqid().'.'.$file->guessExtension();

        $file->move(
            $this->getParameter('images_directory'),
            $fileName
        );

        $myProfile->setImage($fileName);

        $em = $doctrine->getManager();
        $em->persist($myProfile);
        $em->flush();

        // $response = new Response;
        // $response->headers->add([
        //     'Content-type' => 'application/json'
        // ])

        return new JsonResponse(['id' => $myProfile->getId()]);
    }
}