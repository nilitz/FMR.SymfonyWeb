<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200629153945 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory CHANGE tool_type_id tool_type_id INT DEFAULT NULL, CHANGE box_id box_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE machine CHANGE skill_id skill_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory CHANGE tool_type_id tool_type_id INT DEFAULT NULL, CHANGE box_id box_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE machine CHANGE skill_id skill_id INT DEFAULT NULL');
    }
}
