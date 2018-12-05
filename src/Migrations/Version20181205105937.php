<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181205105937 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE availability');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE week_days');
        $this->addSql('ALTER TABLE session DROP day');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE availability (id INT AUTO_INCREMENT NOT NULL, day_of_week INT NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, slot_space VARCHAR(3) NOT NULL COLLATE utf8mb4_unicode_ci, slot_date DATETIME DEFAULT NULL, status VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, reservation_no VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, availability_id INT NOT NULL, first_name VARCHAR(125) NOT NULL COLLATE utf8mb4_unicode_ci, last_name VARCHAR(125) NOT NULL COLLATE utf8mb4_unicode_ci, phone VARCHAR(25) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, comment LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE week_days (id INT AUTO_INCREMENT NOT NULL, day_name VARCHAR(25) NOT NULL COLLATE utf8mb4_unicode_ci, day_no INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session ADD day VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
