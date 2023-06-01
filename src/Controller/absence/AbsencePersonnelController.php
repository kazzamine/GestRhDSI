<?php

namespace App\Controller\absence;

use App\Repository\AbsenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use DateTimeImmutable;
class AbsencePersonnelController extends AbstractController
{
    #[Route('/RH/absence/personnelAbsence', name: 'absencePersonnel')]
    public function index(Request $request,AbsenceRepository $absenceRepo): Response
    {
        //get ppr of selected employe
        $empId=$request->query->get('idperso');

        $absencePers=$absenceRepo->findByEmployeAbsence($empId);

        return $this->render('RH/pages/absencePersonnel.html.twig', [
            'controller_name' => 'AbsencePersonnelController',
            'absences'=>$absencePers,
            'empid'=>$empId
        ]);
    }

    #[Route('/RH/absence/personnelAbsence/addcert', name: 'addcertificat')]
    public function ajouterCertificat(Request $request,AbsenceRepository $absenceRepo,UrlGeneratorInterface $urlGenerator)
    {
        $data = json_decode($request->getContent(), true);

        $datedebutCert = DateTimeImmutable::createFromFormat('Y-m-d', '2023/06/01');
        $datefinCert = DateTimeImmutable::createFromFormat('Y-m-d', $data['datefinCert']);

        $absenceRepo->updateJustification($data['empid'],$datedebutCert,$datefinCert,$data['justification']);

        $currentRoute = $request->attributes->get('_route');
        // Redirect to the current route
        $response = new RedirectResponse($urlGenerator->generate($currentRoute));

        return $response;
    }
}
