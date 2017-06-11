RunCommand execute
  label "Run the Node NPM Build"
  command "cd {{{ param::start-dir }}}/clients/desktop && npm run build"
  guess

RunCommand execute
  label "Build to our Target Client"
  command "cd {{{ param::start-dir }}} && php build/build_to_uniter.php desktop"
  guess

RunCommand execute
  label "Build the executable applications"
  command "cd {{{ param::start-dir }}}/clients/desktop && electron-packager . ISOPHP --arch=ia32,x64 --out=exe --overwrite --platform=darwin,linux"
  guess
