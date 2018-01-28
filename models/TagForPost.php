<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag_for_post".
 *
 * @property int $id
 * @property string $tag
 *
 * @property PostTagForPost[] $postTagForPosts
 * @property Post[] $posts
 */
class TagForPost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag_for_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag'], 'required'],
            [['tag'], 'string', 'max' => 255],
            [['tag'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag' => 'Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTagForPosts()
    {
        return $this->hasMany(PostTagForPost::className(), ['tag_for_post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['id' => 'post_id'])->viaTable('post_tag_for_post', ['tag_for_post_id' => 'id']);
    }
}
