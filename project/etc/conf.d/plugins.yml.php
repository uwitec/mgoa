#<?php die();?>

#before_application_run:
  #auth_check_csrf: system/share/security/csrf.CSRF::auto_check
  
before_template_render:
  load_the_lte: system/share/web/statics.Statics::output_lte