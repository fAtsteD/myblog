<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\models\AdminUsers;
use app\models\Users;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['index'],
						'allow' => true,
						'roles' => ['admin'],
					],
					[
						'actions' => ['view'],
						'allow' => true,
						'roles' => ['admin'],
					],
					[
						'actions' => ['update'],
						'allow' => true,
						'roles' => ['updateUser'],
					],
					[
						'actions' => ['delete'],
						'allow' => true,
						'roles' => ['deleteUser'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
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
	 * Show list of all users
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$usersData = new AdminUsers();
		$dataProvider = $usersData->search(Yii::$app->request->queryParams);

		$roles = Yii::$app->authManager->getRoles();
		foreach ($roles as $role) {
			$allRoles[$role->name] = $role->name;
		}

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'usersData' => $usersData,
			'allRoles' => $allRoles,
		]);
	}

	/**
	 * Show data by id
	 *
	 * @param int $id
	 * @return string
	 * @throws NotFoundHttpException if user does not exist
	 */
	public function actionView($id)
	{
		if ($model = AdminUsers::findUser($id)) {
			return $this->render('view', ['model' => $model]);
		}

		throw new NotFoundHttpException("Такого пользователя не существует.");
	}

	public function actionUpdate($id)
	{
		$model = new AdminUsers();
		if ($model->load(Yii::$app->request->post()) && $model->updateData($id)) {
			return $this->redirect(['admin/view', 'id' => $id]);
		}

		if ($model = AdminUsers::findUser($id)) {
			$roles = Yii::$app->authManager->getRoles();
			foreach ($roles as $role) {
				$allRoles[$role->name] = $role->name;
			}
			
			return $this->render('update', [
				'model' => $model,
				'allRoles' => $allRoles,
			]);
		}

		throw new NotFoundHttpException("Такого пользователя не существует.");
	}

	/**
	 * Delete user by id
	 *
	 * @param int $id
	 * @return Response
	 * @throws NotFoundHttpException if user is not exist
	 */
	public function actionDelete($id)
	{
		if ($user = Users::findIdentity($id)) {
			$user->delete();

			return $this->redirect(['admin/index']);
		}

		throw new NotFoundHttpException("Такого пользователя не существует.");
	}
}
