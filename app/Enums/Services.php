<?php

namespace App\Enums;

enum Services: string
{
    case Tire_change = "Tire change";
    case Wheel_change = "Wheel change";
    case Wheel_straightening = "Wheel straightening";
    case Tire_repair = "Tire repair";
    case TPMS_service = "TPMS service";
    case Wheel_balancing = "Wheel balancing";


    public function getLabel(): ?string
    {
        return match ($this) {
            self::Wheel_change => "Wymiana Kół",
            self::Tire_change => "Wymiana Opon",
            self::Wheel_straightening => "Prostowanie Felgi",
            self::Tire_repair => "Zalepianie opony po przebiciu",
            self::Wheel_balancing => "Wyważanie kół",
            self::TPMS_service =>"Serwis Czujników Ciśnienia",
        };
    }

}
