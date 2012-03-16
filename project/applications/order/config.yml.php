#<?php exit();?>

operation:
  sequence_1:
    -
      label:  '联系客户'
      action: order/contact
      role:
        - '销售经理'
        - '销售顾问'
    -
      label:  '拉黑订单'
      action: order/blacklist
      role:
        - '销售经理'
        - '销售顾问'
  sequence_2:
    -
      label:  '签约订单'
      action: order/contract
      role:
        - '销售经理'
        - '销售顾问'
    -
      label:  '长期跟进'
      action: order/follow
      role:
        - '销售经理'
        - '销售顾问'
    -
      label:  '拉黑订单'
      action: order/blacklist
      role:
        - '销售经理'
        - '销售顾问'
  sequence_4:
    -
      label: '复活订单'
      action: order/chunge
      role:
        - '销售经理'
        - '销售顾问'
  sequence_6:
    -
      label:  '确认收款'
      action: order/first_pay
      role: '财务'
    -
      label:  '驳回收款'
      action: order/disallow_pay
      role: '财务'
  sequence_7:
    -
      label:  '下单'
      action: order/order_it
      role: '销售经理'
  sequence_8:
    -
      label:  '选择设计师'
      action: order/select_designer
      role:
        - '技术经理'
        - '客户'
  sequence_9:
    -
      label:  '开始设计首页'
      action: work/start/index_design
      role: '设计师'
    -
      label:  '完成首页设计'
      action: work/end/index_design
      role: '设计师'
  sequence_11:
    -
      label:  '提交财务二期款项'
      action: order/second_pay
      role:
        - '销售经理'
        - '销售顾问'
  sequence_13:
    -
      label:  '确认二期款项'
      action: order/second_pay_confirm
      role: '财务'
  sequence_14:
    -
      label:  '开始内页设计'
      action: work/start/inner_design
      role: '设计师'
    -
      label:  '内页设计完成'
      action: work/end/inner_design
      role: '设计师'
  sequence_17:
    -
      label:  '开始布局'
      action: work/start/layout
      role: '布局师'
    -
      label:  '布局完成'
      action: work/end/layout
      role: '布局师'
  sequence_18:
    -
      label:  '开始制作程序'
      action: work/start/programe
      role: '程序员'
    -
      label:  '制作程序完成'
      action: work/end/programe
      role: '程序员'

  sequence_20:
    -
      label:  '提交财务确认尾款'
      action: order/last_pay
      role:
        - '销售经理'
        - '销售顾问'

  sequence_21:
    -
      label:  '确认尾款'
      action: order/last_pay_confirm
      role: '财务'
    -
      label:  '驳回尾款'
      action: order/last_pay
      role: '财务'
  sequence_22:
    -
      label:  '上线'
      action: order/publish
      role: '售后经理'