<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210723101411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresses (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, pays VARCHAR(100) NOT NULL, ville VARCHAR(100) NOT NULL, rue VARCHAR(255) NOT NULL, code_postal INT NOT NULL, titre VARCHAR(255) NOT NULL, INDEX IDX_EF192552A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carte (id INT AUTO_INCREMENT NOT NULL, set_id_id INT NOT NULL, nom VARCHAR(100) NOT NULL, type VARCHAR(100) NOT NULL, attribut VARCHAR(100) NOT NULL, niveau INT NOT NULL, archetype VARCHAR(100) NOT NULL, rarete VARCHAR(100) NOT NULL, stock INT NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_BAD4FFFDEBB56231 (set_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carte_panier (id INT AUTO_INCREMENT NOT NULL, panier_id INT NOT NULL, cartes_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_32286DC3F77D927C (panier_id), INDEX IDX_32286DC3C5BA6C52 (cartes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, panier_id INT NOT NULL, prix_total DOUBLE PRECISION NOT NULL, date_commande DATETIME NOT NULL, prix_livraison DOUBLE PRECISION NOT NULL, user INT NOT NULL, UNIQUE INDEX UNIQ_6EEAA67DF77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, commande_id INT DEFAULT NULL, type_livraison VARCHAR(100) NOT NULL, INDEX IDX_24CC0DF2A76ED395 (user_id), UNIQUE INDEX UNIQ_24CC0DF282EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `set` (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, libelle VARCHAR(255) NOT NULL, date_parution DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, paiement INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adresses ADD CONSTRAINT FK_EF192552A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE carte ADD CONSTRAINT FK_BAD4FFFDEBB56231 FOREIGN KEY (set_id_id) REFERENCES `set` (id)');
        $this->addSql('ALTER TABLE carte_panier ADD CONSTRAINT FK_32286DC3F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE carte_panier ADD CONSTRAINT FK_32286DC3C5BA6C52 FOREIGN KEY (cartes_id) REFERENCES carte (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DF77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF282EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte_panier DROP FOREIGN KEY FK_32286DC3C5BA6C52');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF282EA2E54');
        $this->addSql('ALTER TABLE carte_panier DROP FOREIGN KEY FK_32286DC3F77D927C');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DF77D927C');
        $this->addSql('ALTER TABLE carte DROP FOREIGN KEY FK_BAD4FFFDEBB56231');
        $this->addSql('ALTER TABLE adresses DROP FOREIGN KEY FK_EF192552A76ED395');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2A76ED395');
        $this->addSql('DROP TABLE adresses');
        $this->addSql('DROP TABLE carte');
        $this->addSql('DROP TABLE carte_panier');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE `set`');
        $this->addSql('DROP TABLE user');
    }
}
