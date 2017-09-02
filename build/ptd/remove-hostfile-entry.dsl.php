Logging log
  log-message "Starting PTDeploy Application Configuration of Virtual Machine Host"

HostEditor rm
  label "Remove our host file entry for VM Web Clent App URL"
  guess true
  host-name "$$webclientsubdomain.{{{ var::domain }}}"

HostEditor rm
  label "Remove our host file entry for VM Web Server App URL"
  guess
  host-name "$$server_subdomain.{{{ var::domain }}}"

HostEditor rm
  label "Remove our host file entry for VM Build Server"
  guess
  host-name "build.{{{ var::domain }}}"

Logging log
  log-message "Pharaoh Deploy Configuration of Virtual Machine Host Complete"