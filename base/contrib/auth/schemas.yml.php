#<?php die()?>
detect_relations: true

User:
  tableName: auth_users
  actAs: [Timestampable]
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    is_active:
      type: integer(1)
      default: '1'
    group_id: integer(5)
    nickname: string(50)
    username: 
      type: string(50)
      notnull: true
    password: 
      type: string(255)
      notnull: true

  indexes:
    uniindex:
      fields: username, nickname
      type: unique
    user_index:
      fields: [is_active, nickname, username]
  attributes:
    validate: true
    
Role:
  tableName: auth_role
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    name: string(255)
    alias: string(50)
  relations:
    Users:
      foreignAlias: Role
      class: User
      refClass: UserRole
  indexes:
    alias:
      fields: alias
      type: unique
  
UserRole:
  tableName: auth_roles_users
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    role_id:
      type: integer(4)
      primary: true
    user_id:
      type: integer(4)
      primary: true
  indexes:
    ids:
      fields: [user_id, role_id]
  relations:
    Role:
      local: role_id
      foreign: id
      foreignAlias: UserRole
    User:
      local: user_id
      foreign: id
      foreignAlias: UserRole


Group:
  tableName: auth_groups
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    name:
      type: string(255)
  indexes:
    group_index:
      fields: name
      type:   unique
  attributes:
    validate: true

    
ACLMap:
  tableName: auth_acl_map
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    #ACL ID, foreign
    acl_id: integer(4)
    #对象ID
    object_id: integer(11)
    #对象类型， 比如user, group, role
    object_type: string(50)
    #是否拥有权限
    permission: integer(1)
  indexes:
    ids_index:
      fields: [acl_id, object_id, permission]
  relations:
    ACL:
      foreign: id
      local: acl_id
    Group:
      foreign: id
      local: object_id
    User:
      foreign: id
      local: object_id
    
    
ACL:
  tableName: auth_acl
  columns:
    #object 可以是一个action或者是某个对象的一部分， 比如具体到某个栏目，通过object_type控制
    object: string(255)
    object_type: string(50)
    name: string(255)
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  indexes:
    objects:
      fields: [object, object_type]


