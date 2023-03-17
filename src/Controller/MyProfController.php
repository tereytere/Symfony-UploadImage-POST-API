<?php

namespace App\Controller;

use App\Entity\MyProfile;
use App\Form\MyProfile1Type;
use App\Repository\MyProfileRepository;
use Doctrine\ORM\Mapping\Index;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/my/prof')]
class MyProfController extends AbstractController
{
    #[Route('/', name: 'app_my_prof_index', methods: ['GET'])]
    public function index(MyProfileRepository $myProfileRepository): Response
    {
        return $this->render('my_prof/index.html.twig', [
            'my_profiles' => $myProfileRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_my_prof_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MyProfileRepository $myProfileRepository, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $myProfile = new MyProfile();
        $form = $this->createForm(MyProfile1Type::class, $myProfile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            if ($file) {
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originalFileName);
                $fileName = $safeFileName.'-'.uniqid().'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    throw new \Exception('¡Uy!, algo salió mal! :(');
                }

                // Update the 'imageName' property to store the filename
                $myProfile->setImage($fileName);
            }

            $em = $doctrine->getManager();
            $em->persist($myProfile);
            $em->flush();

            $myProfileRepository->save($myProfile, true);

            return $this->redirectToRoute('app_my_prof_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('my_prof/new.html.twig', [
            'my_profile' => $myProfile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_my_prof_show', methods: ['GET'])]
    public function show(MyProfile $myProfile): Response
    {
        return $this->render('my_prof/show.html.twig', [
            'my_profile' => $myProfile,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_my_prof_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MyProfile $myProfile, MyProfileRepository $myProfileRepository): Response
    {
        $form = $this->createForm(MyProfile1Type::class, $myProfile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $myProfileRepository->save($myProfile, true);

            return $this->redirectToRoute('app_my_prof_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('my_prof/edit.html.twig', [
            'my_profile' => $myProfile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_my_prof_delete', methods: ['POST'])]
    public function delete(Request $request, MyProfile $myProfile, MyProfileRepository $myProfileRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$myProfile->getId(), $request->request->get('_token'))) {
            $myProfileRepository->remove($myProfile, true);
        }

        return $this->redirectToRoute('app_my_prof_index', [], Response::HTTP_SEE_OTHER);
    }
}
