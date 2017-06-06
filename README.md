# The ISO PHP Framework

http://www.isophp.org.uk


## Installation

To install the application locally, 
``
sudo ptconfigure auto x --af=build/development.dsl.php --start-dir=`pwd` --vars=vars/default.php
``


## Usage

Simply go to the URL www.isophp.tld


## Development

When you make changes to front end logic, you'll need to rebuild them. To
Rebuild any changes to your Uniter PHP Assets
``
ptconfigure auto x --af=build/build-assets.dsl.php --start-dir=`pwd` --vars=vars/default.php
``
To build for Desktop
``
ptconfigure auto x --af=build/build-assets.dsl.php --start-dir=`pwd` --vars=vars/default.php
``



Part of the Pharaoh Tools group of Websites

Built By Laughing Babies

Kudos to

Uniter PHP
Cordova
Electron
