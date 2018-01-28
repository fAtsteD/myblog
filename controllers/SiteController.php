<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Registrate;
use app\models\Users;
use yii\helpers\Url;
use app\models\RegistrateForm;
use app\models\RetrievePasswordForm;
use app\models\ViewAndUpdateForm;
use yii\web\NotFoundHttpException;
use app\models\EditPostForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete-user' => ['post'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Display form for registration
     *
     * @return Response|string
     */
    public function actionRegistrate()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrateForm();

        if ($model->load(Yii::$app->request->post()) && $user = $model->signUp()) {
            Yii::$app->session->setFlash('success', 'Регистрация успешна.');
            Yii::$app->user->login($user, 3600 * 24 * 30);
            return $this->goHome();
        }

        return $this->render('registrate', [
            'model' => $model
        ]);
    }

    /**
     * Retrieve password action. First user type "username",
     * then he get link with token, where he type new password.
     *
     * @param string $token
     * @return Response|string
     */
    public function actionRetrievePassword($token = null)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RetrievePasswordForm();
        $model->scenario = RetrievePasswordForm::SCENARIO_FIND_USERNAME;

        if ($token) {
            $model->scenario = RetrievePasswordForm::SCENARIO_RETRIEVE_PASSWORD;
            if ($model->load(Yii::$app->request->post()) && $user = $model->retrievePassword($token)) {
                Yii::$app->user->login($user, 3600 * 24 * 30);
                return $this->goHome();
            }
            return $this->render('retrievePassword', [
                'model' => $model
            ]);
        } elseif ($model->load(Yii::$app->request->post()) && $user = $model->findUser()) {
            Yii::$app->session->setFlash('warning', 'Для восстановления пароля перейдите по <a href="'
                . Url::toRoute(['site/retrieve-password', 'token' => $user->token_retrieve_password], true)
                . '">ссылке</a>.');
            return $this->goHome();
        } else {
            return $this->render('retrievePassword', [
                'model' => $model
            ]);
        }
    }

    /**
     * Watching profile and edit, if you have permission.
     *
     * @param int $id
     * @return Response|string
     */
    public function actionProfile($id)
    {
        $model = new ViewAndUpdateForm();
        if (!$model->getInfo($id)) {
            throw new NotFoundHttpException('Такого пользователя не существует.');
        }

        if ($model->load(Yii::$app->request->post()) && $user = $model->changeData($id)) {
            return $this->refresh();
        }

        return $this->render('profile', [
            'model' => $model
        ]);
    }

    /**
     * Delete user from users.
     *
     * @return Response
     */
    public function actionDeleteUser()
    {
        $user = Yii::$app->user->identity;
        Yii::$app->user->logout();
        $user->delete();

        return $this->goHome();
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

        $model = new EditPostForm();

        if ($model->load(Yii::$app->request->post()) && $model->createPost())
        {
            return $this->goHome();
        }

        return $this->render('createPost', [
            'model' => $model,
        ]);
    }
}
