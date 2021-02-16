<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Movie
{
    public function __construct(
        /**
         * @ORM\Column(type="string", length=255)
         */
        public string $title,

        /**
         * @ORM\Column(type="date")
         */
        public DateTime $releaseDate,

        /**
         * @ORM\Column(type="string")
         */
        public string $description,

        /**
         * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="movies")
         * @ORM\JoinColumn(nullable=false)
         */
        public Genre $genre,
    ) {
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public int $id;

}
