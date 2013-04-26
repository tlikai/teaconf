<?php

class m130426_171845_topic_ranking extends CDbMigration
{
	public function up()
	{
        $this->renameColumn('topic', 'views', 'score');
	}

	public function down()
	{
        $this->renameColumn('topic', 'score', 'views');
        return true;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
