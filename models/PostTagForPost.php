<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_tag_for_post".
 *
 * @property int $post_id
 * @property int $tag_for_post_id
 * @property string $created_at
 *
 * @property Post $post
 * @property TagForPost $tagForPost
 */
class PostTagForPost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_tag_for_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'tag_for_post_id', 'created_at'], 'required'],
            [['post_id', 'tag_for_post_id'], 'integer'],
            [['created_at'], 'safe'],
            [['post_id', 'tag_for_post_id'], 'unique', 'targetAttribute' => ['post_id', 'tag_for_post_id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['tag_for_post_id'], 'exist', 'skipOnError' => true, 'targetClass' => TagForPost::className(), 'targetAttribute' => ['tag_for_post_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'tag_for_post_id' => 'Tag For Post ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagForPost()
    {
        return $this->hasOne(TagForPost::className(), ['id' => 'tag_for_post_id']);
    }
}
