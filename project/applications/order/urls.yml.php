#<?php die();?>

new:
  action: CustomerController.add_customer

index:
  action: OrderController.index

list:
  action: OrderController.ls
  
detail:
  action: OrderController.detail

customer_detail:
  action: CustomerController.detail

communication:
  action: CommunicationController.add

new_solution:
  action: SolutionController.add

contacted:
  action: OrderController.contacted_list