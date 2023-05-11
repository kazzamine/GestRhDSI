<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230511171615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnel DROP INDEX IDX_A6BCF3DEFE19A1A8, ADD UNIQUE INDEX UNIQ_A6BCF3DEFE19A1A8 (grade_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnel DROP INDEX UNIQ_A6BCF3DEFE19A1A8, ADD INDEX IDX_A6BCF3DEFE19A1A8 (grade_id)');
    }
}
