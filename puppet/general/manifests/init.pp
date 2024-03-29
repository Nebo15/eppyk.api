class sethostname(
  $host_name = undef
) {
  file { "/etc/hostname":
    ensure => present,
    owner => root,
    group => root,
    mode => 644,
    content => "$host_name\n",
    notify => Exec["set-hostname"],
  }
  exec { "set-hostname":
    command => "/bin/hostname -F /etc/hostname",
    unless => "/usr/bin/test `hostname` = `/bin/cat /etc/hostname`",
  }
}

node default {
  if (has_role("local")) {
    $host_name = "local.eppyk.api"
    $nginx_configuration_file = 'local'
    $dhparam = undef
    $ssh_port = 'Port 22'
  }
  if (has_role("prod")) {
    $host_name = "eppyk.api"
    $nginx_configuration_file = 'prod'
    $dhparam = '/etc/ssl/dhparam.pem'
    $ssh_port = 'Port 2020'
  }
  if (has_role("develop")) {
    $host_name = "sandbox.eppyk.api"
    $nginx_configuration_file = 'develop'
    $dhparam = undef
    $ssh_port = 'Port 2020'
  }

  include stdlib
  include apt
  include composer

  class { 'sethostname' :
    host_name => $host_name
  }

  package {'install uuid-runtime':
    name    => 'uuid-runtime',
    ensure  => installed,
  }
  class{'nebo15_users':} ->
  class {'php56':} -> class{ 'mongo_3': }

  package { "openssh-server": ensure => "installed" }

  service { "ssh":
    ensure => "running",
    enable => "true",
    require => Package["openssh-server"]
  }

  file_line { 'change_ssh_port':
    path  => '/etc/ssh/sshd_config',
    line  => $ssh_port,
    match => '^Port *',
    notify => Service["ssh"]
  }

  class { 'nginx':
    daemon_user => 'www-data',
    worker_processes => 4,
    pid => '/run/nginx.pid',
    worker_connections => 1024,
    multi_accept => 'on',
    events_use => 'epoll',
    sendfile => 'on',
    http_tcp_nopush => 'on',
    http_tcp_nodelay => 'on',
    keepalive_timeout => '65',
    types_hash_max_size => '2048',
    server_tokens => 'off',
    ssl_dhparam => $dhparam
  }

  file { "mbill_config":
    path => "/etc/nginx/sites-enabled/eppyk.api.conf",
    ensure => link,
    target => "/www/eppyk.api/config/nginx/$nginx_configuration_file.conf",
    notify => Service["nginx"]
  }
}