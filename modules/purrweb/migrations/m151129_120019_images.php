<?php

use yii\db\Schema;
use yii\db\Migration;

class m151129_120019_images extends Migration
{
    /**
     * 
     * @return boolean
     */
    public function up()
    {
        $this->createTable(
            'images',
            array(
                'id'         => 'pk',
                'created'    => 'int',
                'modified'   => 'int',
                'published'  => 'int NOT NULL default 0',
                'sort'       => 'int NOT NULL default 0',

                'model'      => 'varchar(512)',
                'model_id'   => 'int',
                'modelClass' => 'varchar(512)',
                'field'      => 'varchar(512)',
                'filename'   => 'varchar(512)',
                'type'       => 'varchar(512)',
                'title'      => 'varchar(512)',
            ),
            ''
        );

        return true;
    }

    /**
     * 
     * @return boolean
     */
    public function down()
    {
        $this->dropTable('images');
        return false;
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
