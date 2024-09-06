<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240822164649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE biometric (id INT AUTO_INCREMENT NOT NULL, company VARCHAR(20) NOT NULL, name VARCHAR(50) DEFAULT NULL, cod_nomina VARCHAR(10) NOT NULL, cc INT DEFAULT NULL, date DATETIME NOT NULL, in_hour TIME DEFAULT NULL, out_hour TIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE employee (id VARCHAR(7) NOT NULL, name VARCHAR(90) NOT NULL, cc INT NOT NULL, id_state_id INT NOT NULL, cod_job_title_id INT NOT NULL, id_schedule_id INT NOT NULL, INDEX IDX_5D9F75A15503D054 (id_state_id), INDEX IDX_5D9F75A14702F281 (cod_job_title_id), INDEX IDX_5D9F75A1BC190F22 (id_schedule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE job_title (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nomina (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, fortnight SMALLINT NOT NULL, amount DOUBLE PRECISION NOT NULL, type_hour_id INT NOT NULL, id_employee_id VARCHAR(7) NOT NULL, INDEX IDX_D7DFE7839DB2140C (type_hour_id), INDEX IDX_D7DFE78394113CAB (id_employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, time_start TIME NOT NULL, time_end TIME NOT NULL, time_2_start TIME NOT NULL, time_2_end TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, name_state VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE type_hour (id INT AUTO_INCREMENT NOT NULL, name_hrs VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A15503D054 FOREIGN KEY (id_state_id) REFERENCES state (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A14702F281 FOREIGN KEY (cod_job_title_id) REFERENCES job_title (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1BC190F22 FOREIGN KEY (id_schedule_id) REFERENCES schedule (id)');
        $this->addSql('ALTER TABLE nomina ADD CONSTRAINT FK_D7DFE7839DB2140C FOREIGN KEY (type_hour_id) REFERENCES type_hour (id)');
        $this->addSql('ALTER TABLE nomina ADD CONSTRAINT FK_D7DFE78394113CAB FOREIGN KEY (id_employee_id) REFERENCES employee (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A15503D054');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A14702F281');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1BC190F22');
        $this->addSql('ALTER TABLE nomina DROP FOREIGN KEY FK_D7DFE7839DB2140C');
        $this->addSql('ALTER TABLE nomina DROP FOREIGN KEY FK_D7DFE78394113CAB');
        $this->addSql('DROP TABLE biometric');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE job_title');
        $this->addSql('DROP TABLE nomina');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE type_hour');
    }
}
