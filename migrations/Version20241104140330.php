<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241104140330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE description description LONGTEXT DEFAULT NULL, CHANGE avatar avatar VARCHAR(255) DEFAULT NULL, CHANGE emploi emploi VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE site_url site_url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE description description LONGTEXT NOT NULL, CHANGE avatar avatar VARCHAR(255) NOT NULL, CHANGE emploi emploi VARCHAR(255) NOT NULL, CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE site_url site_url VARCHAR(255) NOT NULL');
    }
}
