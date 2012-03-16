#<?php die()?>

detect_relations: true

Workflow:
  tableName: workflow
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    name: string(255)
    action: string(255)
    sequence: integer(1)
    roles: string(255)
    display:
      type: integer(1)
      default: '1'
  indexes:
    select:
      fields: [sequence, roles, display]