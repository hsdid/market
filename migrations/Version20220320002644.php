<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220320002644 extends AbstractMigration
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
        $this->addSql('ALTER TABLE offer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ALTER company_id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER company_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER user_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo DROP CONSTRAINT fk_979af9f153c674ee');
        $this->addSql('DROP INDEX idx_979af9f153c674ee');
        $this->addSql('ALTER TABLE offer_photo ADD id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE offer_photo DROP offer_id');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo ADD CONSTRAINT FK_979AF9F1BF396750 FOREIGN KEY (id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_979AF9F1BF396750 ON offer_photo (id)');
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
        $this->addSql('ALTER TABLE offer_photo DROP CONSTRAINT FK_979AF9F1BF396750');
        $this->addSql('DROP INDEX IDX_979AF9F1BF396750');
        $this->addSql('ALTER TABLE offer_photo ADD offer_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE offer_photo DROP id');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo ADD CONSTRAINT fk_979af9f153c674ee FOREIGN KEY (offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_979af9f153c674ee ON offer_photo (offer_id)');
        $this->addSql('ALTER TABLE offer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ALTER company_id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER company_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER user_id DROP DEFAULT');
    }
}
