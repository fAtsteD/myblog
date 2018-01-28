<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `tag_for_post`.
 */
class M180127134344Create_tag_for_post_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tag_for_post', [
            'id' => $this->primaryKey(),
            'tag' => $this->string()->notNull()->unique(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tag_for_post');
    }
}
