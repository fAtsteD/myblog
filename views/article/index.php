<?php
/* @var $this yii\web\View */
/* @var $model app\models\Post */

use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\models\Post;
use yii\helpers\Inflector;

$this->title = 'Блог Андрея';
$dataProvider = new ActiveDataProvider([
    'query' => Post::find()->where(['show' => 't']),
    'pagination' => [
        'pageSize' => 10,
    ],
    'sort' => [
        'defaultOrder' => [
            'created_at' => SORT_DESC,
        ],
    ],
]);?>
<div class="default-index">
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_post',
    'layout' => "{items}\n{pager}",
]);?>
</div>
