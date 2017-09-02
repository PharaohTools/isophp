Logging log
  log-message "Starting Deploy Configuration of Virtual Machine Host"

HostEditor add
  label "Create our host file entry for our VM Web Client App URL"
  guess
  host-name "$$webclientsubdomain.{{{ var::domain }}}"
  host-ip "127.0.0.1"

HostEditor add
  label "Create our host file entry for our VM Web Server App URL"
  guess
  host-name "$$server_subdomain.{{{ var::domain }}}"
  host-ip "127.0.0.1"

HostEditor add
  label "Create our host file entry for our Build Server URL"
  guess
  host-name "build.{{{ var::domain }}}"
  host-ip "127.0.0.1"

Logging log
  log-message "Pharaoh Deploy Configuration of Virtual Machine Host Complete"