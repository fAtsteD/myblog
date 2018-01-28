<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment_for_post".
 *
 * @property int $id
 * @property int $post_id
 * @property int $answer_to
 * @property string $comment
 * @property string $created_at
 *
 * @property Post $post
 */
class CommentForPost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment_for_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'comment', 'created_at'], 'required'],
            [['post_id', 'answer_to'], 'integer'],
            [['comment'], 'string'],
            [['created_at'], 'safe'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'answer_to' => 'Answer To',
            'comment' => 'Comment',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}
