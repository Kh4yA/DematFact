<?php

namespace App\Enum;

enum EnumTypeDevis: string
{
    case BROUILLON = 'Brouillon';
    case VALIDE = 'Validé';
    case ANNULE = 'Annulé';
    case EN_ATTENTE = 'En attente';


    public function getLabel(): string
    {
        return match ($this) {
            self::BROUILLON => 'Brouillon',
            self::VALIDE => 'Validé',
            self::ANNULE => 'Annulé',
            self::EN_ATTENTE => 'En attente',
        };
    }
}
