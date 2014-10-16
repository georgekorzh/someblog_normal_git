<?php

class m141016_073608_creation_of_norm_comm_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('comments', array(
            'id'	   => 'int NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'comment'  => 'text NOT NULL',
            'post_id'  => 'int not null',
            'author_id'  => 'int not null',
            'parent'   => 'int'
        ));
        $this->addForeignKey('post_num', 'comments', 'id_post', 'posts', 'id');
        $this->addForeignKey('answer_or_not', 'comments', 'parent', 'comments', 'id');
        $this->addForeignKey('author_id', 'comments', 'authoe_id', 'users', 'id');
	}

	public function down()
	{
        $this->dropTable('comments');
		//echo "m141016_073608_creation_of_norm_comm_table does not support migration down.\n";
		//return false;
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