RunCommand execute
  label "Run the Node NPM Install"
  command "cd {{{ param::start-dir }}}/clients/desktop && sudo npm install --no-bin-links"
  guess

RunCommand execute
  label "Run the Composer Install"
  command "cd {{{ param::start-dir }}}/clients/desktop && sudo composer install"
  guess

RunCommand execute
  label "Run the Node NPM Build"
  command "cd {{{ param::start-dir }}}/clients/desktop && npm run build"
  guess

RunCommand execute
  label "Build to our Target Client"
  command "cd {{{ param::start-dir }}} && php build/build_to_uniter.php desktop > /dev/null"
  guess

Logging log
  log-message "Our Custom Branch is : $$custom_branch"

RunCommand execute
  label "Always Add our back end application variable set, cp {{{ param::start-dir }}}/vars/configuration_$$backendenv.php {{{ param::start-dir }}}/clients/desktop/web/core/ && mv {{{ param::start-dir }}}/clients/desktop/web/core/configuration_$$backendenv.php {{{ param::start-dir }}}/clients/desktop/web/core/app_vars.fephp"
  command "cp {{{ param::start-dir }}}/vars/configuration_$$backendenv.php {{{ param::start-dir }}}/clients/desktop/web/core/ && mv {{{ param::start-dir }}}/clients/desktop/web/core/configuration_$$backendenv.php {{{ param::start-dir }}}/clients/desktop/web/core/app_vars.fephp"
  guess

RunCommand execute
  label "Always add our default application variable set, cp {{{ param::start-dir }}}/vars/default.php {{{ param::start-dir }}}/clients/desktop/core/default.fephp "
  command "cp {{{ param::start-dir }}}/vars/default.php {{{ param::start-dir }}}/clients/desktop/core/default.fephp "
  guess

RunCommand execute
  label "Build the OSx executable applications"
  command "cd {{{ param::start-dir }}}/clients/desktop && electron-packager . $$desktop_app_slug --arch=x64 --out=/tmp/exe --overwrite --platform=darwin"
  guess
  when "{{{ param::include-osx }}}"

RunCommand execute
  label "Package the OSx executable applications as Zip"
  command "cd /tmp/exe/{{{ var::desktop_app_slug }}}-darwin-x64 && zip -q -r {{{ var::desktop_app_slug }}}.app.zip {{{ var::desktop_app_slug }}}.app"
  guess
  when "{{{ param::include-osx }}}"

RunCommand execute
  label "Build the Linux executable applications"
  command "cd {{{ param::start-dir }}}/clients/desktop && electron-packager . $$desktop_app_slug --arch=ia32,x64 --out=/tmp/exe --overwrite --platform=linux"
  guess
  when "{{{ param::include-linux }}}"

RunCommand execute
  label "Package the Linux executable applications as Zip"
  command "cd /tmp/exe && zip -q -r {{{ var::desktop_app_slug }}}-{{ loop }}.zip {{{ var::desktop_app_slug }}}-{{ loop }} "
  guess
  loop "linux-ia32,linux-x64"
  when "{{{ param::include-linux }}}"
