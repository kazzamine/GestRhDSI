<?php

namespace App\Controller\gestEmploye;
use App\Entity\CongeJours;
use App\Entity\Contract;
use App\Entity\Devision;
use App\Entity\Direction;
use App\Entity\Grade;
use App\Entity\Login;
use App\Entity\Personnel;
use App\Entity\Service;
use App\Form\CsvUploadType;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
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

            // Read  CSV data into array
            try {
                $csvData = $csv->getRecords();
            } catch (Exception $e) {

            }
            $headers = $csv->getHeader();


            // looping through data of csv
            foreach ($csvData as $row) {
                //checking if personnel exist
                $persoExist=$entityManager->getRepository(Personnel::class)->findBy(['CIN'=>$row['cin']]);
                if($persoExist!=null){
                    continue;
                }
                //inserting into contract
                $contract = new Contract();
                $datecontract = DateTimeImmutable::createFromFormat('Y-m-d', $row['datecontract']);
                $contract->setDateContract($datecontract);
                $dateembauche= DateTimeImmutable::createFromFormat('Y-m-d', $row['dateembauche']);
                $contract->setDateEmbauche($dateembauche);
                $contract->setTypeContract($row['type']);
                $contract->setNumContrat($row['numcontract']);

                $entityManager->persist($contract);
                $entityManager->flush();
                //inserting in personnel
                $contractid=$contract->getId();

                $perso=new Personnel();
                $perso->setNomPerso($row['nom']);
                $perso->setPrenomPerso($row['prenom']);
                $perso->setNomArabic($row['nom arabic']);
                $perso->setCIN($row['cin']);
                $perso->setPPR($row['ppr']);
                $datenaiss = DateTimeImmutable::createFromFormat('Y-m-d', $row['datenaiss']);
                $perso->setDateNaiss($datenaiss);
                $perso->setAdresse($row['adresse']);
                $perso->setTelephone($row['telephone']);
                $perso->setMail($row['mail']);
                $direction=$entityManager->getRepository(Direction::class)->find(1);
                $perso->setDirection($direction);

                $grade = $entityManager->getRepository(Grade::class)->findBy(['nom_grade'=>$row['grade']]);
                $perso->setGrade($grade[0]);
                $devision=$entityManager->getRepository(Devision::class)->findBy(['nom_devision'=>$row['devision']]);
                $service=$entityManager->getRepository(Service::class)->findBy(['nom_service'=>$row['service']]);
                $perso->setService($service[0]);
                $perso->setDevision($devision[0]);

                $perso->setSexe($row['sexe']);

                $contract = $entityManager->getRepository(Contract::class)->find($contractid);
                $perso->setContract($contract);

                $entityManager->persist($perso);
                $entityManager->flush();
                $idperso=$perso->getId();
                //inserting into login
                $loginObj=new Login();
                $loginObj->setEmail($row['mail']);
                // Encode the password
                $factory = new PasswordHasherFactory([
                    'common' => ['algorithm' => 'bcrypt']
                ]);
                $passwordHasher = $factory->getPasswordHasher('common');

                $loginObj->setPassword( $passwordHasher->hash($row['ppr']));
                $loginObj->setRoles(['1'=>'ROLE_USER']);
                $entityManager->persist($loginObj);
                $entityManager->flush();
                //inserting conge days
                $congeObj=new CongeJours();

                $personnel = $entityManager->getRepository(Personnel::class)->find($idperso);

                $congeObj->setPersonnelcin($personnel);
                $congeObj->setNombreCongeNormal(22);
                $congeObj->setNombreCongeExcep(10);

                $entityManager->persist($congeObj);
                $entityManager->flush();
            }


            // Redirect or display success message
            return $this->render('RH/pages/import.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('RH/pages/import.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}