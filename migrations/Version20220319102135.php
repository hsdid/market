<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220319102135 extends AbstractMigration
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
        $this->addSql('ALTER TABLE company RENAME COLUMN address_address1 TO address_address');
        $this->addSql('ALTER TABLE company_photo ALTER photo_id TYPE UUID');
        $this->addSql('ALTER TABLE company_photo ALTER photo_id DROP DEFAULT');
        $this->addSql('ALTER TABLE company_photo ALTER company_id TYPE UUID');
        $this->addSql('ALTER TABLE company_photo ALTER company_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ADD price_minPrice DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE offer ADD price_maxPrice DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE offer ADD address_street VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE offer ADD address_address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE offer ADD address_province VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE offer ADD address_city VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE offer ADD address_postal VARCHAR(255) DEFAULT NULL');
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
        $this->addSql('ALTER TABLE company ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE company ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE company RENAME COLUMN address_address TO address_address1');
        $this->addSql('ALTER TABLE offer DROP price_minPrice');
        $this->addSql('ALTER TABLE offer DROP price_maxPrice');
        $this->addSql('ALTER TABLE offer DROP address_street');
        $this->addSql('ALTER TABLE offer DROP address_address');
        $this->addSql('ALTER TABLE offer DROP address_province');
        $this->addSql('ALTER TABLE offer DROP address_city');
        $this->addSql('ALTER TABLE offer DROP address_postal');
        $this->addSql('ALTER TABLE offer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE offer ALTER user_id DROP DEFAULT');
        $this->addSql('ALTER TABLE company_photo ALTER photo_id TYPE UUID');
        $this->addSql('ALTER TABLE company_photo ALTER photo_id DROP DEFAULT');
        $this->addSql('ALTER TABLE company_photo ALTER company_id TYPE UUID');
        $this->addSql('ALTER TABLE company_photo ALTER company_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER photo_id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer_photo ALTER offer_id TYPE UUID');
        $this->addSql('ALTER TABLE offer_photo ALTER offer_id DROP DEFAULT');
    }
}
