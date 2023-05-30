<?php

namespace App\Controller\gestEmploye;
use App\Entity\Contract;
use App\Form\CsvUploadType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CsvController extends AbstractController
{
    #[Route('/RH/empmenu/csv_upload', name: 'csv_upload')]
    public function upload(Request $request,EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(CsvUploadType::class);
        $form->handleRequest($request);
        $file = $request->files->get('csv_file');

        if ($form->isSubmitted() && $form->isValid()) {
            $filePath = $file->getPathname();

            // Process the CSV file and store data in the database
            $data = $this->parseCsvFile($filePath);

            // Store data in the database
            $this->storeDataInDatabase($data,$entityManager);

            // Redirect or display success message
            return $this->render('RH/pages/import.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('RH/pages/import.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //parse csv file into an array
    private function parseCsvFile($file)
    {
        $reader = Reader::createFromPath($file);
        $reader->setHeaderOffset(0); // Assuming the first row contains headers

        $records = $reader->getRecords();

        $data = [];
        foreach ($records as $record) {
            $data[] = $record;
        }

        return $data;
    }

    //add retrieved data from the csv to database
    private function storeDataInDatabase($data,EntityManagerInterface $entityManager)
    {

        foreach ($data as $row) {
            $contract = new Contract();
            $contract->setDateContract($row['datecontract']);
            $contract->setDateEmbauche($row['dateembauche']);
            $contract->setTypeContract($row['type']);
            $contract->setNumContrat($row['num']);

            $entityManager->persist($contract);
        }
        $entityManager->flush();

    }
}