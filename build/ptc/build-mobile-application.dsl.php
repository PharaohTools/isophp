RunCommand execute
  label "Update NPM"
  command "npm update -g --silent"
  guess

RunCommand execute
  label "Empty the Node NPM Modules"
  command "cd {{{ param::start-dir }}}/clients/mobile && rm -rf node_modules/*"
  guess

RunCommand execute
  label "Run the Node NPM Install"
  command "cd {{{ param::start-dir }}}/clients/mobile && npm install --no-bin-links"
  guess

RunCommand execute
  label "Run the Composer Install"
  command "cd {{{ param::start-dir }}}/clients/mobile && composer install"
  guess

RunCommand execute
  label "Build Uniter application to our Target Client"
  command "cd {{{ param::start-dir }}} && php build/build_to_uniter.php mobile > /dev/null"
  guess

Logging log
  log-message "Our Custom Branch is : $$custom_branch"

RunCommand execute
  label "Add our back end application variable set, cp {{{ param::start-dir }}}/vars/configuration_$$backendenv.php {{{ param::start-dir }}}/clients/mobile/www/core/ && mv {{{ param::start-dir }}}/clients/mobile/www/core/configuration_$$backendenv.php {{{ param::start-dir }}}/clients/mobile/www/core/app_vars.fephp"
  command "cp {{{ param::start-dir }}}/vars/configuration_$$backendenv.php {{{ param::start-dir }}}/clients/mobile/www/core/ && mv {{{ param::start-dir }}}/clients/mobile/www/core/configuration_$$backendenv.php {{{ param::start-dir }}}/clients/mobile/www/core/app_vars.fephp"
  guess

RunCommand execute
  label "Always add our default application variable set, cp {{{ param::start-dir }}}/vars/default.php {{{ param::start-dir }}}/clients/mobile/www/core/default.fephp "
  command "cp {{{ param::start-dir }}}/vars/default.php {{{ param::start-dir }}}/clients/mobile/www/core/default.fephp "
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
  command "cd {{{ param::start-dir }}} && cp -r {{{ param::start-dir }}}/app/DefaultModule/Assets/icons/*.png {{{ param::start-dir }}}/clients/mobile/res/icon/android/"
  guess
  ignore_errors

RunCommand execute
  label "Tell Cordova no usage statistics"
  command 'echo n | cordova > /dev/null'
  guess

RunCommand execute
  label "Force remove the platforms"
  command "source {{{ param::start-dir }}}/build/$$android_shell_script && cd {{{ param::start-dir }}}/clients/mobile && cordova platform remove {{ loop }}"
  guess
  loop "ios,android"

RunCommand execute
  label "Force install the platforms"
  command "source {{{ param::start-dir }}}/build/$$android_shell_script && cd {{{ param::start-dir }}}/clients/mobile && cordova platform add {{ loop }}"
  guess
  loop "ios,android"

RunCommand execute
  label "Force install the cordova plugins"
  command "source {{{ param::start-dir }}}/build/$$android_shell_script && cd {{{ param::start-dir }}}/clients/mobile && cordova plugin add cordova-plugin-{{ loop }}"
  guess
  loop "splashscreen,whitelist"

RunCommand execute
  label "Build and run the executable applications"
  command "source {{{ param::start-dir }}}/build/$$android_shell_script && cd {{{ param::start-dir }}}/clients/mobile && cordova run android"
  guess
  when "{{{ param::emulator }}}"

RunCommand execute
  label "Remove any existing android executable applications"
  command "cd {{{ param::start-dir }}}/clients/mobile && rm -f platforms/android/build/outputs/apk/*.apk"
  guess
  when "{{{ param::create_apk_only }}}"

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
