<?php

namespace App\Enum;

enum EnumType: string
{
    case PARTICULIER = 'Particulier';
    case ENTREPRISE = 'Entreprise';


    public function getLabel(): string
    {
        return match ($this) {
            self::PARTICULIER => 'Particulier',
            self::ENTREPRISE => 'Entreprise',
        };
    }
}
