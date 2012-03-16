#<?php die();?>
devel:
  adapter: mysql
  host   : localhost
  user   : root
  passwd : 33023
  port   : 3306
  name   : xiaolan_oa
  charset: utf8

deploy:
  adapter: mysql
  host   : localhost
  user   : root
  passwd : 33023
  port   : 3306
  name   : framework_oa
  charset: utf8

test:
  adapter: mysql
  host   : localhost
  user   : root
  passwd : 
  port   : 3306
  name   : test_x
  charset: utf8


mongo_devel:
  host: 127.0.0.1
  port: 27017
  name: text_x