GitKeySafe ensure
  guess

Composer ensure
  guess

NodeJS install

RunCommand execute
  label "Install prequisite applications"
  command "apt-get install -y apache2 libapache2-mod-php5 sqlite3 php5-sqlite zip unzip"
  guess

RunCommand execute
  label "NPM Install Node Version 6"
  command "npm cache clean -f && npm install -g n && n 6.0.0 && ln -sf /usr/local/n/versions/node/6.0.0/bin/node /usr/bin/nodejs"
  guess

RunCommand execute
  label "NPM Install Electron Packager and cordova"
  command "npm install --silent -g electron-packager cordova browserify uglifyjs uglify-js"
  guess

Java install
  java-install-version "1.8"
  guess

PTDeploy ensure
  guess

RunCommand execute
  label "Install SDKManager for Gradle"
  command 'curl -s https://get.sdkman.io | bash'
  guess

RunCommand execute
  label "Install Gradle using SDKManager"
  command "source /root/.sdkman/bin/sdkman-init.sh && sdk install gradle 4.0.2"
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
  command "mkdir -p /opt/Android/Sdk && chown -R root:root /opt/Android/Sdk"
  guess

RunCommand execute
  label "Unzip SDK Tools"
  command "cd /tmp && mv sdk-tools.zip /opt/Android/Sdk && cd /opt/Android/Sdk && rm -rf /opt/Android/Sdk/tools && unzip -qq sdk-tools.zip && chown -R root:root /opt/Android"
  guess

RunCommand execute
  label "Install the android build tools with android sdkmanager"
  command "source /etc/profile && source /opt/{{{ param::repo_slug }}}/build/cloud-android-shell.bash && echo y | sdkmanager 'build-tools;26.0.0' && echo y | sdkmanager 'build-tools;26.0.0'"
  guess
  ignore_errors

StandardTools ensure
  label "Lets ensure some standard tools are installed"