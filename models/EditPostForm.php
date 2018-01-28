<?php

namespace app\models;

use Yii;
use yii\base\Model;


/**
 * Model for creating post with category and tags.
 * 
 * @property string $title
 * @property string $article
 * @property string $tags
 * @property string $category
 */
class EditPostForm extends Model
{
	public $title;
	public $article;
	public $tags;
	public $category;

	/**
	 * @inheritDoc
	 */
	public function rules()
	{
		return [
			[['title', 'article', 'category'], 'required'],
			[['article'], 'string'],
			[['title'], 'string', 'max' => 255],
			[['category'], 'string', 'max' => 255],
			[['tags'], 'string', 'max' => 255],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'title' => 'Заголовок',
			'article' => 'Статья',
			'tags' => 'Теги',
			'category' => 'Категория',
		];
	}

	/**
	 * Create post and edit category and tags.
	 *
	 * @return bool
	 */
	public function createPost()
	{
		if (Yii::$app->user->isGuest) {
			return false;
		}

		if (!$postId = $this->savePostTable()) {
			return false;
		}

		if (!$this->saveTagsTable($postId)) {
			return false;
		}

		return true;
	}

	/**
	 * Create model for post and finding or creating category.
	 *
	 * @return int id of post
	 */
	private function savePostTable()
	{
		$post = new Post();

		$post->body = $this->article;
		$post->title = $this->title;
		$post->created_at = date('Y-m-d H:i:s');
		$post->author_id = Yii::$app->user->getId();

		if (!$categoryDB = Category::findOne(['categ' => $this->category])) {
			$categoryDB = new Category();
			$categoryDB->categ = $this->category;

			if (!$categoryDB->save()) {
				$this->addErrors($categoryDB->getErrors());
				return false;
			}
		}
		$post->category_id = $categoryDB->id;

		if (!$post->save()) {
			$this->addErrors($post->getErrors());
			return false;
		}

		return $post->id;
	}

	/**
	 * Create or bind existing tags for post by id.
	 * Write in junction table tag and post.
	 *
	 * @param int $postId
	 * @return bool
	 */
	private function saveTagsTable($postId)
	{
		foreach (explode(',', $this->tags) as $value) {
			if (!$tempTag = TagForPost::findOne(['tag' => $value])) {
				$tempTag = new TagForPost();
				$tempTag->tag = $value;

				if (!$tempTag->save()) {
					$this->addErrors($tempTag->getErrors());
					return false;
				}
			}

			$junctionPostAndTag = new PostTagForPost();
			$junctionPostAndTag->post_id = $postId;
			$junctionPostAndTag->tag_for_post_id = $tempTag->id;
			$junctionPostAndTag->created_at = date('Y-m-d H:i:s');

			if (!$junctionPostAndTag->save()) {
				return false;
			}
		}

		return true;
	}
}
