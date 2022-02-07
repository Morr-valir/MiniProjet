<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207045702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concessionnaire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concessionnaire_marque (concessionnaire_id INT NOT NULL, marque_id INT NOT NULL, INDEX IDX_DF9E5CB18740E698 (concessionnaire_id), INDEX IDX_DF9E5CB14827B9B2 (marque_id), PRIMARY KEY(concessionnaire_id, marque_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concessionnaire_api (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concessionnaire_api_marque (concessionnaire_api_id INT NOT NULL, marque_id INT NOT NULL, INDEX IDX_E6C6C4C4D167F447 (concessionnaire_api_id), INDEX IDX_E6C6C4C44827B9B2 (marque_id), PRIMARY KEY(concessionnaire_api_id, marque_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modele (id INT AUTO_INCREMENT NOT NULL, marque_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_100285584827B9B2 (marque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concessionnaire_marque ADD CONSTRAINT FK_DF9E5CB18740E698 FOREIGN KEY (concessionnaire_id) REFERENCES concessionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concessionnaire_marque ADD CONSTRAINT FK_DF9E5CB14827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concessionnaire_api_marque ADD CONSTRAINT FK_E6C6C4C4D167F447 FOREIGN KEY (concessionnaire_api_id) REFERENCES concessionnaire_api (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concessionnaire_api_marque ADD CONSTRAINT FK_E6C6C4C44827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_100285584827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concessionnaire_marque DROP FOREIGN KEY FK_DF9E5CB18740E698');
        $this->addSql('ALTER TABLE concessionnaire_api_marque DROP FOREIGN KEY FK_E6C6C4C4D167F447');
        $this->addSql('ALTER TABLE concessionnaire_marque DROP FOREIGN KEY FK_DF9E5CB14827B9B2');
        $this->addSql('ALTER TABLE concessionnaire_api_marque DROP FOREIGN KEY FK_E6C6C4C44827B9B2');
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_100285584827B9B2');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE concessionnaire');
        $this->addSql('DROP TABLE concessionnaire_marque');
        $this->addSql('DROP TABLE concessionnaire_api');
        $this->addSql('DROP TABLE concessionnaire_api_marque');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE modele');
    }
}
