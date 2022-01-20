<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220120054526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE concessionnaire_api (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concessionnaire_api_marque (concessionnaire_api_id INT NOT NULL, marque_id INT NOT NULL, INDEX IDX_E6C6C4C4D167F447 (concessionnaire_api_id), INDEX IDX_E6C6C4C44827B9B2 (marque_id), PRIMARY KEY(concessionnaire_api_id, marque_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concessionnaire_api_marque ADD CONSTRAINT FK_E6C6C4C4D167F447 FOREIGN KEY (concessionnaire_api_id) REFERENCES concessionnaire_api (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concessionnaire_api_marque ADD CONSTRAINT FK_E6C6C4C44827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concessionnaire_api_marque DROP FOREIGN KEY FK_E6C6C4C4D167F447');
        $this->addSql('DROP TABLE concessionnaire_api');
        $this->addSql('DROP TABLE concessionnaire_api_marque');
    }
}
