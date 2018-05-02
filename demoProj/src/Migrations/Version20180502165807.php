<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180502165807 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, car_id VARCHAR(255) DEFAULT NULL, startDate DATETIME NOT NULL, finishDate DATETIME NOT NULL, duration INT NOT NULL, isDone TINYINT(1) NOT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_E52FFDEECCFA12B8 (profile_id), INDEX IDX_E52FFDEEC3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forgot_password (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, passwordResetToken VARCHAR(255) DEFAULT NULL, role INT NOT NULL, registrationDate DATETIME NOT NULL, lastLoginTime DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, is_deleted TINYINT(1) NOT NULL, registrationToken VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profiles (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, second_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, UNIQUE INDEX UNIQ_8B308530A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cost INT NOT NULL, duration INT NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_7332E1695E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repair (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, cost INT NOT NULL, duration INT NOT NULL, is_done TINYINT(1) NOT NULL, INDEX IDX_8EE434218D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cars (number_plate VARCHAR(255) NOT NULL, profile_id INT DEFAULT NULL, model VARCHAR(255) NOT NULL, engine_type VARCHAR(255) NOT NULL, transmission VARCHAR(255) NOT NULL, power INT NOT NULL, INDEX IDX_95C71D14CCFA12B8 (profile_id), PRIMARY KEY(number_plate)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEECCFA12B8 FOREIGN KEY (profile_id) REFERENCES profiles (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEC3C6F69F FOREIGN KEY (car_id) REFERENCES cars (number_plate)');
        $this->addSql('ALTER TABLE profiles ADD CONSTRAINT FK_8B308530A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE repair ADD CONSTRAINT FK_8EE434218D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profiles (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE repair DROP FOREIGN KEY FK_8EE434218D9F6D38');
        $this->addSql('ALTER TABLE profiles DROP FOREIGN KEY FK_8B308530A76ED395');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEECCFA12B8');
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D14CCFA12B8');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEC3C6F69F');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE forgot_password');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE profiles');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE repair');
        $this->addSql('DROP TABLE cars');
    }
}
