Composer ensure
  guess

RunCommand execute
  command "cd {{{ param::start-dir }}}/clients/{{ loop }} && composer install"
  guess
  loop "desktop,web"

RunCommand execute
  command "cd {{{ param::start-dir }}}/clients/{{ loop }} && npm install"
  guess
  loop "desktop,web"