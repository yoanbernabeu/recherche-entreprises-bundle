<?php

declare(strict_types=1);

namespace YoanBernabeu\RechercheEntreprisesBundle\Model;

class Siege
{
    public function __construct(
        public readonly string $siret,
        public readonly string $adresse,
        public readonly ?string $codePostal = null,
        public readonly ?string $commune = null,
        public readonly ?string $etatAdministratif = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            siret: $data['siret'] ?? '',
            adresse: $data['adresse'] ?? '',
            codePostal: $data['code_postal'] ?? null,
            commune: $data['commune'] ?? null,
            etatAdministratif: $data['etat_administratif'] ?? null,
        );
    }

    public function isActif(): bool
    {
        return $this->etatAdministratif === 'A';
    }
}
