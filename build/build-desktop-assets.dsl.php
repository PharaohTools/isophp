RunCommand execute
  label "Run the Node NPM Build"
  command "cd {{{ param::start-dir }}}/clients/desktop && npm run build"
  guess

RunCommand execute
  label "Build to our Target Client"
  command "cd {{{ param::start-dir }}} && php build/build_to_uniter.php desktop"
  guess

RunCommand execute
  command "cd {{{ param::start-dir }}}/clients/desktop && ptdeploy vhe add -yg --vhe-url=$$subdomain.$$domain  --vhe-default-template-name=docroot-no-suffix"
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
electron-packager . ISOPHP --arch=ia32,x64 --out=exe --overwrite --platform=darwin,linux