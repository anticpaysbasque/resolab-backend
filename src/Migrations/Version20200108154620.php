<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200108154620 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD class_room_id INT DEFAULT NULL, ADD is_restricted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499162176F FOREIGN KEY (class_room_id) REFERENCES class_room (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6499162176F ON user (class_room_id)');
        $this->addSql('ALTER TABLE story ADD image_id INT DEFAULT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB5604383DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB560438A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_EB5604383DA5256D ON story (image_id)');
        $this->addSql('CREATE INDEX IDX_EB560438A76ED395 ON story (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        //$this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB5604383DA5256D');
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB560438A76ED395');
        $this->addSql('DROP INDEX IDX_EB5604383DA5256D ON story');
        $this->addSql('DROP INDEX IDX_EB560438A76ED395 ON story');
        $this->addSql('ALTER TABLE story DROP image_id, DROP user_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499162176F');
        $this->addSql('DROP INDEX IDX_8D93D6499162176F ON user');
        $this->addSql('ALTER TABLE user DROP class_room_id, DROP is_restricted');
    }
}
