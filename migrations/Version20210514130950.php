<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210514130950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abstract_author DROP FOREIGN KEY FK_6DB83AEBF8697D13');
        $this->addSql('ALTER TABLE abstract_author ADD CONSTRAINT FK_6DB83AEBF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abstract_author DROP FOREIGN KEY FK_6DB83AEBF8697D13');
        $this->addSql('ALTER TABLE abstract_author ADD CONSTRAINT FK_6DB83AEBF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
    }
}
