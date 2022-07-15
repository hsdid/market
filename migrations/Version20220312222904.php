<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220312222904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER user_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo ADD path VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE offer_photo ADD mime_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE offer_photo ADD original_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo ALTER offer_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER offer_id DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE offer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER user_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo DROP path');
        $this->addSql('ALTER TABLE offer_photo DROP mime_type');
        $this->addSql('ALTER TABLE offer_photo DROP original_name');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo ALTER offer_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER offer_id DROP DEFAULT');
    }
}
