RunCommand execute
  label "Run the Node NPM Install"
  command "cd {{{ param::start-dir }}}/clients/mobile && npm install --no-bin-links"
  guess
  ignore_errors

RunCommand execute
  label "Run the Composer Install"
  command "cd {{{ param::start-dir }}}/clients/mobile && composer install"
  guess

RunCommand execute
  label "Build Uniter application to our Target Client"
  command "cd {{{ param::start-dir }}} && php build/build_to_uniter.php mobile > /dev/null"
  guess

RunCommand execute
  label "Add our back end application variable set, cp {{{ param::start-dir }}}/vars/$$mobilebackend.php {{{ param::start-dir }}}/clients/mobile/www/core/ && mv {{{ param::start-dir }}}/clients/mobile/www/core/$$mobilebackend.php {{{ param::start-dir }}}/clients/mobile/www/core/app_vars.fephp"
  command "cp {{{ param::start-dir }}}/vars/$$mobilebackend.php {{{ param::start-dir }}}/clients/mobile/www/core/ && mv {{{ param::start-dir }}}/clients/mobile/www/core/$$mobilebackend.php {{{ param::start-dir }}}/clients/mobile/www/core/app_vars.fephp"
  guess

RunCommand execute
  label "Run the Node FS "
  command "cd {{{ param::start-dir }}}/clients/mobile && sudo node fs > /dev/null"
  guess

RunCommand execute
  label "Run the Node NPM Build "
  command "cd {{{ param::start-dir }}}/clients/mobile && npm run build "
  guess

RunCommand execute
  label "Copy icons from application"
  command "cd {{{ param::start-dir }}} && cp -r {{{ param::start-dir }}}/app/Default/Assets/icons/*.png {{{ param::start-dir }}}/clients/mobile/res/icon/android/"
  guess

RunCommand execute
  label "Tell Cordova no usage statistics"
  command 'echo n | cordova'
  guess

RunCommand execute
  label "Build and run the executable applications"
  command "source {{{ param::start-dir }}}/build/$$android_shell_script && cd {{{ param::start-dir }}}/clients/mobile && cordova run android"
  guess
  when "{{{ param::emulator }}}"

RunCommand execute
  label "Just create the android executable applications"
  command "source {{{ param::start-dir }}}/build/$$android_shell_script && cd {{{ param::start-dir }}}/clients/mobile && cordova build android"
  guess
  when "{{{ param::create_apk_only }}}"

RunCommand execute
  label "Just create the iOS executable applications"
  command "(source {{{ param::start-dir }}}/build/$$android_shell_script && cd {{{ param::start-dir }}}/clients/mobile && cordova build ios)"
  guess
  when "{{{ param::create_ipa_only }}}"

Process kill
  label "Stop any node server"
  name "node"
  use-pkill
  when "{{{ param::webserver }}}"
  ignore_errors

RunCommand execute
  label "Build and run the mobile app web server"
  command "(source {{{ param::start-dir }}}/build/$$android_shell_script && cd {{{ param::start-dir }}}/clients/mobile && (nohup cordova serve > /dev/null 2>&1 &))"
  guess
  when "{{{ param::webserver }}}"

Port until-responding
  label "Wait for the mobile app web server to start"
  port "8000"
  guess
  when "{{{ param::webserver }}}"
