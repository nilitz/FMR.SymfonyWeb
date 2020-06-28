<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200626141453 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rent_machine (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, machine_id INT NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, is_validate TINYINT(1) NOT NULL, INDEX IDX_F429A4F4A76ED395 (user_id), INDEX IDX_F429A4F4F6B75B26 (machine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rent_machine ADD CONSTRAINT FK_F429A4F4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rent_machine ADD CONSTRAINT FK_F429A4F4F6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
        $this->addSql('ALTER TABLE machine CHANGE skill_id skill_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE rent_machine');
        $this->addSql('ALTER TABLE machine CHANGE skill_id skill_id INT DEFAULT NULL');
    }
}
