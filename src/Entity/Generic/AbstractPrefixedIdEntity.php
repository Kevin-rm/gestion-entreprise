<?php

namespace App\Entity\Generic;

use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class AbstractPrefixedIdEntity
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: PrefixedIdGenerator::class)]
    protected string $id;

    public function getId(): string
    {
        return $this->id;
    }

    abstract function getPrefix(): string;

    abstract function getSequenceName(): string;
}
