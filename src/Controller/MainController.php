<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\LangageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class MainController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/', name: 'main_home')]
    public function home(UserRepository $userRepository, LangageRepository $langageRepository)
    {
        $users = $userRepository->findAll();
        $langages = $langageRepository->findAll();
        return $this->render('main/home.html.twig', ["users" => $users, 'langages' => $langages]);
    }

    #[Route('/Filtre/{langage}', name: 'main_filtre')]
    public function filter(UserRepository $userRepository, LangageRepository $langageRepository, $langage)
    {
        $users = $userRepository->Filter($langage);
        $langages = $langageRepository->findAll();
        return $this->render('main/home.html.twig', ["users" => $users, 'langages' => $langages]);
    }

    #[Route('/addFriend/{UserIdToAdd}', name: 'main_addFriend')]
    public function addFriend(UserRepository $userRepository,EntityManagerInterface $entityManager,$UserIdToAdd)
    {
        $UserConnected = $this->getUser();
        $UserToAdd = $userRepository->find($UserIdToAdd);
        $UserConnected->addAmi($UserToAdd);

        $entityManager->persist($UserConnected);
        $entityManager->flush();
        return $this->redirectToRoute("main_home");
    }
    #[Route('/removeFriend/{UserIdToRemove}', name: 'main_removeFriend')]
    public function removeFriend(UserRepository $userRepository,EntityManagerInterface $entityManager,$UserIdToRemove)
    {
        $UserConnected = $this->getUser();
        $UserToAdd = $userRepository->find($UserIdToRemove);
        $UserConnected->removeAmi($UserToAdd);

        $entityManager->persist($UserConnected);
        $entityManager->flush();
        return $this->redirectToRoute("main_home");
    }
}