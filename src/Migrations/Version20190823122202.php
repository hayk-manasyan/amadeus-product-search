<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190823122202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE amadeus_auth_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE amadeus_auth (id INT NOT NULL, type VARCHAR(150) NOT NULL, username VARCHAR(150) NOT NULL, application_name VARCHAR(150) NOT NULL, client_id VARCHAR(150) NOT NULL, token_type VARCHAR(100) NOT NULL, access_token VARCHAR(255) NOT NULL, expires_in INT NOT NULL, state VARCHAR(100) NOT NULL, scope VARCHAR(255) DEFAULT NULL, create_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE amadeus_auth_id_seq CASCADE');
        $this->addSql('DROP TABLE amadeus_auth');
    }
}
