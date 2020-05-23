<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200523120717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id_user INT AUTO_INCREMENT NOT NULL, nick VARCHAR(255) NOT NULL, password VARCHAR(512) NOT NULL, permission INT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, player INT NOT NULL, age INT NOT NULL, company VARCHAR(255) NOT NULL, descrioption LONGTEXT NOT NULL, count INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE `order` CHANGE id id_order INT AUTO_INCREMENT NOT NULL, CHANGE user_id users_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939867B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F529939867B3B43D ON `order` (users_id)');
        $this->addSql('ALTER TABLE `order` ADD PRIMARY KEY (id_order)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939867B3B43D');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE product');
        $this->addSql('ALTER TABLE `order` MODIFY id_order INT NOT NULL');
        $this->addSql('DROP INDEX IDX_F529939867B3B43D ON `order`');
        $this->addSql('ALTER TABLE `order` DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE `order` CHANGE id_order id INT AUTO_INCREMENT NOT NULL, CHANGE users_id user_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
        $this->addSql('ALTER TABLE `order` ADD PRIMARY KEY (id)');
    }
}
