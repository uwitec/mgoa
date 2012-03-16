#<?php die();?>

Forms:
  tableName: form_data
  actAs: [Timestampable]

  columns:
    user_id: integer(11)
    state: integer(4)
    form_data: text
  indexes:
    user:
      fields: [user_id]
#  relations:
#    User:
#      local: user_id
#      foreign: id