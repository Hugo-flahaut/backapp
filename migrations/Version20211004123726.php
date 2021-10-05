<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211004123726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, date_start DATE NOT NULL, end_date DATE NOT NULL, status TINYINT(1) NOT NULL, total_price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_E00CEDDEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_room (booking_id INT NOT NULL, room_id INT NOT NULL, INDEX IDX_6A0E73D53301C60 (booking_id), INDEX IDX_6A0E73D554177093 (room_id), PRIMARY KEY(booking_id, room_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_option (booking_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_E11C3B4E3301C60 (booking_id), INDEX IDX_E11C3B4EA7C41D6F (option_id), PRIMARY KEY(booking_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, type VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_729F519B96901F54 (number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking_room ADD CONSTRAINT FK_6A0E73D53301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_room ADD CONSTRAINT FK_6A0E73D554177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_option ADD CONSTRAINT FK_E11C3B4E3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_option ADD CONSTRAINT FK_E11C3B4EA7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_room DROP FOREIGN KEY FK_6A0E73D53301C60');
        $this->addSql('ALTER TABLE booking_option DROP FOREIGN KEY FK_E11C3B4E3301C60');
        $this->addSql('ALTER TABLE booking_option DROP FOREIGN KEY FK_E11C3B4EA7C41D6F');
        $this->addSql('ALTER TABLE booking_room DROP FOREIGN KEY FK_6A0E73D554177093');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_room');
        $this->addSql('DROP TABLE booking_option');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE user');
    }
}
