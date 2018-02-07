<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\helpers\Url;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Registrate;
use app\models\Users;
use app\models\RegistrateForm;
use app\models\RetrievePasswordForm;
use app\models\ViewAndUpdateForm;

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
                'only' => [
                    'logout',
                    'delete-user',
                ],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['registrateUser'],
                    ],
                    [
                        'actions' => ['delete-user'],
                        'allow' => true,
                        'roles' => ['deleteUser'],
                        'roleParams' => [
                            'userId' => Users::findOne(['id' => Yii::$app->user->getId()]),
                        ]
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
            return $this->refresh();
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('login', [
                'model' => $model,
            ]);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
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
            return $this->refresh();
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('registrate', [
                'model' => $model
            ]);
        } else {
            return $this->render('registrate', [
                'model' => $model
            ]);
        }
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
}
