<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120123821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team ADD users_id INT DEFAULT NULL, DROP players');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C4E0A61F67B3B43D ON team (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F67B3B43D');
        $this->addSql('DROP INDEX IDX_C4E0A61F67B3B43D ON team');
        $this->addSql('ALTER TABLE team ADD players LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', DROP users_id');
    }
}
