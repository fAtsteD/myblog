<?php

namespace app\models;

use yii\base\Model;
use Yii;



class Translation extends Model
{
	public function getTranslationSourceData()
	{
		return TranslationSource::findAll();
	}

	public function translate()
	{
		$translatedMessage = new TranslationMessageRU();
		$sql = '';


		
		return Yii::$app->db->createCommand($sql);
	}
}
