<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220319094600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id UUID NOT NULL, user_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, active BOOLEAN DEFAULT \'true\' NOT NULL, address_street VARCHAR(255) DEFAULT NULL, address_address1 VARCHAR(255) DEFAULT NULL, address_province VARCHAR(255) DEFAULT NULL, address_city VARCHAR(255) DEFAULT NULL, address_postal VARCHAR(255) DEFAULT NULL, dtype VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4FBF094FA76ED395 ON company (user_id)');
        $this->addSql('CREATE UNIQUE INDEX search_idx ON company (name)');
        $this->addSql('CREATE TABLE company_photo (photo_id UUID NOT NULL, company_id UUID DEFAULT NULL, path VARCHAR(255) NOT NULL, mime_type VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, PRIMARY KEY(photo_id))');
        $this->addSql('CREATE INDEX IDX_5346267D979B1AD6 ON company_photo (company_id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_photo ADD CONSTRAINT FK_5346267D979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER user_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo ALTER offer_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER offer_id DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE company_photo DROP CONSTRAINT FK_5346267D979B1AD6');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE company_photo');
        $this->addSql('ALTER TABLE offer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER user_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo ALTER offer_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER offer_id DROP DEFAULT');
    }
}
