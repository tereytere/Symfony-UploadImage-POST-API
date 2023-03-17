<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\MyProfile;

class UploadImageController extends AbstractController
{
    #[Route('/upload/image', name: 'app_upload_image', methods: ['POST'])]
    public function uploadImage(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        // Creamos una variable que crea una nueva instancia "MyProfile()"
        $uploadImage = new MyProfile();

        // En otra variable guardamos las instrucciones para buscar mi campo 'image'
        $file = $request->files->get('image');

        //En otra variable guardamos las instrucciones para que se genere un nombre único para cada imágen, y además se codifique con el método "md5" casi como lo que hace un token, luego le decimos que adivine la extención (jpg, png, svg)
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        // Sobre nuestra variable "file" usamos el método move para guardar la imágen en una carpeta de nuestro proyecto.

        $file->move(
            $this->getParameter('images_directory'),
            $fileName
        );

        // Sobre nuestro objeto de tipo MyProfile uso mi setter y le digo que contenga lo que guarde en mi variable "fileName"

        $uploadImage->setImage($fileName);

        // Luego en una variable guardamos nuestra llamada a doctrine, para luego persistir los cambios y hacer flush.
        $em = $doctrine->getManager();

        $em->persist($uploadImage);
        $em->flush();

        // Hago una variable "Response" donde guardo una respuesta de tipo Json que me da un mensaje de confirmación, y luego especifico mis headers para no tener problemas con el CORS

        $response = new JsonResponse(['It was uploaded succesfully!!!']);
        $response->headers->add(['Access-Control-Allow-Origin' => '*']);

        return $response;

        
    }
}
