<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120622141339 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("CREATE TABLE teamUser (userId INT NOT NULL, teamId INT NOT NULL, INDEX IDX_3A59EA2964B64DCC (userId), INDEX IDX_3A59EA29D8528F51 (teamId), PRIMARY KEY(userId, teamId)) ENGINE = InnoDB");
        $this->addSql("ALTER TABLE teamUser ADD CONSTRAINT FK_3A59EA2964B64DCC FOREIGN KEY (userId) REFERENCES user(userId)");
        $this->addSql("ALTER TABLE teamUser ADD CONSTRAINT FK_3A59EA29D8528F51 FOREIGN KEY (teamId) REFERENCES team(teamId)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("DROP TABLE teamUser");
    }
}
