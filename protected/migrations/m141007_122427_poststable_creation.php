<?php

class m141007_122427_poststable_creation extends CDbMigration
{
	public function up()
	{
		$this->createTable('posts', array(
			'id'        => 'int not null PRIMARY KEY AUTO_INCREMENT',
			'title'     => 'varchar(200) NOT NULL',
			'body'      => 'text',
			'id_author' => 'int NOT NULL',
			//'status'    => 'tinyint(1) NOT NULL DEFAULT = 3',
			'status'    => 'tinyint(1)',
		));
		$this->addForeignKey('author', 'posts', 'id_author', 'users', 'id');
	}

	public function down()
	{
		//echo "m141007_122427_poststable_creation does not support migration down.\n";
		//return false;
		$this->dropTable('posts');
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
