<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514132558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conference (id INT AUTO_INCREMENT NOT NULL, emplacement INT DEFAULT NULL, nom VARCHAR(20) NOT NULL, date DATE NOT NULL, sujet VARCHAR(500) NOT NULL, budget DOUBLE PRECISION NOT NULL, typeconf TINYINT(1) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_911533C8C0CF65F6 (emplacement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emplacement (id INT AUTO_INCREMENT NOT NULL, gouvernourat VARCHAR(20) DEFAULT NULL, ville VARCHAR(20) NOT NULL, capacite INT NOT NULL, label VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estimatedexpenses (estimatedExpensesId INT AUTO_INCREMENT NOT NULL, ExpensesWay VARCHAR(255) DEFAULT NULL, pessimisticExpenses DOUBLE PRECISION DEFAULT NULL, realisticExpenses DOUBLE PRECISION DEFAULT NULL, optimisticExpenses DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(estimatedExpensesId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estimatedincomes (estimatedIncomesId INT AUTO_INCREMENT NOT NULL, incomeSource VARCHAR(255) DEFAULT NULL, pessimisticIncome DOUBLE PRECISION DEFAULT NULL, realisticIncome DOUBLE PRECISION DEFAULT NULL, optimisticIncome DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(estimatedIncomesId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expenses (expensesId INT AUTO_INCREMENT NOT NULL, onWhat VARCHAR(255) DEFAULT NULL, expAmmount INT DEFAULT NULL, PRIMARY KEY(expensesId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE financialincomes (financialIncomesId INT AUTO_INCREMENT NOT NULL, sponsorName VARCHAR(255) DEFAULT NULL, cashIn INT DEFAULT NULL, proof LONGBLOB DEFAULT NULL, PRIMARY KEY(financialIncomesId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incomes (incomesId INT AUTO_INCREMENT NOT NULL, fromWhat VARCHAR(255) DEFAULT NULL, incAmmount INT DEFAULT NULL, PRIMARY KEY(incomesId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logistic (logisticID INT AUTO_INCREMENT NOT NULL, providedLog VARCHAR(255) DEFAULT NULL, quantity INT DEFAULT NULL, PRIMARY KEY(logisticID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logisticincome (logIncomeId INT AUTO_INCREMENT NOT NULL, logSponsorName VARCHAR(255) DEFAULT NULL, logIncomeQty INT DEFAULT NULL, logProof LONGBLOB DEFAULT NULL, logisticID INT DEFAULT NULL, INDEX IDX_62E2C74BB2DAE73C (logisticID), PRIMARY KEY(logIncomeId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, montant DOUBLE PRECISION NOT NULL, moyendepaiement VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, sessionName VARCHAR(30) NOT NULL, startTime TIME NOT NULL, endTime TIME NOT NULL, presenceNbr INT NOT NULL, presenceQuality INT NOT NULL, presenceSpent INT NOT NULL, idConference INT DEFAULT NULL, INDEX IDX_D044D5D413E12D22 (idConference), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponsor (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, email VARCHAR(30) NOT NULL, numtel VARCHAR(8) NOT NULL, status VARCHAR(20) NOT NULL, budget DOUBLE PRECISION DEFAULT NULL, cause VARCHAR(9) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topics (id INT AUTO_INCREMENT NOT NULL, topicName VARCHAR(30) NOT NULL, speakerName VARCHAR(30) NOT NULL, topicDescription VARCHAR(300) NOT NULL, idSession INT DEFAULT NULL, INDEX IDX_91F64639C0FDBE26 (idSession), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uidcard (id INT AUTO_INCREMENT NOT NULL, uid VARCHAR(10) NOT NULL, currentTime DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, status INT NOT NULL, idSession INT DEFAULT NULL, idParticipant INT DEFAULT NULL, INDEX IDX_5725E82297C29469 (idParticipant), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(15) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, numtel INT NOT NULL, role VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conference ADD CONSTRAINT FK_911533C8C0CF65F6 FOREIGN KEY (emplacement) REFERENCES emplacement (id)');
        $this->addSql('ALTER TABLE logisticincome ADD CONSTRAINT FK_62E2C74BB2DAE73C FOREIGN KEY (logisticID) REFERENCES logistic (logisticID)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D413E12D22 FOREIGN KEY (idConference) REFERENCES conference (id)');
        $this->addSql('ALTER TABLE topics ADD CONSTRAINT FK_91F64639C0FDBE26 FOREIGN KEY (idSession) REFERENCES session (id)');
        $this->addSql('ALTER TABLE uidcard ADD CONSTRAINT FK_5725E82297C29469 FOREIGN KEY (idParticipant) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conference DROP FOREIGN KEY FK_911533C8C0CF65F6');
        $this->addSql('ALTER TABLE logisticincome DROP FOREIGN KEY FK_62E2C74BB2DAE73C');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D413E12D22');
        $this->addSql('ALTER TABLE topics DROP FOREIGN KEY FK_91F64639C0FDBE26');
        $this->addSql('ALTER TABLE uidcard DROP FOREIGN KEY FK_5725E82297C29469');
        $this->addSql('DROP TABLE conference');
        $this->addSql('DROP TABLE emplacement');
        $this->addSql('DROP TABLE estimatedexpenses');
        $this->addSql('DROP TABLE estimatedincomes');
        $this->addSql('DROP TABLE expenses');
        $this->addSql('DROP TABLE financialincomes');
        $this->addSql('DROP TABLE incomes');
        $this->addSql('DROP TABLE logistic');
        $this->addSql('DROP TABLE logisticincome');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('DROP TABLE topics');
        $this->addSql('DROP TABLE uidcard');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
