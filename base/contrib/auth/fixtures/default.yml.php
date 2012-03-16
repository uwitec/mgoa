#<?php exit();?>
User:
  kefu:
    username: '戴越'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [kefu]
    Group: [kefu]
  liqingxi:
    username: '李庆喜'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [xiaoshoujingli, zongjingli]
  fengchanghe:
    username: '冯昌合'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [zongjingli]
  zhangxinglun:
    username: '张兴伦'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [xiaoshouguwen]
  zhaofengyan:
    username: '钊凤艳'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [xiaoshouguwen]
  renjing:
    username: '任静'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [caiwu]
  lutiezhu:
    username: '逯铁柱'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [jishujingli]
  fujiyun:
    username: '傅积云'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [shejishi]
  liangmingming:
    username: '梁明明'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [shejishi]
  wangjinzhi:
    username: '王金枝'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [shejishi]
  zhaojian:
    username: '赵建'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [shejishi]
  yuanming:
    username: '袁明'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [bujushi]
  yangyafei:
    username: '杨亚飞'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [bujushi]
  libiao:
    username: '李彪'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [chengxuyuan]
  zhanglei:
    username: '张磊'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [chengxuyuan]
  yanzhipeng:
    username: '闫志鹏'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [chengxuyuan]
  kehu:
    username: '客户1'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [kehu]
  renzi:
    username: '王文影'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [renzi]
  wangshuzhi:
    username: '王树枝'
    password: sha1$#!Cec$67916833ece61828de120da1b6959fef2ff44651
    Role: [shouhoujingli]

Group:
  kefu:
    name: '客服'
  renzi:
    name: '人力资源'
  xiaoshou1:
    name: '销售一部'
  xiaoshou2:
    name: '销售二部'
  jishu:
    name: '技术部'
  shouhou:
    name: '售后部'
    
Role:
  kefu:
    name: '客服'
    alias: '客服'
  xiaoshoujingli:
    name: '销售经理'
    alias: '销售经理'
  xiaoshouguwen:
    name: '销售顾问'
    alias: '销售顾问'
  caiwu:
    name: '财务'
    alias: '财务'
  jishujingli:
    name: '技术经理'
    alias: '技术经理'
  shejishi:
    name: '设计师'
    alias: '设计师'
  bujushi:
    name: '布局师'
    alias: '布局师'
  chengxuyuan:
    name: '程序员'
    alias: '程序员'
  kehu:
    name: '客户'
    alias: '客户'
  shouhoujingli:
    name: '售后经理'
    alias: '售后经理'
  renzi:
    name: '人力资源'
    alias: '人力资源'
  zongjingli:
    name: '总经理'
    alias: '总经理'


ACL:
  add_order:
    object: order/new
    object_type: action
  orders_list:
    object: order/list
    object_type: action
  follow_orders:
    object: order/list/workflow/2
    object_type: action
  block_orders:
    object: order/list/workflow/3
    object_type: action
  view_customer_info:
    object: order/customer_detail
    object_type: action
  view_order_detail:
    object: order/detail
    object_type: action
  contact_customer:
    object: order/contact
    object_type: action

ACLMap:
  kefu_add_order:
    ACL: add_order
    object_id: 1
    object_type: role
    permission: 1
  xiaoshou_see_new_order:
    ACL: orders_list
    object_id: 2
    object_type: role
    permission: 1
  kef_see_order_list:
    ACL: orders_list
    object_id: 1
    object_type: role
    permission: 1
  xiaoshou_view_customer_detail:
    ACL: view_customer_info
    object_id: 2
    object_type: role
    permission: 1
  xiaoshou_see_order_detail:
    ACL: view_order_detail
    object_id: 2
    object_type: role
    permission: 1
  contact__customer:
    ACL: contact_customer
    object_id: 2
    object_type: role
    permission: 1
  contact__customer1:
    ACL: contact_customer
    object_id: 3
    object_type: role
    permission: 1
