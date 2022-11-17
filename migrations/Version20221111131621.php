<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221111131621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producto ADD categorias_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB06155792B277 FOREIGN KEY (categorias_id) REFERENCES categorias (id)');
        $this->addSql('CREATE INDEX IDX_A7BB06155792B277 ON producto (categorias_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB06155792B277');
        $this->addSql('DROP INDEX IDX_A7BB06155792B277 ON producto');
        $this->addSql('ALTER TABLE producto DROP categorias_id');
    }
}
