<?php
namespace App\Service;


class AffectationSalleService{

    public function Affectation($salles, $classe, array $tablEdt){
         
        $effectif_classe=$classe->getNombreEleve();
        foreach($salles as $salle){
            switch ($classe->getLibelleClasse()) {
                case 'L1 IG':
                    // Traitement spécifique pour la classe CP
                    $salledispo=$salle;
                    break;
                case 'L1 PRO':
                    // Traitement spécifique pour la classe CE1
                    break;
                case 'L2 IG':
                    // Traitement spécifique pour la classe CE2
                    break;
                case 'L3 IG':
                    // Traitement spécifique pour la classe CM1
                    break;
                case 'L3 SR':
                    // Traitement spécifique pour la classe CM2
                    break;
                case 'L2 GB':
                    // Traitement spécifique pour la classe 6ème
                    break;
                case 'M1 GB':
                    // Traitement spécifique pour la classe 5ème
                    break;
                case 'M1 SR':
                    // Traitement spécifique pour la classe 4ème
                    break;
                default:
                    // Traitement par défaut si la classe ne correspond à aucun des cas ci-dessus
                    break;
            }
        }
        
        // foreach($salles as $salle){
        //     if(!empty($tablEdt)){
        //         foreach($tablEdt as $edt){
        //             foreach($edt->getTableau() as $edtSalle){
        //                 dump($edtSalle);
        //                 if((($edtSalle['salle']->getNumero()!=$salle->getNumero()))&&(($salle->getCapacite()>=$effectif_classe))){
        //                     $salledispo=$salle;
        //                     return $salledispo;
        //                 }
        //             }
                    
        //         }
        //     }
        // }
        // if(empty($tablEdt)){
        //     foreach($salles as $salle){
        //         if($salle->getCapacite()>=$effectif_classe){
        //             $salledispo=$salle;
        //             return $salledispo;
        //         }
        //     }
            
        // }
        
    }
}