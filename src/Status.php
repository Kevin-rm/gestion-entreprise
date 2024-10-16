<?php

namespace App;

enum Status: string
{
    case APPROUVEE = "Approuvée";
    case REJETEE   = "Rejetée";
    case EN_COURS  = "En cours";
}
