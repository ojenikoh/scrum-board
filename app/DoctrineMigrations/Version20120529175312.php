<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120529175312 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE user ADD password VARCHAR(255) NOT NULL");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("DROP INDEX UNIQ_8D93D649F85E0677 ON user");
        $this->addSql("DROP INDEX UNIQ_8D93D649E7927C74 ON user");
        $this->addSql("ALTER TABLE user DROP password");
    }
}
