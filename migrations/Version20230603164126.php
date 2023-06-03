<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230603164126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devision ADD responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE devision ADD CONSTRAINT FK_D7B72D6053C59D72 FOREIGN KEY (responsable_id) REFERENCES personnel (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7B72D6053C59D72 ON devision (responsable_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devision DROP FOREIGN KEY FK_D7B72D6053C59D72');
        $this->addSql('DROP INDEX UNIQ_D7B72D6053C59D72 ON devision');
        $this->addSql('ALTER TABLE devision DROP responsable_id');
    }
}
