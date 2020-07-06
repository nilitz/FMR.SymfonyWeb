<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200701114843 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE box (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, question LONGTEXT NOT NULL, answer LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, tool_type_id INT DEFAULT NULL, box_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_B12D4A36D12881D0 (tool_type_id), INDEX IDX_B12D4A36D8177B3F (box_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE machine (id INT AUTO_INCREMENT NOT NULL, skill_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, image LONGTEXT DEFAULT NULL, is_rentable TINYINT(1) NOT NULL, max_hours_per_use INT NOT NULL, INDEX IDX_1505DF845585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, user_id INT NOT NULL, ordered_at DATETIME NOT NULL, is_delivered TINYINT(1) NOT NULL, quantity INT NOT NULL, is_accepted TINYINT(1) NOT NULL, is_complete TINYINT(1) NOT NULL, INDEX IDX_F52993984584665A (product_id), INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, max_production INT NOT NULL, max_user INT NOT NULL, image LONGTEXT DEFAULT NULL, description LONGTEXT NOT NULL, production_time INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rent_machine (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, machine_id INT NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, is_validate TINYINT(1) NOT NULL, INDEX IDX_F429A4F4A76ED395 (user_id), INDEX IDX_F429A4F4F6B75B26 (machine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rent_tool (id INT AUTO_INCREMENT NOT NULL, inventory_id INT NOT NULL, user_id INT NOT NULL, classroom_number INT NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, description LONGTEXT NOT NULL, is_validate TINYINT(1) NOT NULL, is_returned_complete TINYINT(1) NOT NULL, INDEX IDX_5099909A9EEA759 (inventory_id), INDEX IDX_5099909AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_user (skill_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_CAD24AFB5585C142 (skill_id), INDEX IDX_CAD24AFBA76ED395 (user_id), PRIMARY KEY(skill_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tool_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tool_type_box (tool_type_id INT NOT NULL, box_id INT NOT NULL, INDEX IDX_E57FDAFCD12881D0 (tool_type_id), INDEX IDX_E57FDAFCD8177B3F (box_id), PRIMARY KEY(tool_type_id, box_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_admin TINYINT(1) NOT NULL, INDEX IDX_8D93D64912469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36D12881D0 FOREIGN KEY (tool_type_id) REFERENCES tool_type (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36D8177B3F FOREIGN KEY (box_id) REFERENCES box (id)');
        $this->addSql('ALTER TABLE machine ADD CONSTRAINT FK_1505DF845585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rent_machine ADD CONSTRAINT FK_F429A4F4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rent_machine ADD CONSTRAINT FK_F429A4F4F6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
        $this->addSql('ALTER TABLE rent_tool ADD CONSTRAINT FK_5099909A9EEA759 FOREIGN KEY (inventory_id) REFERENCES inventory (id)');
        $this->addSql('ALTER TABLE rent_tool ADD CONSTRAINT FK_5099909AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE skill_user ADD CONSTRAINT FK_CAD24AFB5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_user ADD CONSTRAINT FK_CAD24AFBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tool_type_box ADD CONSTRAINT FK_E57FDAFCD12881D0 FOREIGN KEY (tool_type_id) REFERENCES tool_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tool_type_box ADD CONSTRAINT FK_E57FDAFCD8177B3F FOREIGN KEY (box_id) REFERENCES box (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36D8177B3F');
        $this->addSql('ALTER TABLE tool_type_box DROP FOREIGN KEY FK_E57FDAFCD8177B3F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64912469DE2');
        $this->addSql('ALTER TABLE rent_tool DROP FOREIGN KEY FK_5099909A9EEA759');
        $this->addSql('ALTER TABLE rent_machine DROP FOREIGN KEY FK_F429A4F4F6B75B26');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984584665A');
        $this->addSql('ALTER TABLE machine DROP FOREIGN KEY FK_1505DF845585C142');
        $this->addSql('ALTER TABLE skill_user DROP FOREIGN KEY FK_CAD24AFB5585C142');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36D12881D0');
        $this->addSql('ALTER TABLE tool_type_box DROP FOREIGN KEY FK_E57FDAFCD12881D0');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE rent_machine DROP FOREIGN KEY FK_F429A4F4A76ED395');
        $this->addSql('ALTER TABLE rent_tool DROP FOREIGN KEY FK_5099909AA76ED395');
        $this->addSql('ALTER TABLE skill_user DROP FOREIGN KEY FK_CAD24AFBA76ED395');
        $this->addSql('DROP TABLE box');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE machine');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE rent_machine');
        $this->addSql('DROP TABLE rent_tool');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_user');
        $this->addSql('DROP TABLE tool_type');
        $this->addSql('DROP TABLE tool_type_box');
        $this->addSql('DROP TABLE user');
    }
}
