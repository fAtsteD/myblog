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
use app\models\translationSource;
use app\models\translationMessageRU;
use yii\base\Model;

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
     * @return string
     */
    public function actionRegistrate()
    {
        $model = new Registrate();

        if ($model->load(Yii::$app->request->post()) && $user = $model->signUp()) {
            Yii::$app->session->setFlash('success', 'Регистрация успешна.');
            Yii::$app->user->login($user, 3600 * 24 * 30);
            return $this->goHome();
        }

        return Yii::$app->user->isGuest ? $this->render('registrate', ['model' => $model]) : $this->redirect(Yii::$app->homeUrl);
    }

    /**
     * Display translation page for site.
     *
     * @return string
     */
    public function actionTranslationSite()
    {
        $translatedMessages = \app\models\TranslationMessageRU::find()->indexBy('id')->all();
        $translationSource = \app\models\TranslationSource::find()->indexBy('id')->all();

        if (Model::loadMultiple($translatedMessages, Yii::$app->request->post()) && Model::validateMultiple($translatedMessages)) {
            foreach ($translatedMessages as $message) {
                if ($message['translation'] === '') {
                    $message['translation'] = null;
                }
                $message->save(false);
            }
            return $this->redirect('index');
        }

        return $this->render('translate', [
            'translatedMessages' => $translatedMessages,
            'translationSource' => $translationSource
        ]);
    }
}
