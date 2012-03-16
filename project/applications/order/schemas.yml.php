#<?php exit();?>
detect_relations: true

#############################
Customer:
  tableName: customers
  actAs: [Timestampable]
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    #地区
    areas: string(50)
    #负责人姓名
    name : string(50)
    #负责人职务
    duty: string(50)
    #公司名称
    company_name: string(255) 
    telephone: string(20)
    mobile: string(15) 
    qq: string(15)
    email: string(255)
    zip_no: string(10)
    #联系地址
    address: string(255)
    #客户资料
    docs: string(255)
    #card_no身份证号
    card_no: string(20)
    #其他信息
    remark: string(255)
    ##################企事业单位信息
    com_username: string(10)
    com_email: string(50)
    com_address: string(255)
    #工商局注册代码
    com_code: string(50)
    #组织机构代码证
    com_code2: string(50)
    #其他信息 serialize
    other_info: text
  relations:
    Group:
      local: group_id
      foreign: id
  
#############################
Order:
  tableName: orders
  actAs: [Timestampable]
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    customer_id: integer(11)
    workflow_id: integer(4)
    duration: integer(4)
    #类型， 貌似是个自己填的字段
    type: string(50)
    #分配到哪个销售部门
    group_id: integer(4)
    #客服ID
    customer_service_id: integer(4)
    #建站周期 天
    duration: integer(4)
    #销售顾问
    seller_id: integer(4)
    #设计师
    designer_id: integer(4)
    #布局
    layouter_id: integer(4)
    #程序
    programmer: integer(4)
    #预约时间
    subscribe_time: datetime
    #示例地址
    example_url: string(255)
    #客服沟通记录
    community_log: string(255)
    #合同附件
    paper_attachment: string(255)
  relations:
    Workflow:
      local: workflow_id
      foreign: id
    CustomerService:
      class: User
      local: customer_service_id
      foreign: id
    Seller:
      class: User
      local: seller_id
      foreign: id
    Designer:
      class: User
      local: designer_id
      foreign: id
    Layouter:
      class: User
      local: layouter_id
      foreign: id
    Programmer:
      class: User
      local: programmer_id
      foreign: id
      
      
  indexes:
    select:
      fields: [customer_id, workflow_id, customer_service_id, seller_id, designer_id, layouter_id]

#############################
Communication:
  tableName: communication
  actAs: [Timestampable]
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    user_id: integer(11)
    order_id: integer(11)
    content: text
  indexes:
    query:
      fields: [user_id, order_id]
  relations:
    User:
      local: user_id
      foreign: id

#############################
Solution:
  tableName: solutions
  actAs: [Timestampable]
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    order_id: integer(11)
    state: integer(1)
    name: string(50)
    solution_code: string(50)
    price: integer(10)
    attachment: string(255)
  indexes:
    select:
      fields: [order_id, state, solution_code]


#############################周边产品
Peripheral:
  tableName: peripheral
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    # <select></select> 周边产品名称（eg: 虚拟主机）
    name: string(50)
    # <select></select> 周边产品类型（eg: M5型虚拟主机）
    type: string(50)
    # <select></select> 购买年限
    duration: integer(4)
    # 价格 可空
    price: integer(11)
    # serialize的数据
    content: text
    # 其他信息
    remark: string(255)

#############################
OrderPeripheral:
  tableName: order_peripheral
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    order_id: integer(11)
    peripheral_id: integer(4)
  indexes:
    query:
      fields: [order_id, peripheral_id]
  relations:
    Order:
      local: order_id
      foreign: id
      foreignAlias: OrderPeripheral
    Peripheral:
      local: peripheral_id
      foreign: id
      foreignAlias: OrderPeripheral

###########################工作流程
Workflow:
  tableName: workflow
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    name: string(50)
    action: string(255)
    sequence: integer(1)
    roles: string(255)
    alias: string(50)
    display:
      type: integer(1)
      default: '1'
    operation: text
    template: string(50)
    parent_id: integer(4)
    state: string(255)
  indexes:
    select:
      fields: [sequence, roles, display, alias]
  relations:
    Parent:
      class: Workflow
      local: parent_id
      foreign: id
    Children:
      class: Workflow
      local: id
      foreign: parent_id

Payment:
  tableName: order_payment
  actAs: [Timestampable]
  options:
    type: MyISAM
    collate: utf8_general_ci
    charset: utf8
  columns:
    order_id: integer(11)
    #付款类型 first, second, last, peripheral#周边产品, service#服务类, other
    type: string(10)
    #付款人
    who: string(10)
    #驳回理由
    content: string(255)
    #付了多少
    price: integer(10)
    #发票
    invoice: integer(1)
    #对公
    public: integer(1)
    #银行
    bank: string(50)
    #是否已到账 0未付款， 1已付款， -1驳回， 2已确认付款
    is_payed: 
      type: integer(1)
      default: 0

