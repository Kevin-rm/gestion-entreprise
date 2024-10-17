<?php

namespace App\Enum;

enum StatusValidation: string
{
    case APPROUVEE = "Approuvée";
    case REJETEE   = "Rejetée";
    case ATTENTE   = "Attente";
}
