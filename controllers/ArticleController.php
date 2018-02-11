<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use app\models\EditPostForm;
use app\models\Post;
use app\models\Users;


class ArticleController extends Controller
{
    public $layout = 'article';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'create-post',
                    'edit-post',
                ],
                'rules' => [
                    [
                        'actions' => ['create-post'],
                        'allow' => true,
                        'roles' => ['createPost'],
                    ],
                    [
                        'actions' => ['edit-post'],
                        'allow' => true,
                        'roles' => ['updatePost'],
                        'roleParams' => [
                            'post' => Post::findOne(Yii::$app->request->get('id')),
                        ]
                    ],

                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Creating post.
     *
     * @return Response|string
     */
    public function actionCreatePost()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        $this->layout = 'main';

        $model = new EditPostForm();

        if ($model->load(Yii::$app->request->post()) && $model->createPost()) {
            return $this->goHome();
        }

        return $this->render('createPost', [
            'model' => $model,
        ]);
    }

    /**
     * Udating informotion of post.
     *
     * @param int $id
     * @return Exception|Response|string
     */
    public function actionEditPost($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        $this->layout = 'main';

        $model = new EditPostForm();

        if ($model->load(Yii::$app->request->post()) && $model->updatePost($id)) {
            return $this->goHome();
        }

        if (!$model->findPost($id)) {
            throw new NotFoundHttpException('Такой статьи не существует.');
        }

        return $this->render('editPost', [
            'model' => $model,
        ]);
    }

    /**
     * Show post by id
     *
     * @param int $id id of post
     * @return Exception|string
     */
    public function actionPost($id)
    {
        if (!$model = Post::findOne($id)) {
            throw new NotFoundHttpException('Такой статьи не существует.');
        }

        return $this->render('postView', [
            'model' => $model,
        ]);
    }
}
