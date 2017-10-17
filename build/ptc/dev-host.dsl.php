RunCommand execute
  label "Get the Android SDK tools"
  command "if [ ! -f /tmp/sdk-tools.zip ] ; then curl -o /tmp/sdk-tools.zip https://dl.google.com/android/repository/sdk-tools-linux-3859397.zip ; fi"
  guess

RunCommand execute
  label "Make SDK Dir"
  command "mkdir -p /home/{{{ param::my_username }}}/Android/Sdk && chown -R {{{ param::my_username }}}:{{{ param::my_username }}} /home/{{{ param::my_username }}}/Android/Sdk"
  guess

RunCommand execute
  label "Unzip SDK Tools"
  command "cd /tmp && mv sdk-tools.zip /home/{{{ param::my_username }}}/Android/Sdk && cd /home/{{{ param::my_username }}}/Android/Sdk && rm -rf /home/{{{ param::my_username }}}/Android/Sdk/tools && unzip -qq sdk-tools.zip && chown -R {{{ param::my_username }}}:{{{ param::my_username }}} /home/{{{ param::my_username }}}/Android"
  guess

RunCommand execute
  label "Install the android build tools with android sdkmanager"
  command "source /etc/profile && source {{{ param::app_dir }}}/build/android-shell.bash && echo y | sdkmanager 'build-tools;26.0.0'"
  guess
  ignore_errors

StandardTools ensure
  label "Lets ensure some standard tools are installed"

GitTools ensure
 label "Lets ensure some git tools are installed"

GitKeySafe ensure
  label "Lets ensure Git SSH Key Safe is installed"