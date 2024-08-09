<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240809202001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE biometric (id INT AUTO_INCREMENT NOT NULL, company VARCHAR(20) NOT NULL, name VARCHAR(50) DEFAULT NULL, cod_nomina VARCHAR(10) NOT NULL, date DATETIME NOT NULL, in_hour TIME DEFAULT NULL, out_hour TIME DEFAULT NULL, cc INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(90) NOT NULL, cc INT NOT NULL, id_employee_id INT NOT NULL, INDEX IDX_5D9F75A194113CAB (id_employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE job_title (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, cod_job_title_id INT DEFAULT NULL, INDEX IDX_2A6AC51B4702F281 (cod_job_title_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nomina (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, fortnight SMALLINT NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE operador (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, linea VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, time_start TIME NOT NULL, time_end TIME NOT NULL, time_2_start TIME NOT NULL, time_2_end TIME NOT NULL, id_schedule_id INT DEFAULT NULL, INDEX IDX_5A3811FBBC190F22 (id_schedule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, name_state VARCHAR(30) NOT NULL, id_state_id INT NOT NULL, INDEX IDX_A393D2FB5503D054 (id_state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE type_hour (id INT AUTO_INCREMENT NOT NULL, name_hrs VARCHAR(80) NOT NULL, id_hour_id INT DEFAULT NULL, INDEX IDX_A711D4466B0ED289 (id_hour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A194113CAB FOREIGN KEY (id_employee_id) REFERENCES nomina (id)');
        $this->addSql('ALTER TABLE job_title ADD CONSTRAINT FK_2A6AC51B4702F281 FOREIGN KEY (cod_job_title_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBBC190F22 FOREIGN KEY (id_schedule_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FB5503D054 FOREIGN KEY (id_state_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE type_hour ADD CONSTRAINT FK_A711D4466B0ED289 FOREIGN KEY (id_hour_id) REFERENCES nomina (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A194113CAB');
        $this->addSql('ALTER TABLE job_title DROP FOREIGN KEY FK_2A6AC51B4702F281');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBBC190F22');
        $this->addSql('ALTER TABLE state DROP FOREIGN KEY FK_A393D2FB5503D054');
        $this->addSql('ALTER TABLE type_hour DROP FOREIGN KEY FK_A711D4466B0ED289');
        $this->addSql('DROP TABLE biometric');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE job_title');
        $this->addSql('DROP TABLE nomina');
        $this->addSql('DROP TABLE operador');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE type_hour');
    }
}
