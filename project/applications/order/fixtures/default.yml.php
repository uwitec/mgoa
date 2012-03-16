#<?php die();?>

Workflow:
  insert_new_order:
    name: '录入订单'
    alias: '录入订单'
    action: order/new
    sequence: 0
    roles: ',1,'
    display: 1
  one:
    name: '新增订单管理'
    alias: '新增订单管理'
    action: order/list/2
    sequence: 1
    roles: ',1,2,3,'
    display: 1
    state: '新录入订单'

  two:
    name: '跟进订单管理'
    alias: '跟进订单管理'
    action: order/workflow/followed
    sequence: 2
    roles: ',2,3,'
    display: 1
    state: '跟进中'

  three:
    name: '长期跟进订单'
    alias: '长期跟进订单'
    action: order/workflow/long_followed
    sequence: 3
    roles: ',2,3,'
    display: 1
    state: '长期跟进中'
    Parent: four

  fu_one:
    name: '拉黑订单管理'
    alias: '拉黑订单管理'
    action: order/workflow/blacklist
    sequence: 4
    roles: ',2,3,'
    display: 1
    state: '被拉黑'

  four:
    name: '签约订单管理'
    alias: '签约订单管理'
    action: order/workflow/ordered
    sequence: 5
    roles: ',2,3,5,6,7,8,'
    display: 1
    state: '已签约，等待首付款'

  first_payment:
    name: '新增财务订单'
    alias: '新增财务订单'
    action: order/list/7
    sequence: 6
    roles: ',4,'
    display: 1
    Parent: four
    template: order/list_payment
    state: '等待财务确认首付款'

  wait_down:
    name: '等待下单'
    alias: '等待下单'
    action: order/list/8
    sequence: 7
    roles: ',3,4,'
    display: 0
    Parent: four
    state: '等待下单'

  tech_manager:
    name: '待选择设计师'
    alias: '待技术经理分配'
    action: order/list/9
    sequence: 8
    roles: ',5,'
    display: 0
    Parent: four
    state: '待选择设计师'

  index_design:
    name: '首页设计'
    alias: '首页设计'
    action: order/list/10
    sequence: 9
    roles: ',5,6,'
    display: 0
    Parent: four
    state: '首页设计中'
    
  index_design_end:
    name: '首页设计完成'
    alias: '首页设计完成'
    action: order/list/11
    sequence: 10
    roles: ',5,6,9,'
    display: 0
    Parent: four
    state: '首页设计完成，等待客户确认'

  index_design_decide:
    name: '首页确认'
    alias: '首页确认'
    action: order/list/12
    sequence: 11
    roles: ',5,6,9,'
    display: 0
    state: '首页已经确认，等待二期款项'
    Parent: four

  second_pay:
    name: '等待二期款项'
    alias: '等待二期款项'
    action: order/list/13
    sequence: 12
    roles: ',2,3,5,'
    display: 0
    state: '等待客户支付二期款项'
    Parent: four

  confirm_second_pay:
    name: '二期款项确认'
    alias: '二期款项确认'
    action: order/list/14
    sequence: 13
    roles: ',4,'
    display: 0
    state: '等待财务确认二期款项'
    Parent: four
    template: order/list_payment

  other_design:
    name: '内页设计'
    alias: '内页设计'
    action: order/list/15
    sequence: 14
    roles: ',2,3,5,6,9,'
    display: 1
    state: '正在制作内页效果图'
    Parent: four

  inner_design_complete:
    name: '内页设计完成'
    alias: '内页设计完成'
    action: order/list/16
    sequence: 15
    roles: ',2,3,5,6,9,'
    display: 1
    state: '内页设计完成，等待客户确认'
    Parent: four

  inner_design_confirm:
    name: '内页设计确认'
    alias: '内页设计确认'
    action: order/list/17
    sequence: 16
    roles: ',5,9,'
    display: 1
    state: '内页已经确认，开始布局'
    Parent: four

  six:
    name: '布局任务'
    alias: '布局任务'
    action: order/list/18
    sequence: 17
    roles: ',2,3,5,7,9,'
    display: 1
    state: '正在布局'
    Parent: four

  seven:
    name: '程序任务'
    alias: '程序任务'
    action: order/list/19
    sequence: 18
    roles: ',2,3,5,8,9,'
    display: 1
    state: '布局完成，正在制作程序'
    Parent: four

  program_end:
    name: '程序制作完成'
    alias: '程序制作完成'
    action: order/list/20
    sequence: 19
    roles: ',2,3,5,8,9,'
    display: 1
    state: '程序制作完成，等待客户验收'
    Parent: four

  program_decide:
    name: '程序验收完成'
    alias: '程序验收完成'
    action: order/list/21
    sequence: 20
    roles: ',2,3,5,8,9,'
    display: 1
    state: '程序验收完成，等待客户付尾款'
    Parent: four

  last_pay:
    name: '尾款提交确认'
    alias: '尾款提交确认'
    action: order/list/22
    sequence: 21
    roles: ',2,3,4,5,'
    display: 1
    state: '尾款已提交财务确认'
    Parent: four
    template: order/list_payment

  last_pay_confirm:
    name: '尾款确认'
    alias: '尾款确认'
    action: order/list/23
    sequence: 22
    roles: ',2,3,4,5,6,7,8,11,'
    display: 1
    state: '尾款已到账，安排上线'
    Parent: four

  publish:
    name: '已经上线'
    alias: '已经上线'
    action: order/list/24
    sequence: 23
    roles: ',2,3,4,5,6,7,8,11,'
    display: 1
    state: '已经上线，订单流程完成'
    Parent: four
