<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210504163856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE authenticate_author (id INT NOT NULL, account_id INT DEFAULT NULL, INDEX IDX_F4F4FFDE9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE authenticate_author ADD CONSTRAINT FK_F4F4FFDE9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE authenticate_author ADD CONSTRAINT FK_F4F4FFDEBF396750 FOREIGN KEY (id) REFERENCES abstract_author (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE autenticate_author');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE autenticate_author (id INT NOT NULL, account_id INT DEFAULT NULL, INDEX IDX_16214E939B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE autenticate_author ADD CONSTRAINT FK_16214E939B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE autenticate_author ADD CONSTRAINT FK_16214E93BF396750 FOREIGN KEY (id) REFERENCES abstract_author (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE authenticate_author');
    }
}
