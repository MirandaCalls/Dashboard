<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190223220224 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_4BF6E5D054177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__net_inventory_item AS SELECT id, room_id, name, amount, low_stock_amount, description FROM net_inventory_item');
        $this->addSql('DROP TABLE net_inventory_item');
        $this->addSql('CREATE TABLE net_inventory_item (id INTEGER NOT NULL, room_id INTEGER DEFAULT NULL, unit_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, amount INTEGER NOT NULL, low_stock_amount INTEGER NOT NULL, description CLOB NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_4BF6E5D054177093 FOREIGN KEY (room_id) REFERENCES net_inventory_room (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4BF6E5D0F8BD700D FOREIGN KEY (unit_id) REFERENCES net_inventory_unit (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO net_inventory_item (id, room_id, name, amount, low_stock_amount, description) SELECT id, room_id, name, amount, low_stock_amount, description FROM __temp__net_inventory_item');
        $this->addSql('DROP TABLE __temp__net_inventory_item');
        $this->addSql('CREATE INDEX IDX_4BF6E5D054177093 ON net_inventory_item (room_id)');
        $this->addSql('CREATE INDEX IDX_4BF6E5D0F8BD700D ON net_inventory_item (unit_id)');
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

        $this->addSql('DROP INDEX IDX_4BF6E5D054177093');
        $this->addSql('DROP INDEX IDX_4BF6E5D0F8BD700D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__net_inventory_item AS SELECT id, room_id, name, amount, low_stock_amount, description FROM net_inventory_item');
        $this->addSql('DROP TABLE net_inventory_item');
        $this->addSql('CREATE TABLE net_inventory_item (id INTEGER NOT NULL, room_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, amount INTEGER NOT NULL, low_stock_amount INTEGER NOT NULL, description CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO net_inventory_item (id, room_id, name, amount, low_stock_amount, description) SELECT id, room_id, name, amount, low_stock_amount, description FROM __temp__net_inventory_item');
        $this->addSql('DROP TABLE __temp__net_inventory_item');
        $this->addSql('CREATE INDEX IDX_4BF6E5D054177093 ON net_inventory_item (room_id)');
        $this->addSql('DROP INDEX IDX_261F9B451FB8D185');
        $this->addSql('CREATE TEMPORARY TABLE __temp__net_speed_log AS SELECT id, host_id, upload_speed, download_speed, connection_type, time FROM net_speed_log');
        $this->addSql('DROP TABLE net_speed_log');
        $this->addSql('CREATE TABLE net_speed_log (id INTEGER NOT NULL, host_id INTEGER DEFAULT NULL, upload_speed DOUBLE PRECISION NOT NULL, download_speed DOUBLE PRECISION NOT NULL, connection_type VARCHAR(255) NOT NULL, time DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO net_speed_log (id, host_id, upload_speed, download_speed, connection_type, time) SELECT id, host_id, upload_speed, download_speed, connection_type, time FROM __temp__net_speed_log');
        $this->addSql('DROP TABLE __temp__net_speed_log');
        $this->addSql('CREATE INDEX IDX_261F9B451FB8D185 ON net_speed_log (host_id)');
    }
}
