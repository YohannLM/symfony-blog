<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('slug', message: 'Ce slug existe déjà')]
class Post
{

	const STATES = ['STATE_DRAFT', 'STATE_PUBLISHED'];
	
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $content = null;
	
	#[ORM\Column(length: 100)]
	private ?string $state = Post::STATES[0];

    #[ORM\Column]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $updated_at = null;
	
	/**
	 * @param \DateTimeImmutable $created_at
	 * @param \DateTimeImmutable $updated_at
	 */
	public function __construct( \DateTimeImmutable $created_at = new \DateTimeImmutable() , \DateTimeImmutable $updated_at = new \DateTimeImmutable()) {
		
		$this->created_at = $created_at;
		$this->updated_at = $updated_at;
	}
	
	#[ORM\PrePersist]
	public function prePersist() {
		$this->slug = (new Slugify())->slugify($this->title);
	}
	
	#[ORM\PreUpdate]
	public function preUpdate() {
		$this->updated_at = new \DateTimeImmutable();
	}
	
	
	public function getId(): ?int
   {
       return $this->id;
   }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

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


    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
	
	/**
	 * @return string
	 */
	public function __toString(): string {
		return $this->title;
	}

}
