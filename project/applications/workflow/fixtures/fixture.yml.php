#<?php die()?>

Workflow:
  one:
    name: '新增订单'
    action: order/new
    sequence: 1
    roles: ',1,2,'
    display: 1

  two:
    name: '跟进订单'
    action: order/new
    sequence: 1
    roles: ',1,2,'
    display: 1
    
  three:
    name: '长期跟进订单'
    action: order/new
    sequence: 1
    roles: ',1,2,'
    display: 1

  fu_one:
    name: '拉黑订单'
    action: order/new
    sequence: 1
    roles: ',1,2,'
    display: 1

  four:
    name: '签约订单'
    action: order/new
    sequence: 1
    roles: ',1,2,'
    display: 1

  five:
    name: '设计任务'
    action: order/new
    sequence: 1
    roles: ',1,2,'
    display: 1

  six:
    name: '布局任务'
    action: order/new
    sequence: 1
    roles: ',1,2,'
    display: 1

  seven:
    name: '程序任务'
    action: order/new
    sequence: 1
    roles: ',1,2,'
    display: 1

  eight:
    name: '完成订单'
    action: order/new
    sequence: 1
    roles: ',1,2,'
    display: 1

  nine:
    name: '设计任务'
    action: order/new
    sequence: 1
    roles: ',1,2,'
    display: 1
