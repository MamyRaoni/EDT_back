<?php

namespace App\Service;

use App\Repository\ContrainteRepository;
use Doctrine\ORM\EntityManagerInterface;

class AddContrainteService{
    public function fetchContrainte($schedule, ContrainteRepository $contrainteRepository, EntityManagerInterface $em)
    {
        if (empty($schedule)) {
            return null;
        }else{
            foreach ($schedule as $horaire) {
            $contrainte = $contrainteRepository->findOneBy([
                'professeur' => $horaire['prof_id'],
                'jour' => new \DateTime($horaire['jour']),
            ]);
            if ($contrainte) {
                    $disponibilites = $contrainte->getDisponibilite();
                }
            //dump($disponibilites);
            if(is_array($disponibilites)){
                switch ($horaire['heure_debut']) {
                    case '07:30':
                        $disponibilites[0]=false;
                        // Traitement pour 7h30
                        break;
                    case '09:00':
                        // Traitement pour 9h00
                        $disponibilites[1]=false;
                        break;
                    case '10:30':
                        // Traitement pour 10h30
                        $disponibilites[2]=false;
                        break;
                    case '13:30':
                        // Traitement pour 13h30
                        $disponibilites[3]=false;
                        break;
                    case '15:00':
                        // Traitement pour 15h00
                        $disponibilites[4]=false;
                        break;
                    case '16:30':
                        // Traitement pour 16h30
                        $disponibilites[5]=false;
                        break;
                    
                }
                $contrainte->setDisponibilite($disponibilites);
                $em->persist($contrainte);
                $em->flush();
            }
                
            }
            //return $contrainte;
            return null;
        }
        
    }
}