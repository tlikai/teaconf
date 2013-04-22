<?php

class m130422_170815_notification extends CDbMigration
{
	public function up()
	{
        $command = <<<EOF
CREATE TABLE `notification` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `unread` tinyint(1) unsigned DEFAULT NULL,
  `owner_id` int(11) unsigned DEFAULT NULL,
  `replier_id` int(11) unsigned DEFAULT NULL,
  `replied_by` char(20) DEFAULT NULL,
  `replied_at` int(11) unsigned DEFAULT NULL,
  `topic_id` int(11) unsigned DEFAULT NULL,
  `topic_title` varchar(255) DEFAULT NULL,
  `topic_quote` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
EOF;
        $this->execute($command);
        $this->addColumn('user', 'notifications', 'int(11)');
	}

	public function down()
	{
        $this->dropTable('notification');
        $this->dropColumn('user', 'notifications');
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
