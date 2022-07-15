<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220319103618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE company ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE company_photo ALTER photo_id TYPE UUID');
        $this->addSql('ALTER TABLE company_photo ALTER photo_id DROP DEFAULT');
        $this->addSql('ALTER TABLE company_photo ALTER company_id TYPE UUID');
        $this->addSql('ALTER TABLE company_photo ALTER company_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ADD company_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE offer DROP company');
        $this->addSql('ALTER TABLE offer DROP location');
        $this->addSql('ALTER TABLE offer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER user_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_29D6873E979B1AD6 ON offer (company_id)');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo ALTER offer_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER offer_id DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE company ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE company ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE company_photo ALTER photo_id TYPE UUID');
        $this->addSql('ALTER TABLE company_photo ALTER photo_id DROP DEFAULT');
        $this->addSql('ALTER TABLE company_photo ALTER company_id TYPE UUID');
        $this->addSql('ALTER TABLE company_photo ALTER company_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo ALTER offer_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER offer_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer DROP CONSTRAINT FK_29D6873E979B1AD6');
        $this->addSql('DROP INDEX IDX_29D6873E979B1AD6');
        $this->addSql('ALTER TABLE offer ADD company VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE offer ADD location VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE offer DROP company_id');
        $this->addSql('ALTER TABLE offer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER user_id DROP DEFAULT');
    }
}
