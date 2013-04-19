<?php

class m130419_162511_init extends CDbMigration
{
	public function up()
	{
        $command = file_get_contents(Yii::getPathOfAlias('application.data') . DIRECTORY_SEPARATOR . 'database.sql');
        $this->execute($command);
	}

	public function down()
	{
        $command = <<<EOF
DROP TABLE IF EXISTS `node`;
DROP TABLE IF EXISTS `post`;
DROP TABLE IF EXISTS `post_likes`;
DROP TABLE IF EXISTS `section`;
DROP TABLE IF EXISTS `topic`;
DROP TABLE IF EXISTS `topic_likes`;
DROP TABLE IF EXISTS `topic_watch`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `user_auth`;
EOF;
        $this->execute($command);
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
