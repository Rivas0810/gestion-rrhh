<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261006195352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attendance_records (id INT AUTO_INCREMENT NOT NULL, entry_time DATETIME DEFAULT NULL, exit_time DATETIME DEFAULT NULL, employee_id INT NOT NULL, INDEX IDX_9B5AB6448C03F15C (employee_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE departments (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(70) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE employees (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(70) NOT NULL, email VARCHAR(70) NOT NULL, phone VARCHAR(10) NOT NULL, departments_id INT NOT NULL, INDEX IDX_BA82C300F1B3F295 (departments_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE attendance_records ADD CONSTRAINT FK_9B5AB6448C03F15C FOREIGN KEY (employee_id) REFERENCES employees (id)');
        $this->addSql('ALTER TABLE employees ADD CONSTRAINT FK_BA82C300F1B3F295 FOREIGN KEY (departments_id) REFERENCES departments (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendance_records DROP FOREIGN KEY FK_9B5AB6448C03F15C');
        $this->addSql('ALTER TABLE employees DROP FOREIGN KEY FK_BA82C300F1B3F295');
        $this->addSql('DROP TABLE attendance_records');
        $this->addSql('DROP TABLE departments');
        $this->addSql('DROP TABLE employees');
    }
}
