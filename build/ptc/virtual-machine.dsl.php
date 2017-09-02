RunCommand execute
  label "Install Software"
  command "cd {{{ param::start-dir }}}/ && ptconfigure auto x --af=build/ptc/development.dsl.php --start-dir=`pwd` --vars=vars/vm.php "
  guess

RunCommand execute
  label "Build the Web Client Application"
  command "cd {{{ param::start-dir }}}/ && ptconfigure auto x --af=build/ptc/build-web-client-application.dsl.php --start-dir=`pwd` --vars=vars/vm.php "
  guess

RunCommand execute
  label "Build the Web Server Application"
  command "cd {{{ param::start-dir }}}/ && ptconfigure auto x --af=build/ptc/build-web-server-application.dsl.php --start-dir=`pwd` --vars=vars/vm.php "
  guess