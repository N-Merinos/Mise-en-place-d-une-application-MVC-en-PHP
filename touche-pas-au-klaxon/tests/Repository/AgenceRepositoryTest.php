<?php

namespace Tests\Repository;

use App\Repository\AgenceRepository;
use Tests\DatabaseTestCase;

class AgenceRepositoryTest extends DatabaseTestCase
{
    private AgenceRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new AgenceRepository();
    }

    public function testCreateInsereUneNouvelleAgence(): void
    {
        $id = $this->repository->create('Rennes-' . uniqid());

        $agence = $this->repository->findById($id);

        $this->assertNotNull($agence);
        $this->assertGreaterThan(0, $id);
    }

    public function testUpdateModifieLeNom(): void
    {
        $id = $this->repository->create('Bordeaux-' . uniqid());
        $nouveauNom = 'Bordeaux-modifie-' . uniqid();

        $this->repository->update($id, $nouveauNom);

        $agence = $this->repository->findById($id);
        $this->assertSame($nouveauNom, $agence['nom']);
    }

    public function testDeleteSupprimeLAgence(): void
    {
        $id = $this->repository->create('Lille-' . uniqid());

        $this->repository->delete($id);

        $this->assertNull($this->repository->findById($id));
    }

    public function testDeleteEchoueSiLAgenceEstUtiliseeParUnTrajet(): void
    {
        // L'agence de test ($this->agenceParisId, créée dans DatabaseTestCase)
        // est utilisée par un trajet créé ci-dessous : la contrainte de clé
        // étrangère (ON DELETE RESTRICT) doit empêcher sa suppression.
        $trajetRepository = new \App\Repository\TrajetRepository();
        $trajetRepository->create([
            'agenceDepartId'   => $this->agenceParisId,
            'agenceArriveeId'  => $this->agenceLyonId,
            'dateHeureDepart'  => date('Y-m-d H:i:s', strtotime('+1 day')),
            'dateHeureArrivee' => date('Y-m-d H:i:s', strtotime('+1 day +2 hours')),
            'nbPlacesTotal'    => 3,
            'auteurId'         => $this->employeId,
        ]);

        $this->expectException(\PDOException::class);
        $this->repository->delete($this->agenceParisId);
    }
}
