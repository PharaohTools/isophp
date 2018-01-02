RunCommand execute
  label "Show any running socketserve.js server"
  command "lsof -i :3000"
  guess
  ignore_errors

Process kill
  label "Kill any running socketserve.js server"
  name "node"
  use-pkill
  yes

RunCommand execute
  label "Start socket server bash -c 'node {{{ param::start-dir }}}/server/node_socket_server/socketserve.js &' 2&>1 /dev/null "
  command "bash -c 'node {{{ param::start-dir }}}/server/node_socket_server/socketserve.js &' 2&>1 /dev/null"
  nohup
  guess

Port until-responding
  label "Wait for the socket server to start"
  port "3000"
  guess

RunCommand execute
  label "Show any running socketserve.js server"
  command "lsof -i :3000"
  guess