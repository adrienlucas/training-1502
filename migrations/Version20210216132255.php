<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210216132255 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie ADD COLUMN description VARCHAR(255) NOT NULL DEFAULT ""');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id, title, release_date, genre FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, release_date DATE NOT NULL, genre VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO movie (id, title, release_date, genre) SELECT id, title, release_date, genre FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
    }
}
