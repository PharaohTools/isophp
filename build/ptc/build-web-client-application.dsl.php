RunCommand execute
  label "Run the Node NPM Install"
  command "cd {{{ param::start-dir }}}/clients/web && sudo npm install --no-bin-links"
  guess

RunCommand execute
  label "Run the Composer Install"
  command "cd {{{ param::start-dir }}}/clients/web && sudo composer install"
  guess

RunCommand execute
  label "Run the Node NPM Build"
  command "cd {{{ param::start-dir }}}/clients/web && sudo npm run build"
  guess

RunCommand execute
  label "Build to our Target Client"
  command "cd {{{ param::start-dir }}} && php build/build_to_uniter.php web > /dev/null"
  guess

Logging log
  log-message "Our Custom Branch is : $$custom_branch"

RunCommand execute
  label "Add our back end application variable set, cp {{{ param::start-dir }}}/vars/configuration_$$backendenv.php {{{ param::start-dir }}}/clients/web/core/ && mv {{{ param::start-dir }}}/clients/web/core/configuration_$$backendenv.php {{{ param::start-dir }}}/clients/web/core/app_vars.fephp"
  command "cp {{{ param::start-dir }}}/vars/configuration_$$backendenv.php {{{ param::start-dir }}}/clients/web/core/ && mv {{{ param::start-dir }}}/clients/web/core/configuration_$$backendenv.php {{{ param::start-dir }}}/clients/web/core/app_vars.fephp"
  guess

RunCommand execute
  label "Always add our default application variable set, cp {{{ param::start-dir }}}/vars/default.php {{{ param::start-dir }}}/clients/web/core/default.fephp "
  command "cp {{{ param::start-dir }}}/vars/default.php {{{ param::start-dir }}}/clients/web/core/default.fephp "
  guess

RunCommand execute
  command "cd {{{ param::start-dir }}}/clients/web && ptdeploy vhe add -yg --vhe-url=$$webclientsubdomain.$$domain --vhe-ip-port=0.0.0.0:80 --vhe-default-template-name=docroot-no-suffix"
  guess

RunCommand execute
  command "ptdeploy he add -yg --host-name={{{ var::webclientsubdomain }}}.$$domain"
  guess

RunCommand execute
  label "Enable Site and restart Apache"
  command "a2ensite {{{ var::webclientsubdomain }}}.$$domain.conf && service apache2 restart"
  guess

RunCommand execute
  command "ptdeploy apachecontrol restart -yg"
  guess
