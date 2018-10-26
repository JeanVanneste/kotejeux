<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181026125355 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE editeur DROP nationalite, DROP creation_year');
        $this->addSql('ALTER TABLE jeu CHANGE box_picture box_picture VARCHAR(255) DEFAULT NULL, CHANGE interior_picture interior_picture VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE editeur ADD nationalite VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD creation_year INT DEFAULT NULL');
        $this->addSql('ALTER TABLE jeu CHANGE box_picture box_picture LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE interior_picture interior_picture LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
