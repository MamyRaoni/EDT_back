<?php
namespace App\Service;


class AffectationSalleService{

    public function Affectation($salles, $classe, array $schedule){
        $effectif_classe=$classe->getNombreEleve();
        foreach($salles as $salle){
            if(!empty($schedule)){
                foreach($schedule as $edt){
                    if(($edt['salle']!=$salle->getNumero())&&($salle->getCapacite()>=$effectif_classe)){
                        $salledispo=$salle;
                        return $salledispo;
                    }
                }
            }
            if($salle->getCapacite()>=$effectif_classe){
                $salledispo=$salle;
                return $salledispo;
            }
            

        }
        return null;
    }
}