<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211202090829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concessionnaire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concessionnaire_marque (concessionnaire_id INT NOT NULL, marque_id INT NOT NULL, INDEX IDX_DF9E5CB18740E698 (concessionnaire_id), INDEX IDX_DF9E5CB14827B9B2 (marque_id), PRIMARY KEY(concessionnaire_id, marque_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modele (id INT AUTO_INCREMENT NOT NULL, marque_id INT DEFAULT NULL, clients_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_100285584827B9B2 (marque_id), UNIQUE INDEX UNIQ_10028558AB014612 (clients_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concessionnaire_marque ADD CONSTRAINT FK_DF9E5CB18740E698 FOREIGN KEY (concessionnaire_id) REFERENCES concessionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concessionnaire_marque ADD CONSTRAINT FK_DF9E5CB14827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_100285584827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_10028558AB014612 FOREIGN KEY (clients_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_10028558AB014612');
        $this->addSql('ALTER TABLE concessionnaire_marque DROP FOREIGN KEY FK_DF9E5CB18740E698');
        $this->addSql('ALTER TABLE concessionnaire_marque DROP FOREIGN KEY FK_DF9E5CB14827B9B2');
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_100285584827B9B2');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE concessionnaire');
        $this->addSql('DROP TABLE concessionnaire_marque');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE modele');
    }
}
