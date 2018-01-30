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
 * @property int $categoryId
 * @property bool $show
 */
class EditPostForm extends Model
{
	public $title;
	public $article;
	public $tags;
	public $categoryId;
	public $show;

	/**
	 * @inheritDoc
	 */
	public function rules()
	{
		return [
			[['title', 'article', 'categoryId'], 'required'],
			[['article'], 'string'],
			[['title'], 'string', 'max' => 255],
			[['categoryId'], 'integer'],
			[['tags'], 'string', 'max' => 255],
			[['show'], 'boolean'],
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
			'categoryId' => 'Категория',
			'show' => 'Показывать',
		];
	}

	/**
	 * Create post and edit category and tags.
	 *
	 * @return bool
	 */
	public function createPost()
	{
		if (!$postId = $this->savePostTable(false)) {
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
	 * @param int|bool $postId id of post, if it does not exist - false
	 * @return int id of post
	 */
	private function savePostTable($postId)
	{
		if ($postId) {
			$post = Post::findOne($postId);
		} else {
			$post = new Post();
		}

		$post->body = $this->article;
		$post->title = $this->title;
		$post->created_at = date('Y-m-d H:i:s');
		$post->author_id = Yii::$app->user->getId();
		$post->show = ($this->show) ? 't' : 'f';

		if (!$categoryDB = Category::findOne($this->categoryId)) {
			$this->addError('categoryId', 'Такой категории не существует.');
			return false;
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

	/**
	 * Find post by id and initialize this class's properties.
	 *
	 * @param int $postId id of post
	 * @return bool
	 */
	public function findPost($postId)
	{
		if (!$post = Post::findOne($postId)) {
			return false;
		}

		$this->title = $post->title;
		$this->article = $post->body;
		$this->categoryId = $post->category_id;

		$this->show = ($post->show === 't') ? true : false ;

		foreach ($post->tagForPosts as $value) {
			$this->tags .= $value->tag . ',';
		}
		$this->tags = substr($this->tags, 0, -1);

		return true;
	}

	/**
	 * Update data of post.
	 *
	 * @param int $postId id of post
	 * @return bool
	 */
	public function updatePost($postId)
	{
		if (!$this->savePostTable($postId)) {
			return false;
		}

		PostTagForPost::deleteAll(['post_id' => $postId]);
		if (!$this->saveTagsTable($postId)) {
			return false;
		}

		return true;
	}
}
