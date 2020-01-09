<?php

namespace App\Entity;

use \DateTime;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read_like"}}
 * )
 * @ORM\Entity()
 * @ApiFilter(SearchFilter::class, properties={
 *     "post.id": "exact",
 *     "comment.id": "exact",
 *     "user.id": "exact",
 * })
 */
class Likes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read_like", "read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="likes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_like", "read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="likes")
     * @Groups({"read_like"})
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment", inversedBy="likes")
     * @Groups({"read_like"})
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read_like"})
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        if ($post instanceof Post) {
            $this->post = $post;
            $this->comment = null;
        }

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        if ($comment instanceof Comment) {
            $this->comment = $comment;
            $this->post = null;
        }

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        return $this->createdAt=$createdAt;

    }
}
