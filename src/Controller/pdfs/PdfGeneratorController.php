<?php

namespace App\Controller\pdfs;

use App\Repository\PersonnelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;


class PdfGeneratorController extends AbstractController
{
    #[Route('/pdf/attestationtravaille', name: 'attestationtravaille')]
    public function index(Request $request,PersonnelRepository $persoRepo): Response
    {
        $idperso=$request->query->get('idperso');
        $persoinfo=$persoRepo->find($idperso);
        // return $this->render('pdf_generator/attestationtravaille.html.twig', [
        //     'controller_name' => 'PdfGeneratorController',
        // ]);
        $data = [
            'nom'         => $persoinfo->getNomPerso(),
            'prenom'      => $persoinfo->getPrenomPerso(),
            'grade' => $persoinfo->getGrade()->getNomGrade(),
            'ppr'        => $persoinfo->getPPR(),
            'cin'=>$persoinfo->getCIN()
        ];
        $html =  $this->renderView('pdf_generator/attestationtravaille.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response (
            $dompdf->stream('attestationtravaille', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }


}
