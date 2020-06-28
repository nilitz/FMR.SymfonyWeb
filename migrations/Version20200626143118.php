<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200626143118 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE box (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, tool_type_id INT DEFAULT NULL, box_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_B12D4A36D12881D0 (tool_type_id), INDEX IDX_B12D4A36D8177B3F (box_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rent_tool (id INT AUTO_INCREMENT NOT NULL, inventory_id INT NOT NULL, user_id INT NOT NULL, classroom_number INT NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, description LONGTEXT NOT NULL, is_validate TINYINT(1) NOT NULL, is_returned_complete TINYINT(1) NOT NULL, INDEX IDX_5099909A9EEA759 (inventory_id), INDEX IDX_5099909AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tool_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tool_type_box (tool_type_id INT NOT NULL, box_id INT NOT NULL, INDEX IDX_E57FDAFCD12881D0 (tool_type_id), INDEX IDX_E57FDAFCD8177B3F (box_id), PRIMARY KEY(tool_type_id, box_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36D12881D0 FOREIGN KEY (tool_type_id) REFERENCES tool_type (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36D8177B3F FOREIGN KEY (box_id) REFERENCES box (id)');
        $this->addSql('ALTER TABLE rent_tool ADD CONSTRAINT FK_5099909A9EEA759 FOREIGN KEY (inventory_id) REFERENCES inventory (id)');
        $this->addSql('ALTER TABLE rent_tool ADD CONSTRAINT FK_5099909AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tool_type_box ADD CONSTRAINT FK_E57FDAFCD12881D0 FOREIGN KEY (tool_type_id) REFERENCES tool_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tool_type_box ADD CONSTRAINT FK_E57FDAFCD8177B3F FOREIGN KEY (box_id) REFERENCES box (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE machine CHANGE skill_id skill_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36D8177B3F');
        $this->addSql('ALTER TABLE tool_type_box DROP FOREIGN KEY FK_E57FDAFCD8177B3F');
        $this->addSql('ALTER TABLE rent_tool DROP FOREIGN KEY FK_5099909A9EEA759');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36D12881D0');
        $this->addSql('ALTER TABLE tool_type_box DROP FOREIGN KEY FK_E57FDAFCD12881D0');
        $this->addSql('DROP TABLE box');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE rent_tool');
        $this->addSql('DROP TABLE tool_type');
        $this->addSql('DROP TABLE tool_type_box');
        $this->addSql('ALTER TABLE machine CHANGE skill_id skill_id INT DEFAULT NULL');
    }
}
