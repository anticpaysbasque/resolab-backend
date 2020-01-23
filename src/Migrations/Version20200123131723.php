<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200123131723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE alert ADD created_at DATETIME NOT NULL, ADD users LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE user_id user_id INT DEFAULT NULL, CHANGE post_id post_id INT DEFAULT NULL, CHANGE comment_id comment_id INT DEFAULT NULL, CHANGE story_id story_id INT DEFAULT NULL, CHANGE moderator_id moderator_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE alert DROP created_at, DROP users, CHANGE user_id user_id INT DEFAULT NULL, CHANGE moderator_id moderator_id INT DEFAULT NULL, CHANGE post_id post_id INT DEFAULT NULL, CHANGE comment_id comment_id INT DEFAULT NULL, CHANGE story_id story_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
