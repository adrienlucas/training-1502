<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @UniqueEntity("title")
 */
class Movie
{
    public function __construct(
        /**
         * @ORM\Column(type="string", length=255, unique=true)
         * @Assert\Length(min=3)
         */
        public ?string $title = null,

        /**
         * @ORM\Column(type="date")
         */
        public ?DateTime $releaseDate = null,

        /**
         * @ORM\Column(type="string")
         */
        public ?string $description = null,

        /**
         * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="movies")
         * @ORM\JoinColumn(nullable=false)
         */
        public ?Genre $genre = null,

        /**
         * @ORM\Column(type="string", nullable=true)
         */
        public ?string $imdbId = null,

        /**
         * @ORM\ManyToOne(targetEntity=User::class, inversedBy="createdMovies")
         */
        public ?User $creator = null,
    ) {
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public int $id;
}
