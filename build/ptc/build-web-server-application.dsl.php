RunCommand execute
  command "cd {{{ param::start-dir }}}/server && ptdeploy vhe add -yg --vhe-url=$$server_subdomain.$$domain --vhe-ip-port=0.0.0.0:80 --vhe-default-template-name=docroot-no-suffix"
  guess

RunCommand execute
  command "ptdeploy he add -yg --host-name=$$server_subdomain.$$domain"
  guess

RunCommand execute
  label "Enable Site and restart Apache"
  command "a2ensite $$server_subdomain.$$domain.conf && service apache2 restart"
  guess

RunCommand execute
  command "ptdeploy apachecontrol restart -yg"
  guess
