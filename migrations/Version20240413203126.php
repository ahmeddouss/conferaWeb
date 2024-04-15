<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240413203126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session CHANGE presenceNbr presenceNbr INT NOT NULL, CHANGE presenceQuality presenceQuality INT NOT NULL, CHANGE presenceSpent presenceSpent INT NOT NULL, CHANGE idConference idConference INT DEFAULT NULL');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D413E12D22 FOREIGN KEY (idConference) REFERENCES conference (id)');
        $this->addSql('DROP INDEX session_ibfk_1 ON session');
        $this->addSql('CREATE INDEX IDX_D044D5D413E12D22 ON session (idConference)');
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
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D413E12D22');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D413E12D22');
        $this->addSql('ALTER TABLE session CHANGE presenceNbr presenceNbr INT DEFAULT 0 NOT NULL, CHANGE presenceQuality presenceQuality INT DEFAULT 0 NOT NULL, CHANGE presenceSpent presenceSpent INT DEFAULT 0 NOT NULL, CHANGE idConference idConference INT NOT NULL');
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
