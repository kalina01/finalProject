<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220612085135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_5A3811FB23EDC87');
        $this->addSql('DROP INDEX IDX_5A3811FB4DDF95DC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__schedule AS SELECT id, student_group_id, subject_id, day_of_week, class FROM schedule');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('CREATE TABLE schedule (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, student_group_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, day_of_week VARCHAR(255) NOT NULL, class VARCHAR(255) NOT NULL, CONSTRAINT FK_5A3811FB4DDF95DC FOREIGN KEY (student_group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5A3811FB23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO schedule (id, student_group_id, subject_id, day_of_week, class) SELECT id, student_group_id, subject_id, day_of_week, class FROM __temp__schedule');
        $this->addSql('DROP TABLE __temp__schedule');
        $this->addSql('CREATE INDEX IDX_5A3811FB23EDC87 ON schedule (subject_id)');
        $this->addSql('CREATE INDEX IDX_5A3811FB4DDF95DC ON schedule (student_group_id)');
        $this->addSql('DROP INDEX IDX_1F595292A76ED395');
        $this->addSql('DROP INDEX IDX_1F59529223EDC87');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subject_user AS SELECT subject_id, user_id FROM subject_user');
        $this->addSql('DROP TABLE subject_user');
        $this->addSql('CREATE TABLE subject_user (subject_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(subject_id, user_id), CONSTRAINT FK_1F59529223EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1F595292A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO subject_user (subject_id, user_id) SELECT subject_id, user_id FROM __temp__subject_user');
        $this->addSql('DROP TABLE __temp__subject_user');
        $this->addSql('CREATE INDEX IDX_1F595292A76ED395 ON subject_user (user_id)');
        $this->addSql('CREATE INDEX IDX_1F59529223EDC87 ON subject_user (subject_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677');
        $this->addSql('DROP INDEX IDX_8D93D6491C592EA8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, group_student_id, username, roles, password, first_name, last_name FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, group_student_id INTEGER DEFAULT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, CONSTRAINT FK_8D93D6491C592EA8 FOREIGN KEY (group_student_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, group_student_id, username, roles, password, first_name, last_name) SELECT id, group_student_id, username, roles, password, first_name, last_name FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE INDEX IDX_8D93D6491C592EA8 ON user (group_student_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_5A3811FB4DDF95DC');
        $this->addSql('DROP INDEX IDX_5A3811FB23EDC87');
        $this->addSql('CREATE TEMPORARY TABLE __temp__schedule AS SELECT id, student_group_id, subject_id, day_of_week, class FROM schedule');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('CREATE TABLE schedule (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, student_group_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, day_of_week VARCHAR(255) NOT NULL, class VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO schedule (id, student_group_id, subject_id, day_of_week, class) SELECT id, student_group_id, subject_id, day_of_week, class FROM __temp__schedule');
        $this->addSql('DROP TABLE __temp__schedule');
        $this->addSql('CREATE INDEX IDX_5A3811FB4DDF95DC ON schedule (student_group_id)');
        $this->addSql('CREATE INDEX IDX_5A3811FB23EDC87 ON schedule (subject_id)');
        $this->addSql('DROP INDEX IDX_1F59529223EDC87');
        $this->addSql('DROP INDEX IDX_1F595292A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subject_user AS SELECT subject_id, user_id FROM subject_user');
        $this->addSql('DROP TABLE subject_user');
        $this->addSql('CREATE TABLE subject_user (subject_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(subject_id, user_id))');
        $this->addSql('INSERT INTO subject_user (subject_id, user_id) SELECT subject_id, user_id FROM __temp__subject_user');
        $this->addSql('DROP TABLE __temp__subject_user');
        $this->addSql('CREATE INDEX IDX_1F59529223EDC87 ON subject_user (subject_id)');
        $this->addSql('CREATE INDEX IDX_1F595292A76ED395 ON subject_user (user_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677');
        $this->addSql('DROP INDEX IDX_8D93D6491C592EA8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, group_student_id, username, roles, password, first_name, last_name FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, group_student_id INTEGER DEFAULT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, group_student_id, username, roles, password, first_name, last_name) SELECT id, group_student_id, username, roles, password, first_name, last_name FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE INDEX IDX_8D93D6491C592EA8 ON user (group_student_id)');
    }
}
