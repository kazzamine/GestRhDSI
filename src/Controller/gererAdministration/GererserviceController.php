<?php

namespace App\Controller\gererAdministration;

use App\Entity\Devision;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GererserviceController extends AbstractController
{
    #[Route('/super-admin/gererservice', name: 'gererservice')]
    public function index(Request $request,ServiceRepository $serviceRepo): Response
    {
        $idDev=$request->query->get('idDev');
        $services=$serviceRepo->findBy(['devision'=>$idDev]);
        return $this->render('superadmin/pages/gererservice/services.html.twig', [
            'controller_name' => 'GererserviceController',
            'services'=>$services,
            'idev'=>$idDev,
        ]);
    }
    #[Route('/super-admin/gererservice/deleteservice', name: 'deleteservice')]
    public function deleteservice(Request $request,ServiceRepository $serviceRepo,EntityManagerInterface $entityManager): Response
    {
        $idSer=$request->query->get('idSer');
        $services=$serviceRepo->find($idSer);
        $idev=$services->getDevision()->getId();
        $employes=$services->getPersonnelsSer();
        foreach($employes as $employe){
            $employe->setService(null);
            $entityManager->persist($employe);
            $entityManager->flush();
        }
        $entityManager->remove($services);
        $entityManager->flush();
        return $this->redirectToRoute('gererservice' ,['idDev' => $idev]);

    }

    #[Route('/super-admin/gererservice/addservice', name: 'addservice')]
    public function addService(Request $request,EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $service=new Service();
        $idev=$data['idev'];
        $service->setNomService($data['nomserv']);
        $service->setDescriptionService($data['description']);
        $devision=$entityManager->getRepository(Devision::class)->find($idev);
        $service->setDevision($devision);
        $service->setRespoService(null);
        $entityManager->persist($service);
        $entityManager->flush();
        return $this->redirectToRoute('gererservice' ,['idDev' => $idev]);
    }
}
