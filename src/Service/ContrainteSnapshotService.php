<?php
namespace App\Service;


use App\Entity\Contraintes;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
class ContrainteSnapshotService
{
    private $entityManager;
    private $filesystem;
    private $snapshotFilePath;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->filesystem = new Filesystem();
        $this->snapshotFilePath =dirname(__DIR__, 2) . '/var/snapshots/contraintes_snapshot.json';

    }

    // Exporter les contraintes en JSON
    public function exportContraintes(): void
    {
        $repository = $this->entityManager->getRepository(Contraintes::class);
        $contraintes = $repository->findAll();
        
        if($this->filesystem->exists($this->snapshotFilePath)){
            return;
        }
            $data = array_map(function(Contraintes $contrainte) {
                return [
                    'prof_id' => $contrainte->getProfesseur()->getId(),
                    'disponibilite' => $contrainte->getDisponibilite(),
                    'jour' => $contrainte->getJour(),
                    // Ajoutez d'autres champs si nécessaire
                ];
            }, $contraintes);
    
            // Sauvegarder les données en JSON
            $jsonData = json_encode($data, JSON_PRETTY_PRINT);
            $this->filesystem->dumpFile($this->snapshotFilePath, $jsonData);
        
        // Convertir les contraintes en tableau associatif
        
    }

    // Restaurer les contraintes depuis le fichier JSON
    public function importContraintes(ProfesseurRepository $professeurRepository): void
    {
        // Lire le fichier JSON
        if (!$this->filesystem->exists($this->snapshotFilePath)) {
            throw new \Exception("Le fichier snapshot n'existe pas.");
        }

        $jsonData = file_get_contents($this->snapshotFilePath);
        $data = json_decode($jsonData, true);

        // Supprimer les contraintes existantes dans la base de données
        $connection = $this->entityManager->getConnection();
        $connection->executeStatement('DELETE FROM contraintes');

        // Réinsérer les contraintes depuis le snapshot
        foreach ($data as $item) {
            /*erreur sur le format de la date il cherche une type Date TimeInterface */
            $contrainte = new Contraintes();
            $prof=$professeurRepository->find($item['prof_id']);
            $contrainte->setProfesseur($prof);
            $contrainte->setDisponibilite($item['disponibilite']);
            $contrainte->setJour($item['jour']);
            // Ajoutez d'autres champs si nécessaire

            $this->entityManager->persist($contrainte);
        }

        $this->entityManager->flush();
        $this->filesystem->remove($this->snapshotFilePath);

    }
}
