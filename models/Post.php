<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $author_id
 * @property int $category_id
 * @property string $title
 * @property string $body
 * @property string $created_at
 * @property string $show
 *
 * @property CommentForPost[] $commentForPosts
 * @property Users $author
 * @property Category $category
 * @property PostTagForPost[] $postTagForPosts
 * @property TagForPost[] $tagForPosts
 */
class Post extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'title', 'body', 'created_at'], 'required'],
            [['author_id', 'category_id'], 'integer'],
            [['body'], 'string'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['show'], 'string', 'max' => 1],
            [['show'], 'in', 'range' => ['f', 't']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'body' => 'Body',
            'created_at' => 'Created At',
            'show' => 'Show',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentForPosts()
    {
        return $this->hasMany(CommentForPost::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Users::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTagForPosts()
    {
        return $this->hasMany(PostTagForPost::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagForPosts()
    {
        return $this->hasMany(TagForPost::className(), ['id' => 'tag_for_post_id'])->viaTable('post_tag_for_post', ['post_id' => 'id']);
    }
}
