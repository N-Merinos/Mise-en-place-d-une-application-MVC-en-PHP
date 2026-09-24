<?php

namespace Tests\Repository;

use App\Repository\TrajetRepository;
use Tests\DatabaseTestCase;

class TrajetRepositoryTest extends DatabaseTestCase
{
    private TrajetRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new TrajetRepository();
    }

    private function validTrajetData(array $overrides = []): array
    {
        return array_merge([
            'agenceDepartId'   => $this->agenceParisId,
            'agenceArriveeId'  => $this->agenceLyonId,
            'dateHeureDepart'  => date('Y-m-d H:i:s', strtotime('+2 days')),
            'dateHeureArrivee' => date('Y-m-d H:i:s', strtotime('+2 days +4 hours')),
            'nbPlacesTotal'    => 4,
            'auteurId'         => $this->employeId,
        ], $overrides);
    }

    public function testCreateInsertsTrajetEtRetourneSonId(): void
    {
        $id = $this->repository->create($this->validTrajetData());

        $this->assertGreaterThan(0, $id);

        $trajet = $this->repository->findById($id);
        $this->assertNotNull($trajet);
        $this->assertSame($this->agenceParisId, $trajet->agenceDepartId);
        $this->assertSame($this->agenceLyonId, $trajet->agenceArriveeId);
        $this->assertSame(4, $trajet->nbPlacesTotal);
    }

    public function testCreateInitialisePlacesDisponiblesAuTotal(): void
    {
        // Test de non-régression : la requête d'insertion utilisait par
        // erreur le même paramètre nommé pour nb_places_total et
        // nb_places_dispo, ce qui pouvait faire planter l'insertion.
        $id = $this->repository->create($this->validTrajetData(['nbPlacesTotal' => 6]));

        $trajet = $this->repository->findById($id);

        $this->assertSame(6, $trajet->nbPlacesTotal);
        $this->assertSame(6, $trajet->nbPlacesDispo);
    }

    public function testUpdateModifieLesChampsDuTrajet(): void
    {
        $id = $this->repository->create($this->validTrajetData());

        $this->repository->update($id, [
            'agenceDepartId'   => $this->agenceLyonId,
            'agenceArriveeId'  => $this->agenceParisId,
            'dateHeureDepart'  => date('Y-m-d H:i:s', strtotime('+3 days')),
            'dateHeureArrivee' => date('Y-m-d H:i:s', strtotime('+3 days +5 hours')),
            'nbPlacesTotal'    => 2,
            'nbPlacesDispo'    => 1,
        ]);

        $trajet = $this->repository->findById($id);

        $this->assertSame($this->agenceLyonId, $trajet->agenceDepartId);
        $this->assertSame($this->agenceParisId, $trajet->agenceArriveeId);
        $this->assertSame(2, $trajet->nbPlacesTotal);
        $this->assertSame(1, $trajet->nbPlacesDispo);
    }

    public function testDeleteSupprimeLeTrajet(): void
    {
        $id = $this->repository->create($this->validTrajetData());

        $this->repository->delete($id);

        $this->assertNull($this->repository->findById($id));
    }
}
