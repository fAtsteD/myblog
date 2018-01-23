<?php

use yii\db\Migration;

/**
 * Handles adding tokenRetrievePassword to table `users`.
 */
class m180123_085428_add_tokenRetrievePassword_column_to_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('users', 'token_retrieve_password', $this->string()->null()->unique());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('users', 'token_retrieve_password');
    }
}
