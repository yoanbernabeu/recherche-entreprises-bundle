<?php 

namespace YoanBernabeu\RechercheEntreprisesBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\RechercheEntreprisesBundle\Model\Dirigeant;

class DirigeantsTest extends TestCase
{
    public function testDirigeantWithoutInformationOfTypeDirigeant(): void
    {
        $data = [];

        $dirigeants = Dirigeant::fromArray($data);

        $this->assertNull($dirigeants->isPersonnePhysique());
    }

    public function testDirigeantWithInformationOfTypeDirigeant(): void
    {
        $data = [
            'type_dirigeant' => 'personne physique'
        ];
        
        $dirigeants = Dirigeant::fromArray($data);

        $this->assertTrue($dirigeants->isPersonnePhysique());
    }

    public function testDirigeantWithInformationOfTypeDirigeantMoral(): void
    {
        $data = [
            'type_dirigeant' => 'personne morale'
        ];
        
        $dirigeants = Dirigeant::fromArray($data);

        $this->assertFalse($dirigeants->isPersonnePhysique());
    }

    public function testDirigeantWithInformationOfTypeDirigeantAutreDonnee(): void
    {
        $data = [
            'type_dirigeant' => 'personne peu importe'
        ];
        
        $dirigeants = Dirigeant::fromArray($data);

        $this->assertFalse($dirigeants->isPersonnePhysique());
    }

    public function testToStringDirigeantWithDenomination(): void
    {
        $data = [
            'denomination' => 'Un nom de structure'
        ];
        
        $dirigeants = Dirigeant::fromArray($data);

        $this->assertEquals($dirigeants->__toString(), 'Un nom de structure');
    }

    public function testToStringDirigeantWithNomAndDenominationWithoutPrenoms():void
    {
        $data = [
            'nom' => 'UN NOM',
            'denomination' => 'YOUPI'
        ];

        $dirigeants = Dirigeant::fromArray($data);

        $this->assertEquals($dirigeants->__toString(), 'YOUPI');
    }

    public function testToStringDirigeantWithPrenomsAndDenominationWithoutNom():void
    {
        $data = [
            'prenoms' => 'UN PRENOM',
            'denomination' => 'YOUPI'
        ];

        $dirigeants = Dirigeant::fromArray($data);

        $this->assertEquals($dirigeants->__toString(), 'YOUPI');
    }

    public function testToStringDirigeantWithNoDenominationAndNom():void
    {
        $data = [
            'prenoms' => 'UN PRÉNOM',
        ];

        $dirigeants = Dirigeant::fromArray($data);

        $this->assertEquals($dirigeants->__toString(), 'Un Prénom');
    }

    public function testToStringDirigeantWithNoDenominationAndPrenom():void
    {
        $data = [
            'nom' => 'UN NOM',
        ];

        $dirigeants = Dirigeant::fromArray($data);

        $this->assertEquals($dirigeants->__toString(), 'UN NOM');
    }

    public function testToStringDirigeantWithNothing():void
    {
        $data = [];
        
        $dirigeants = Dirigeant::fromArray($data);

        $this->assertEquals($dirigeants->__toString(), '');
    }
    
}