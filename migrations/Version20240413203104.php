<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240413203104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logisticincome DROP FOREIGN KEY ii');
        $this->addSql('ALTER TABLE sponsoraccepted DROP FOREIGN KEY sponsoraccepted_ibfk_1');
        $this->addSql('ALTER TABLE sponsorrejected DROP FOREIGN KEY sponsorrejected_ibfk_1');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE emplacement');
        $this->addSql('DROP TABLE estimatedexpenses');
        $this->addSql('DROP TABLE estimatedincomes');
        $this->addSql('DROP TABLE expenses');
        $this->addSql('DROP TABLE financialincomes');
        $this->addSql('DROP TABLE incomes');
        $this->addSql('DROP TABLE logistic');
        $this->addSql('DROP TABLE logisticincome');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE participer');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('DROP TABLE sponsoraccepted');
        $this->addSql('DROP TABLE sponsorrejected');
        $this->addSql('DROP TABLE venue');
        $this->addSql('DROP INDEX fkorg ON conference');
        $this->addSql('DROP INDEX fkloc ON conference');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY session_ibfk_1');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY session_ibfk_1');
        $this->addSql('ALTER TABLE session CHANGE presenceNbr presenceNbr INT NOT NULL, CHANGE presenceQuality presenceQuality INT NOT NULL, CHANGE presenceSpent presenceSpent INT NOT NULL, CHANGE idConference idConference INT DEFAULT NULL');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D413E12D22 FOREIGN KEY (idConference) REFERENCES conference (id)');
        $this->addSql('DROP INDEX session_ibfk_1 ON session');
        $this->addSql('CREATE INDEX IDX_D044D5D413E12D22 ON session (idConference)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT session_ibfk_1 FOREIGN KEY (idConference) REFERENCES conference (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE topics CHANGE idSession idSession INT DEFAULT NULL');
        $this->addSql('ALTER TABLE topics ADD CONSTRAINT FK_91F64639C0FDBE26 FOREIGN KEY (idSession) REFERENCES session (id)');
        $this->addSql('DROP INDEX id ON topics');
        $this->addSql('CREATE INDEX IDX_91F64639C0FDBE26 ON topics (idSession)');
        $this->addSql('ALTER TABLE uidcard DROP FOREIGN KEY uidcard_ibfk_1');
        $this->addSql('ALTER TABLE uidcard CHANGE status status INT NOT NULL');
        $this->addSql('DROP INDEX uidcard_ibfk_1 ON uidcard');
        $this->addSql('CREATE INDEX IDX_5725E82297C29469 ON uidcard (idParticipant)');
        $this->addSql('ALTER TABLE uidcard ADD CONSTRAINT uidcard_ibfk_1 FOREIGN KEY (idParticipant) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaires (idcommentaire INT AUTO_INCREMENT NOT NULL, caractere VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(idcommentaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE emplacement (id INT AUTO_INCREMENT NOT NULL, gouvernourat VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, ville VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, capacite INT NOT NULL, label VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE estimatedexpenses (estimatedExpensesId INT AUTO_INCREMENT NOT NULL, ExpensesWay VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, pessimisticExpenses DOUBLE PRECISION DEFAULT NULL, realisticExpenses DOUBLE PRECISION DEFAULT NULL, optimisticExpenses DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(estimatedExpensesId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE estimatedincomes (estimatedIncomesId INT AUTO_INCREMENT NOT NULL, incomeSource VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, pessimisticIncome DOUBLE PRECISION DEFAULT NULL, realisticIncome DOUBLE PRECISION DEFAULT NULL, optimisticIncome DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(estimatedIncomesId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE expenses (expensesId INT AUTO_INCREMENT NOT NULL, onWhat VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, expAmmount INT DEFAULT NULL, PRIMARY KEY(expensesId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE financialincomes (financialIncomesId INT AUTO_INCREMENT NOT NULL, sponsorName VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, cashIn INT DEFAULT NULL, proof LONGBLOB DEFAULT NULL, PRIMARY KEY(financialIncomesId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE incomes (incomesId INT AUTO_INCREMENT NOT NULL, fromWhat VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, incAmmount INT DEFAULT NULL, PRIMARY KEY(incomesId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE logistic (logisticID INT AUTO_INCREMENT NOT NULL, providedLog VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, quantity INT DEFAULT NULL, PRIMARY KEY(logisticID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE logisticincome (logIncomeId INT AUTO_INCREMENT NOT NULL, logSponsorName VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, logIncomeQty INT DEFAULT NULL, logProof LONGBLOB DEFAULT NULL, logisticID INT NOT NULL, INDEX logisticID (logisticID), PRIMARY KEY(logIncomeId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE notes (id INT AUTO_INCREMENT NOT NULL, notation INT DEFAULT NULL, image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, cin VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, DateN DATE DEFAULT NULL, numTel VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participer (id INT AUTO_INCREMENT NOT NULL, idparticipant INT NOT NULL, idsession INT NOT NULL, note DOUBLE PRECISION NOT NULL, commentaire VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sponsor (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, numtel VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, status VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, budget DOUBLE PRECISION DEFAULT NULL, cause VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sponsoraccepted (id INT AUTO_INCREMENT NOT NULL, budget DOUBLE PRECISION NOT NULL, idSponsor INT NOT NULL, INDEX sponsoraccepted_ibfk_1 (idSponsor), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sponsorrejected (id INT AUTO_INCREMENT NOT NULL, idSponsor INT NOT NULL, cause VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX sponsorrejected_ibfk_1 (idSponsor), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE venue (id INT AUTO_INCREMENT NOT NULL, venueName VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, phone VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, city VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, output TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, Status TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE logisticincome ADD CONSTRAINT ii FOREIGN KEY (logisticID) REFERENCES logistic (logisticID)');
        $this->addSql('ALTER TABLE sponsoraccepted ADD CONSTRAINT sponsoraccepted_ibfk_1 FOREIGN KEY (idSponsor) REFERENCES sponsor (id)');
        $this->addSql('ALTER TABLE sponsorrejected ADD CONSTRAINT sponsorrejected_ibfk_1 FOREIGN KEY (idSponsor) REFERENCES sponsor (id)');
        $this->addSql('CREATE INDEX fkorg ON conference (organisateur)');
        $this->addSql('CREATE INDEX fkloc ON conference (emplacement)');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D413E12D22');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D413E12D22');
        $this->addSql('ALTER TABLE session CHANGE presenceNbr presenceNbr INT DEFAULT 0 NOT NULL, CHANGE presenceQuality presenceQuality INT DEFAULT 0 NOT NULL, CHANGE presenceSpent presenceSpent INT DEFAULT 0 NOT NULL, CHANGE idConference idConference INT NOT NULL');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT session_ibfk_1 FOREIGN KEY (idConference) REFERENCES conference (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX idx_d044d5d413e12d22 ON session');
        $this->addSql('CREATE INDEX session_ibfk_1 ON session (idConference)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D413E12D22 FOREIGN KEY (idConference) REFERENCES conference (id)');
        $this->addSql('ALTER TABLE topics DROP FOREIGN KEY FK_91F64639C0FDBE26');
        $this->addSql('ALTER TABLE topics DROP FOREIGN KEY FK_91F64639C0FDBE26');
        $this->addSql('ALTER TABLE topics CHANGE idSession idSession INT NOT NULL');
        $this->addSql('DROP INDEX idx_91f64639c0fdbe26 ON topics');
        $this->addSql('CREATE INDEX id ON topics (idSession)');
        $this->addSql('ALTER TABLE topics ADD CONSTRAINT FK_91F64639C0FDBE26 FOREIGN KEY (idSession) REFERENCES session (id)');
        $this->addSql('ALTER TABLE uidcard DROP FOREIGN KEY FK_5725E82297C29469');
        $this->addSql('ALTER TABLE uidcard CHANGE status status INT DEFAULT 0 NOT NULL');
        $this->addSql('DROP INDEX idx_5725e82297c29469 ON uidcard');
        $this->addSql('CREATE INDEX uidcard_ibfk_1 ON uidcard (idParticipant)');
        $this->addSql('ALTER TABLE uidcard ADD CONSTRAINT FK_5725E82297C29469 FOREIGN KEY (idParticipant) REFERENCES user (id)');
    }
}
