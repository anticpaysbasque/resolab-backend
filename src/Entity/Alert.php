<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}}
 * )
 * @ORM\Entity()
 */
class Alert
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read"})
     */
    private $resolved;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read"})
     */
    private $takenCare;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @Groups({"read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"read"})
     */
    private $moderator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post")
     * @Groups({"read"})
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment")
     * @Groups({"read"})
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Story")
     * @Groups({"read"})
     */
    private $story;

    public function __construct()
    {
        $this->resolved = false;
        $this->takenCare = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isResolved(): ?bool
    {
        return $this->resolved;
    }

    public function setResolved(bool $resolved): self
    {
        $this->resolved = $resolved;

        return $this;
    }

    /**
     * @return mixed
     */
    public function isTakenCare()
    {
        return $this->takenCare;
    }

    /**
     * @param mixed $takenCare
     */
    public function setTakenCare($takenCare): void
    {
        $this->takenCare = $takenCare;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getModerator(): ?User
    {
        return $this->moderator;
    }

    public function setModerator(User $moderator): self
    {
        if (in_array('ROLE_MODERATOR', $moderator->getRoles())) {
            $this->moderator = $moderator;
            $this->takenCare = true;
        }

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;
        $this->comment = null;
        $this->story = null;

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        $this->comment = $comment;
        $this->story = null;
        $this->post = null;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * @param mixed $story
     */
    public function setStory($story): void
    {
        $this->story = $story;
        $this->comment = null;
        $this->post = null;
    }
}
