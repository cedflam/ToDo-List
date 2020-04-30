<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * Permet d'ajouter un utilisateur
     *
     * @Route("/user/create", name="user_create")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'utilisateur a été crée avec succès ! "
            );

            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/create-user.html.twig',[
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/user/show", name="users_show")
     * @param UserRepository $repo
     * @return Response
     */
    public function usersShow(UserRepository $repo)
    {
        return $this->render('user/show-users.html.twig', [
            'users'=> $repo->findAll()
        ]);
    }

    /**
     * Permet de modifier un utilisateur
     *
     * @Route("/user/edit/{id}", name="user_edit")
     *
     * @param UserPasswordEncoderInterface $encoder
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function userEdit(UserPasswordEncoderInterface $encoder,User $user, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                    "L'utilisateur a été modifié avec succès !"
            );

            return $this->redirectToRoute('users_show');
        }

        return $this->render('user/edit-user.html.twig', [
            'form'=> $form->createView(),
            'user'=> $user
        ]);
    }

    /**
     * Permet de supprimer un utilisateur
     *
     * @Route("user/delete/{id}", name="user_delete")
     *
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function userDelete(User $user, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'utilisateur a été supprimé avec succès !"
        );

        return $this->redirectToRoute('users_show');

    }


}
