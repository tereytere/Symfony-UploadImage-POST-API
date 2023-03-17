<?php

namespace App\Controller;

use App\Entity\MyProfile;
use App\Form\MyProfileType;
use App\Repository\MyProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MyProfileController extends AbstractController
{
    // // #[Route('/my/profile', name: 'app_my_profile')]
    // public function index(ManagerRegistry $doctrine): Response
    // {
    //     $form = $this->createForm(MyProfileType::class, $myProfile);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // handle file upload
    //         $file = $myProfile->getImageFile();
    //         if ($file instanceof UploadedFile) {
    //             $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

    //             // Move the file to the directory where brochures are stored
    //             try {
    //                 $file->move(
    //                     $this->getParameter('my_profile_images_directory'),
    //                     $fileName
    //                 );
    //             } catch (FileException $e) {
    //                 throw new \Exception('¡Uy!, algo salió mal! :(');
    //             }

    //             // Update the 'imageName' property to store the filename
    //             $myProfile->setImageName($fileName);
    //         }

    //         $em = $doctrine()->getManager();
    //         $em->persist($myProfile);
    //         $em->flush();

    //         return $this->redirectToRoute('my_profile_show', ['id' => $myProfile->getId()]);

            
    //     }

    //     return $this->render('my_profile/edit.html.twig', [
    //         'form' => $form->createView(),
    //         'my_profile' => $myProfile,
    //     ]);

    // }

    // #[Route('/my-profile/{id}/image', name: 'my_profile_image')]
    
    // public function image(MyProfile $myProfile): Response
    // {
    //     $imagePath = $this->getParameter('my_profile_images_directory').'/'.$myProfile->getImageName();

    //     return $this->file($imagePath);
    // }

    // #[Route('/show', name: 'my_profile_image_show', methods: ['GET'])]
    // public function show(MyProfileRepository $myProfileRepository): Response
    // {
    //     return $this->render('my_profile/show.html.twig', [
    //         'my_profile' => $myProfileRepository->findAll(),
    //     ]);
    // }
}
