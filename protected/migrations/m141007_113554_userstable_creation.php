<?php

class m141007_113554_userstable_creation extends CDbMigration
{
	public function up()
	{
		$this->createTable('users', array(
			'id'     => 'int not null primary key auto_increment',
			'login'  => 'varchar(20) not null unique key',
			'email'	 => 'varchar(60) not null unique key',
			'pass'	 => 'varchar(20) not null',
			'pic'	 => 'varchar(30)',	
		));
	}

	public function down()
	{
		//echo "m141007_113554_userstable_creation does not support migration down.\n";
		//return false;

		$this->dropTable('users');
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
