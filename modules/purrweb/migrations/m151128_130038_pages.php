<?php

use yii\db\Schema;
use yii\db\Migration;

class m151128_130038_pages extends Migration
{
    /**
     * 
     * @return boolean
     */
    public function up()
    {
        $this->createTable(
            'pages',
            [
                'id'        => 'pk',
                'title'     => 'string',
                'details'   => 'text',
                'published' => 'int not null default 0',
                'sort'      => 'int',
                'created'   => 'int',
                'modified'  => 'int'
            ]
        );

        return true;
    }

    /**
     * 
     * @return boolean
     */
    public function down()
    {
        $this->dropTable('pages');
        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
