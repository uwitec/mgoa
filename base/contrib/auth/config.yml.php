#<?php die();?>
dependent: []

plugins:
  before_application_run:
    check_permission: system/contrib/auth/plugins.AuthPlugins::check_action_ACL

  before_template_render:
    userinfo: system/contrib/auth/plugins.AuthPlugins::userinfo

USE_RBAC: false
