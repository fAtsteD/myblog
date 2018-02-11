<?php

//use Yii;
use yii\db\Migration;
use app\rbac\AuthorPostRule;
use app\rbac\DataUserRule;

/**
 * Class m180205_153956_init_rbac
 */
class m180205_153956_init_rbac extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        $permissions = [];

        // Rules
        $ruleOwnPost = new AuthorPostRule();
        $auth->add($ruleOwnPost);

        $ruleOwnUser = new DataUserRule();
        $auth->add($ruleOwnUser);

        // Permissions for post
        $permissions['createPost'] = $auth->createPermission('createPost');
        $permissions['createPost']->description = 'Create a post.';

        $permissions['updatePost'] = $auth->createPermission('updatePost');
        $permissions['updatePost']->description = 'Update a post.';

        $permissions['updateOwnPost'] = $auth->createPermission('updateOwnPost');
        $permissions['updateOwnPost']->description = 'Update own post.';
        $permissions['updateOwnPost']->ruleName = $ruleOwnPost->name;

        $permissions['deletePost'] = $auth->createPermission('deletePost');
        $permissions['deletePost']->description = 'Delete a post.';

        $permissions['deleteOwnPost'] = $auth->createPermission('deleteOwnPost');
        $permissions['deleteOwnPost']->description = 'Delete own post.';
        $permissions['deleteOwnPost']->ruleName = $ruleOwnPost->name;

        // Permissions for user
        $permissions['updateUser'] = $auth->createPermission('updateUser');
        $permissions['updateUser']->description = 'Update data of a user.';

        $permissions['updateOwnUser'] = $auth->createPermission('updateOwnUser');
        $permissions['updateOwnUser']->description = 'Update the user\'s data.';
        $permissions['updateOwnUser']->ruleName = $ruleOwnUser->name;

        $permissions['deleteUser'] = $auth->createPermission('deleteUser');
        $permissions['deleteUser']->description = 'Delete a user.';

        $permissions['deleteOwnUser'] = $auth->createPermission('deleteOwnUser');
        $permissions['deleteOwnUser']->description = 'Delete the user\'s profile.';
        $permissions['deleteOwnUser']->ruleName = $ruleOwnUser->name;

        // Permissions for comment
        $permissions['createComment'] = $auth->createPermission('createComment');
        $permissions['createComment']->description = 'Create a comment for the post.';

        $permissions['deleteComment'] = $auth->createPermission('deleteComment');
        $permissions['deleteComment']->description = 'Delete a comment for the post.';

        foreach ($permissions as $key => $perm) {
            $auth->add($perm);
        }

        $auth->addChild($permissions['updateOwnPost'], $permissions['updatePost']);
        $auth->addChild($permissions['deleteOwnPost'], $permissions['deletePost']);
        $auth->addChild($permissions['updateOwnUser'], $permissions['updateUser']);
        $auth->addChild($permissions['deleteOwnUser'], $permissions['deleteUser']);

        // Roles
        $registrateUser = $auth->createRole('registrateUser');
        $auth->add($registrateUser);
        $auth->addChild($registrateUser, $permissions['createComment']);
        $auth->addChild($registrateUser, $permissions['updateOwnUser']);
        $auth->addChild($registrateUser, $permissions['deleteOwnUser']);

        $writer = $auth->createRole('writer');
        $auth->add($writer);
        $auth->addChild($writer, $registrateUser);
        $auth->addChild($writer, $permissions['createPost']);
        $auth->addChild($writer, $permissions['updateOwnPost']);
        $auth->addChild($writer, $permissions['deleteOwnPost']);

        $moderatorLow = $auth->createRole('moderatorLow');
        $auth->add($moderatorLow);
        $auth->addChild($moderatorLow, $writer);
        $auth->addChild($moderatorLow, $permissions['deleteComment']);

        $moderatorHigh = $auth->createRole('moderatorHigh');
        $auth->add($moderatorHigh);
        $auth->addChild($moderatorHigh, $moderatorLow);
        $auth->addChild($moderatorHigh, $permissions['updatePost']);
        $auth->addChild($moderatorHigh, $permissions['deletePost']);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $moderatorHigh);
        $auth->addChild($admin, $permissions['updateUser']);
        $auth->addChild($admin, $permissions['deleteUser']);

        // Give admin permissions for admin with id=1
        $auth->assign($admin, 1);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
