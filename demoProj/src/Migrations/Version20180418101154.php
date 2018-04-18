<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180418101154 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, passwordResetToken VARCHAR(255) DEFAULT NULL, role INT NOT NULL, registrationDate DATETIME NOT NULL, lastLoginTime DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, is_deleted TINYINT(1) NOT NULL, registrationToken VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profiles (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, second_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, UNIQUE INDEX UNIQ_8B308530A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cars (number_plate VARCHAR(255) NOT NULL, profile_id INT DEFAULT NULL, model VARCHAR(255) NOT NULL, engine_type VARCHAR(255) DEFAULT NULL, transmission VARCHAR(255) DEFAULT NULL, power INT DEFAULT NULL, INDEX IDX_95C71D14CCFA12B8 (profile_id), PRIMARY KEY(number_plate)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profiles ADD CONSTRAINT FK_8B308530A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profiles (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE profiles DROP FOREIGN KEY FK_8B308530A76ED395');
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D14CCFA12B8');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE profiles');
        $this->addSql('DROP TABLE cars');
    }
}
