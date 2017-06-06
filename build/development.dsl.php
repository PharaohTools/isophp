Composer ensure
  guess

RunCommand execute
  command "cd {{{ param::start-dir }}}/clients/{{ loop }} && composer install"
  guess
  loop "desktop,mobile,web"

RunCommand execute
  command "cd {{{ param::start-dir }}}/clients/{{ loop }} && npm install"
  guess