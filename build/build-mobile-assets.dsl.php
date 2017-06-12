RunCommand execute
  label "Run the Node NPM Build"
  command "cd {{{ param::start-dir }}}/clients/mobile && npm run build"
  guess

RunCommand execute
  label "Build to our Target Client"
  command "cd {{{ param::start-dir }}} && php build/build_to_uniter.php mobile"
  guess

RunCommand execute
  label "Build and run the executable applications"
  command 'su -c "(source {{{ param::start-dir }}}/build/android-shell.bash && cd {{{ param::start-dir }}}/clients/mobile && /usr/local/bin/cordova run android)" - pharaoh'
  guess
