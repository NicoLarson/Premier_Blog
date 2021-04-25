<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210504150015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abstract_author (id INT AUTO_INCREMENT NOT NULL, comment_id INT DEFAULT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6DB83AEBF8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE anonymous_author (id INT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE autenticate_author (id INT NOT NULL, account_id INT DEFAULT NULL, INDEX IDX_16214E939B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abstract_author ADD CONSTRAINT FK_6DB83AEBF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE anonymous_author ADD CONSTRAINT FK_B9D7289FBF396750 FOREIGN KEY (id) REFERENCES abstract_author (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE autenticate_author ADD CONSTRAINT FK_16214E939B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE autenticate_author ADD CONSTRAINT FK_16214E93BF396750 FOREIGN KEY (id) REFERENCES abstract_author (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE account DROP comments');
        $this->addSql('ALTER TABLE comment DROP author');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE anonymous_author DROP FOREIGN KEY FK_B9D7289FBF396750');
        $this->addSql('ALTER TABLE autenticate_author DROP FOREIGN KEY FK_16214E93BF396750');
        $this->addSql('DROP TABLE abstract_author');
        $this->addSql('DROP TABLE anonymous_author');
        $this->addSql('DROP TABLE autenticate_author');
        $this->addSql('ALTER TABLE account ADD comments LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:object)\'');
        $this->addSql('ALTER TABLE comment ADD author VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
