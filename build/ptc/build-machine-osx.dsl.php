GitKeySafe ensure
  label "Lets ensure Git SSH Key Safe is installed"
  guess

Composer ensure
  guess

RunCommand execute
  label "Install prequisite applications"
  command "brew install -y unzip node"
  run-as-user "{{{ var::osx-brew-user }}}"
  guess

RunCommand execute
  label "NPM Install Node Version 6"
  command "npm cache clean -f && npm install -g n && n 6.0.0 && ln -sf /usr/local/n/versions/node/6.0.0/bin/node /usr/bin/nodejs"
  guess

RunCommand execute
  label "NPM Install Electron Packager and cordova"
  command "npm install --silent -g electron-packager cordova browserify uglifyjs uglify-js > /dev/null"
  guess