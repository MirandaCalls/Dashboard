<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180520181955 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE net_inventory_item (id INTEGER NOT NULL, room_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, amount INTEGER NOT NULL, low_stock_amount INTEGER NOT NULL, description CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4BF6E5D054177093 ON net_inventory_item (room_id)');
        $this->addSql('CREATE TABLE net_inventory_room (id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP INDEX IDX_261F9B451FB8D185');
        $this->addSql('CREATE TEMPORARY TABLE __temp__net_speed_log AS SELECT id, host_id, upload_speed, download_speed, connection_type, time FROM net_speed_log');
        $this->addSql('DROP TABLE net_speed_log');
        $this->addSql('CREATE TABLE net_speed_log (id INTEGER NOT NULL, host_id INTEGER DEFAULT NULL, upload_speed DOUBLE PRECISION NOT NULL, download_speed DOUBLE PRECISION NOT NULL, connection_type VARCHAR(255) NOT NULL COLLATE BINARY, time DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_261F9B451FB8D185 FOREIGN KEY (host_id) REFERENCES net_host (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO net_speed_log (id, host_id, upload_speed, download_speed, connection_type, time) SELECT id, host_id, upload_speed, download_speed, connection_type, time FROM __temp__net_speed_log');
        $this->addSql('DROP TABLE __temp__net_speed_log');
        $this->addSql('CREATE INDEX IDX_261F9B451FB8D185 ON net_speed_log (host_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE net_inventory_item');
        $this->addSql('DROP TABLE net_inventory_room');
        $this->addSql('DROP INDEX IDX_261F9B451FB8D185');
        $this->addSql('CREATE TEMPORARY TABLE __temp__net_speed_log AS SELECT id, host_id, upload_speed, download_speed, connection_type, time FROM net_speed_log');
        $this->addSql('DROP TABLE net_speed_log');
        $this->addSql('CREATE TABLE net_speed_log (id INTEGER NOT NULL, host_id INTEGER DEFAULT NULL, upload_speed DOUBLE PRECISION NOT NULL, download_speed DOUBLE PRECISION NOT NULL, connection_type VARCHAR(255) NOT NULL, time DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO net_speed_log (id, host_id, upload_speed, download_speed, connection_type, time) SELECT id, host_id, upload_speed, download_speed, connection_type, time FROM __temp__net_speed_log');
        $this->addSql('DROP TABLE __temp__net_speed_log');
        $this->addSql('CREATE INDEX IDX_261F9B451FB8D185 ON net_speed_log (host_id)');
    }
}
