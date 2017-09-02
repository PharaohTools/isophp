Composer ensure
  guess

NodeJS install

RunCommand execute
  label "Install prequisite applications"
  command "apt-get install -y zip unzip"
  guess

RunCommand execute
  label "NPM Install Electron Packager and cordova"
  command "npm install --silent -g electron-packager cordova browserify uglifyjs uglify-js > /dev/null"
  guess

RunCommand execute
  label "NPM Install Node Version 6"
  command "npm cache clean -f && npm install -g n && n 6.0.0 && ln -sf /usr/local/n/versions/node/6.0.0/bin/node /usr/bin/nodejs"
  guess

Java install
  java-install-version "1.8"
  guess

RunCommand execute
  label "Install SDKManager for Gradle"
  command "echo ptv | sudo su -c 'curl -s https://get.sdkman.io | bash' - root"

RunCommand execute
  label "Install Gradle using SDKManager"
  command "echo ptv | sudo su -c 'source /root/.sdkman/bin/sdkman-init.sh && sdk install gradle 4.0.2' - root"
  guess

RunCommand execute
  label "Copy the host shared SDK tools"
  command "cp /var/www/hostshare/build/binaries/sdk-tools-linux-3859397.zip /tmp/sdk-tools.zip"
  guess
  ignore_errors

RunCommand execute
  label "Get the Android SDK tools"
  command "if [ ! -f /tmp/sdk-tools.zip ] ; then curl -o /tmp/sdk-tools.zip https://dl.google.com/android/repository/sdk-tools-linux-3859397.zip ; fi"
  guess

RunCommand execute
  label "Make SDK Dir - MUST RUN AFTER PTBUILD INSTALL OR USER WONT EXIST"
  command "mkdir -p /home/ptbuild/Android/Sdk && chown -R ptbuild:ptbuild /home/ptbuild/Android/Sdk"
  guess

RunCommand execute
  label "Unzip SDK Tools"
  command "cd /tmp && mv sdk-tools.zip /home/ptbuild/Android/Sdk && cd /home/ptbuild/Android/Sdk && rm -rf /home/ptbuild/Android/Sdk/tools && unzip -qq sdk-tools.zip && chown -R ptbuild:ptbuild /home/ptbuild/Android"
  guess

RunCommand execute
  label "Install the android build tools with android sdkmanager"
  command "source /etc/profile && source /var/www/hostshare/build/vm-android-shell.bash && echo y | sdkmanager 'build-tools;26.0.0'"
  guess
  ignore_errors

StandardTools ensure
  label "Lets ensure some standard tools are installed"

GitTools ensure
  label "Lets ensure some git tools are installed"

GitKeySafe ensure
  label "Lets ensure Git SSH Key Safe is installed"
  