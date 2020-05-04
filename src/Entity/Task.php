<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 *
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"tasksTrueList", "taskEdit"})
     *
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"dashboard"})
     * @Assert\NotBlank()
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"dashboard"})
     * @Assert\Length(
     *     min="5",
     *     minMessage="Le titre doit faire au moins 5 caractères",
     *     max="50",
     *     maxMessage="Le titre ne peut dépasser 50 caractères"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"dashboard"})
     * @Assert\Length(
     *     min="5",
     *     minMessage="La description doit faire au moins 5 caractères",
     *     max="250",
     *     maxMessage="La description ne peut dépasser 250 caractères"
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"dashboard"})
     */
    private $isDone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tasks")
     * @Groups({"dashboard"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIsDone(): ?bool
    {
        return $this->isDone;
    }

    public function setIsDone(?bool $isDone): self
    {
        $this->isDone = $isDone;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
