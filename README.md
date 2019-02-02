# Blog

The site for blog created using framework Yii2 for myself. The app uses MySQL databases through ActiveRecord classes.

The app uses frameworks:
* Yii2
* Bootstrap

Functions that exist:
* Posts have title, body, state of public, tags and actions:
  * create by author
  * update by author or moderator
  * delete by author or moderator
* Users with registration, retrieve password, RBAC model and action:
  * create user
  * update user by user or admin
  * delete user by user or admin
* Admin panel is for handling users data
