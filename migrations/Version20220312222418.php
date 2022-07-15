<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220312222418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offer_photo (photo_id UUID NOT NULL, offer_id UUID DEFAULT NULL, PRIMARY KEY(photo_id))');
        $this->addSql('CREATE INDEX IDX_979AF9F153C674EE ON offer_photo (offer_id)');
        $this->addSql('ALTER TABLE offer_photo ADD CONSTRAINT FK_979AF9F153C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER user_id DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE offer_photo');
        $this->addSql('ALTER TABLE offer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER user_id DROP DEFAULT');
    }
}
