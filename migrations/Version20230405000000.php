<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230405000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Deployment Frequency domain tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS deployments (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', deployment_time DATETIME DEFAULT NULL, repository_name VARCHAR(255) NOT NULL, release_id VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, release_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS deployments');
    }
}