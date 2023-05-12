<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230512103818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devision DROP FOREIGN KEY FK_D7B72D6053ED7B05');
        $this->addSql('DROP INDEX IDX_D7B72D6053ED7B05 ON devision');
        $this->addSql('ALTER TABLE devision DROP personnels_dev_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devision ADD personnels_dev_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE devision ADD CONSTRAINT FK_D7B72D6053ED7B05 FOREIGN KEY (personnels_dev_id) REFERENCES personnel (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D7B72D6053ED7B05 ON devision (personnels_dev_id)');
    }
}
