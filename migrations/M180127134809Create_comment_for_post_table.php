<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `comment_for_post`.
 * Has foreign keys to the tables:
 *
 * - `post`
 */
class M180127134809Create_comment_for_post_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('comment_for_post', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'answer_to' => $this->integer()->null(),
            'comment' => $this->text()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
        ]);

        // creates index for column `post_id`
        $this->createIndex(
            'idx-comment_for_post-post_id',
            'comment_for_post',
            'post_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-comment_for_post-post_id',
            'comment_for_post',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `post`
        $this->dropForeignKey(
            'fk-comment_for_post-post_id',
            'comment_for_post'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            'idx-comment_for_post-post_id',
            'comment_for_post'
        );

        $this->dropTable('comment_for_post');
    }
}
