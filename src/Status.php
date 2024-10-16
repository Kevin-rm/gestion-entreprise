<?php

namespace App;

enum Status: string
{
    case APPROUVEE = "Approuvée";
    case REJETEE   = "Rejetée";
    case ATTENTE   = "Attente";
}
