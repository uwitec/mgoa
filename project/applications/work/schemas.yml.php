#<?php die()?>
################订单工作内容
OrderWork:
  tableName: order_work
  actAs: [Timestampable]
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    order_id: integer(11)
    user_id : integer(11)
    # 类型， 首页设计， 内页设计， 布局， 程序
    type: string(25)
    # 进度(百分比)
    process: integer(3)
    # 工作内容
    content: text
  indexes:
    query:
      fields: [order_id, user_id, type, process]
  relations:
    Order:
      local: order_id
      foreign: id
    User:
      local: user_id
      foreign: id