<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200806155755 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_versions (category_id INT NOT NULL, category_old_id INT NOT NULL, INDEX IDX_AEA6C4A912469DE2 (category_id), INDEX IDX_AEA6C4A9360E306D (category_old_id), PRIMARY KEY(category_id, category_old_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_versions (product_id INT NOT NULL, product_old_id INT NOT NULL, INDEX IDX_D26C2A454584665A (product_id), INDEX IDX_D26C2A455B9ABBB2 (product_old_id), PRIMARY KEY(product_id, product_old_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_versions ADD CONSTRAINT FK_AEA6C4A912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category_versions ADD CONSTRAINT FK_AEA6C4A9360E306D FOREIGN KEY (category_old_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product_versions ADD CONSTRAINT FK_D26C2A454584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_versions ADD CONSTRAINT FK_D26C2A455B9ABBB2 FOREIGN KEY (product_old_id) REFERENCES product (id)');
        $this->addSql('DROP INDEX UNIQ_64C19C15E237E06 ON category');
        $this->addSql('ALTER TABLE category ADD is_historical TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_D34A04AD5E237E06 ON product');
        $this->addSql('ALTER TABLE product ADD is_historical TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE vettige_vrijdag CHANGE status status VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category_versions');
        $this->addSql('DROP TABLE product_versions');
        $this->addSql('ALTER TABLE category DROP is_historical');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name)');
        $this->addSql('ALTER TABLE product DROP is_historical');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD5E237E06 ON product (name)');
        $this->addSql('ALTER TABLE vettige_vrijdag CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
