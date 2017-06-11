RunCommand execute
  label "Run the Node NPM Build"
  command "cd {{{ param::start-dir }}}/clients/web && npm run build"
  guess

RunCommand execute
  label "Build to our Target Client"
  command "cd {{{ param::start-dir }}} && php build/build_to_uniter.php web"
  guess

Process kill
  label "Stop any running ISOPHP server"
  name "isophp_server.php"
  use-pkill
  guess
  ignore_errors

RunCommand execute
  command "cd {{{ param::start-dir }}}/clients/web && ptdeploy vhe add -yg --vhe-url=$$subdomain.$$domain  --vhe-default-template-name=docroot-no-suffix"
  guess

RunCommand execute
  command "ptdeploy he add -yg --host-name=www.$$domain"
  guess

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

RunCommand execute
  command "ptdeploy apachecontrol restart -yg"
  guess
