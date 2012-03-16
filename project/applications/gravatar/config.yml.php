#<?php die();?>

onerror_img:
default: monsterid
rating: G
size: 60

caching: true
cache_dir: tmp/gravatar_cache
cache_life: 86400

plugins:
  before_template_render:
    gravatar: gravatar/plugins.GravatarPlugins::load_gravatar