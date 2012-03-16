#<?php die();?>

# Set the runtime mode, enum('devel', 'deploy', 'test')
RUN_MODE: deploy

# Local time zone for this installation. Choices can be found here:
# http://en.wikipedia.org/wiki/List_of_tz_zones_by_name
# although not all choices may be available on all operating systems.
# If running in a Windows environment this must be set to the same as your
# system time zone.
TIME_ZONE: 'Asia/Shanghai'

# Language code for this installation. All choices can be found here:
# http://www.i18nguy.com/unicode/language-identifiers.html
LANGUAGE_CODE: 'zh_CN'

# The base URL to index.php, let it empty to use the relative URL
BASE_URL: ''

# URL that handles the media served from MEDIA_ROOT. Make sure to use a
# trailing slash.
# Examples: http://www.domain.com/statics/, statics/
MEDIA_URL: 'statics/'

# If you set this to False, framework will make some optimizations so as not
# to load the internationalization machinery.
USE_I18N: false  #是否开启国际化支持

USE_REWRITE: false  #是否使用URL REWRITE

# Chooes your default cache backend, just like xcache, memcache or file
CACHE_BACKEND: xcache   #默认的缓存后端 

SESSION:  #是否使用自定义的SESSION存储方式
  CUSTOM: true
  SAVE: file
  DIR:  tmp/session

INSTALLED_APPS:
  - system/contrib/auth  #基础验证 
  - system/contrib/dev_tools
  - kind_editor  #kind_editor
  - gravatar  #gravatar头像
  - order  #订单，工作流程等
  - customer  #客户操作平台
  - work  #每个人的工作计划表
  - articles  #文章类功能
  - forms  #表单类功能
  - manager #系统管理

DEFAULT_ACTION: mine/index  #默认的主页

#附件信息
attachment:
  attachment_dir: uploads
  #0 使用原名+时间戳。 1 使用MD5的新文件名
  how_to_named: 1
  #允许的MIME类型
  allow_type:
    image: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']
    other: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'application/x-rar', 'application/zip','application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 'application/vnd.ms-office', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']

