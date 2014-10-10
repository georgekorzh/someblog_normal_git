<?php

class m141007_130102_commentscreation extends CDbMigration
{
	public function up()
	{
		$this->createTable('comments', array(
			'id'	   => 'int NOT NULL PRIMARY KEY AUTO_INCREMENT',
			'comment'  => 'text NOT NULL',
			'id_post'  => 'int not null',
			'parent'   => 'int'
		));
		$this->addForeignKey('post_num', 'comments', 'id_post', 'posts', 'id');
		$this->addForeignKey('answer_or_not', 'comments', 'parent', 'comments', 'id');
	}

	public function down()
	{
		//echo "m141007_130102_commentscreation does not support migration down.\n";
		//return false;
		$this->dropTable('comments');
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
