<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post_tag_for_post`.
 * Has foreign keys to the tables:
 *
 * - `post`
 * - `tag_for_post`
 */
class M180127135429Create_junction_table_for_post_and_tag_for_post_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('post_tag_for_post', [
            'post_id' => $this->integer(),
            'tag_for_post_id' => $this->integer(),
            'created_at' => $this->dateTime()->notNull(),
            'PRIMARY KEY(post_id, tag_for_post_id)',
        ]);

        // creates index for column `post_id`
        $this->createIndex(
            'idx-post_tag_for_post-post_id',
            'post_tag_for_post',
            'post_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-post_tag_for_post-post_id',
            'post_tag_for_post',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );

        // creates index for column `tag_for_post_id`
        $this->createIndex(
            'idx-post_tag_for_post-tag_for_post_id',
            'post_tag_for_post',
            'tag_for_post_id'
        );

        // add foreign key for table `tag_for_post`
        $this->addForeignKey(
            'fk-post_tag_for_post-tag_for_post_id',
            'post_tag_for_post',
            'tag_for_post_id',
            'tag_for_post',
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
            'fk-post_tag_for_post-post_id',
            'post_tag_for_post'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            'idx-post_tag_for_post-post_id',
            'post_tag_for_post'
        );

        // drops foreign key for table `tag_for_post`
        $this->dropForeignKey(
            'fk-post_tag_for_post-tag_for_post_id',
            'post_tag_for_post'
        );

        // drops index for column `tag_for_post_id`
        $this->dropIndex(
            'idx-post_tag_for_post-tag_for_post_id',
            'post_tag_for_post'
        );

        $this->dropTable('post_tag_for_post');
    }
}
