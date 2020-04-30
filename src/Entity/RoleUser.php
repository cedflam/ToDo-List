<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleUserRepository")
 */
class RoleUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     */
    private $addRole = [];

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getAddRole(): array
    {
        $roles = $this->addRole;


        return array_unique($roles);
    }

    public function setAddRole(array $addRole): self
    {
        $this->addRole = $addRole;

        return $this;
    }
}
