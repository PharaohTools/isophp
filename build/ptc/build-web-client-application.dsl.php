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
