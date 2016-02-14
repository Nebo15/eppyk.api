<?php

class Indexes extends \Sokil\Mongo\Migrator\AbstractMigration
{
    public function up()
    {
        $this->getCollection('users')->ensureUniqueIndex(['login' => 1]);
        $this->getCollection('locales')->ensureUniqueIndex(['code' => 1]);
    }

    public function down()
    {
        $this->getCollection('users')->getMongoCollection()->deleteIndex('login');
        $this->getCollection('locales')->getMongoCollection()->deleteIndex('code');
    }
}