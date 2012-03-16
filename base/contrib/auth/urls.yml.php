# <?php die()?>

syncdb:
  action: AuthController.syncdb
  name: syncdb

#action
index:
  action: AuthController.index
  name: auth_index
  
register:
  action: AuthController.register
  name: auth_register

login:
  action: AuthController.login
  name: auth_login

forgot:
  action: AuthController.lost_password
  name: auth_forgot_password

logout:
  action: AuthController.logout
  name: auth_logout

change_password:
  action: AuthController.change_password

check_code:
  action: AuthController.check_code
