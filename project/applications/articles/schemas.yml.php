#<?php die()?>

detect_relations: true

Category:
  tableName: article_categories
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    name: string(255)
    alias: string(50)
    parent_id:
      type: integer(4)
      default: 0
    manager:
      type: string(50)
      default: ',10,'
  indexes:
    alias:
      fields: [alias, manager]
      type: unique

Article:
  tableName: articles
  actAs: [Timestampable]
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    name: string(255)
    category_id: integer(4)
    content: text
    author_id: integer(11)
    alias: string(255)
  indexes:
    nasha:
      fields: [category_id, name, author, alias]
  relations:
    User:
      class: User
      local: author
      foreign: id
      foreignAlias: Author
