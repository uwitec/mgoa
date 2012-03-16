#<?php die();?>

reason:
  type: textarea
  style: 'width:400px;height:60px;'
  label: '请假原因'
  help_text: '请输入请假原因'

type:
  type: select
  label: '请假类型'
  options:
    -
      label: 病假
      value: 病假
    -
      label: 事假
      value: 事假
    -
      label: 婚假
      value: 婚假
    -
      label: 产假
      value: 产假
    -
      label: 陪护假
      value: 陪护假
    -
      label: 丧假
      value: 丧假
      
leave_time:
  type: datepicker
  label: '开始时间'

end_time:
  type: datepicker
  label: '结束时间'