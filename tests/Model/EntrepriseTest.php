<?php

namespace YoanBernabeu\RechercheEntreprisesBundle\Tests;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\RechercheEntreprisesBundle\Model\Entreprise;

class EntrepriseTest extends TestCase
{
    public function testEntrepriseWithoutComplement(): void
    {
        $response = [
            'siren' => '123456789',
            'nom_complet' => 'TEST ENTREPRISE',
            'siege' => [
                'siret' => '12345678900001',
                'adresse' => '1 RUE DE TEST',
            ],
        ];
        $entreprise = Entreprise::fromArray($response);

        $this->assertNull($entreprise->estAssociation);
    }

    public function testEntrepriseWithComplementButWithoutEstAssociation():void
    {
        $response = [
            'siren' => '123456789',
            'nom_complet' => 'TEST ENTREPRISE',
            'siege' => [
                'siret' => '12345678900001',
                'adresse' => '1 RUE DE TEST',
            ],
            'complements' => [
                'est_alim_confiance' => true
            ]
        ];
        $entreprise = Entreprise::fromArray($response);

        $this->assertNull($entreprise->estAssociation);
    }

    public function testEntrepriseWithComplementAndEstAssociation(): void
    {
        $response = [
            'siren' => '123456789',
            'nom_complet' => 'TEST ENTREPRISE',
            'siege' => [
                'siret' => '12345678900001',
                'adresse' => '1 RUE DE TEST',
            ],
            'complements' => [
                'est_alim_confiance' => true,
                'est_association' => true
            ]
        ];

        $entreprise = Entreprise::fromArray($response);

        $this->assertTrue($entreprise->estAssociation);
    }


}
