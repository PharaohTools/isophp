RunCommand execute
  label "Copy assets to public dir"
  command "cd {{{ param::start-dir }}} && cp -r assets www/"
  guess

RunCommand execute
  label "Copy html to public dir"
  command "cd {{{ param::start-dir }}} && cp -r html/* www/"
  guess

RunCommand execute
  label "Writable public dir"
  command "cd {{{ param::start-dir }}} && chmod -R 777 www"
  guess

Process kill
  label "Stop any running ISOPHP server"
  name "isophp_server.php"
  use-pkill
  guess
  ignore_errors

RunCommand execute
  label "Enable Site and restart Apache"
  command "a2ensite {{{ var::subdomain }}}.$$domain.conf && service apache2 restart"
  guess

RunCommand execute
  label "Start ISOPHP server "
  command "bash -c 'php {{{ param::start-dir }}}/server/isophp_server.php &' > /var/log/isophp_server.log 2>&1 </dev/null"
  nohup true
  background
  guess
