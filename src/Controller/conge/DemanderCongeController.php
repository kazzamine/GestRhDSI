<?php

namespace App\Controller\conge;

use App\Entity\Conge;
use App\Entity\TypeConge;
use App\Repository\TypeCongeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;


class DemanderCongeController extends AbstractController
{
    #[Route('/user/demanderconge', name: 'demander_conge')]
    public function index(TypeCongeRepository $typeCongeRepos): Response
    {
        $typeconge=$typeCongeRepos->findAll();

        return $this->render('user/pages/demanderConge.html.twig', [
            'controller_name' => 'DemanderCongeController',
            'typesconge'=>$typeconge,
        ]);
    }

    #[Route('/user/requestConge', name: 'requestConge')]
    public function requestConge(TypeCongeRepository $typeCongeRepos,Request $request,EntityManagerInterface $entityManager): Response
    {
        //retrieve data from ajax
        $data = json_decode($request->getContent(), true);
        $datedubt=DateTimeImmutable::createFromFormat('Y-m-d', $data['dataDebut']);
        $datefin=DateTimeImmutable::createFromFormat('Y-m-d', $data['dateFin']);
        $conge=new Conge();
        $conge->setDateDebutConge($datedubt);
        $conge->setDateFinConge($datefin);

        $typeconge = $entityManager->getRepository(TypeConge::class)->find($data['typeconge']);
        $conge->setTypeConge($typeconge);

        $entityManager->persist($conge);
        $entityManager->flush();

        return $this->render('user/pages/demanderConge.html.twig', [
            'controller_name' => 'DemanderCongeController',
        ]);
    }
}
