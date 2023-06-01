<?php

namespace App\Controller\gestEmploye;
use App\Entity\Contract;
use App\Form\CsvUploadType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use League\Csv\Reader;
use DateTimeImmutable;


class CsvController extends AbstractController
{
    #[Route('/RH/empmenu/csv_upload', name: 'csv_upload')]
    public function upload(Request $request,EntityManagerInterface $entityManager)
    {

        $form = $this->createForm(CSVUploadType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the uploaded file
            $file = $form->get('file')->getData();

            // Create a CSV reader instance
            $csv = Reader::createFromPath($file->getPathname());
            $csv->setHeaderOffset(0);

            // Read the CSV data
            $csvData = $csv->getRecords();
            $headers = $csv->getHeader();


            // Perform any necessary actions with the CSV data
            foreach ($csvData as $row) {
                // Process each row of the CSV data
                // Example: Store data in the database or perform calculations
                $contract = new Contract();
                $datecontract = DateTimeImmutable::createFromFormat('Y-m-d', $row['datecontract']);
                $contract->setDateContract($datecontract);
                $dateembauche= DateTimeImmutable::createFromFormat('Y-m-d', $row['dateembauche']);
                $contract->setDateEmbauche($dateembauche);
                $contract->setTypeContract($row['type']);
                $contract->setNumContrat($row['num']);

                $entityManager->persist($contract);
            }
            $entityManager->flush();

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