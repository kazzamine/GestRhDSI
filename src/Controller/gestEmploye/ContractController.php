<?php

namespace App\Controller\gestEmploye;

use App\Entity\Contract;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;

class ContractController extends AbstractController
{
    #[Route('/admin/contract', name: 'app_contract')]
    public function index(): Response
    {
        return $this->render('contract/index.html.twig', [
            'controller_name' => 'ContractController',
        ]);
    }

    #[Route('/admin/empMenu/addEmp/addContract', name: 'addContract')]
    public function addContract(Request $request,EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $contractObj=new Contract();
        $dateembaushe = DateTimeImmutable::createFromFormat('Y-m-d', $data['dateEmbauche']);
        $datecontract = DateTimeImmutable::createFromFormat('Y-m-d', $data['datecontract']);
        $contractObj->setDateContract($datecontract);
        $contractObj->setDateEmbauche($dateembaushe);
        $contractObj->setTypeContract($data['typeContract']);
        $contractObj->setNumContrat($data['numcontract']);

        $entityManager->persist($contractObj);
        $entityManager->flush();
        return new Response($contractObj->getId());
    }
}
