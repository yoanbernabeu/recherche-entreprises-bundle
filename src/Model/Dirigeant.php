<?php

declare(strict_types=1);

namespace YoanBernabeu\RechercheEntreprisesBundle\Model;

class Dirigeant implements \Stringable
{
    public function __construct(
        public readonly ?string $prenoms = null,
        public readonly ?string $nom = null,
        public readonly ?string $siren = null,
        public readonly ?string $denomination = null,
        public readonly ?string $typeDirigeant = null,
        public readonly ?string $dateNaissance = null,
        public readonly ?string $qualite = null
    )
    {
        
    }

    public static function fromArray(array $data): self
    {
        
        return new self(
            prenoms: $data['prenoms'] ?? '',
            nom: $data['nom'] ?? '',
            qualite: $data['qualite'] ?? null,
            denomination: $data['denomination'] ?? null,
            siren: $data['siren'] ?? null,
            dateNaissance: $data['date_de_naissance'] ?? null,
            typeDirigeant: $data['type_dirigeant'] ?? null
        );
    }

    public function isPersonnePhysique(): ?bool
    {
        if ($this->typeDirigeant) {
            return $this->typeDirigeant === 'personne physique';
        }

        return null;
    }

    public function __toString(): string
    {
        if (!$this->denomination) {
            return sprintf('%s%s%s',
                ucwords(mb_strtolower($this->prenoms)),
                $this->prenoms && $this->nom ? ' ' : '',
                $this->nom)
            ;
        }

        return $this->denomination ?? '';
    }
}
