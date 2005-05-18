#!/bin/bash


REPOS="$1"
REV="$2"

function LogMsg() {
  local DATEFORMAT

  if [ -z "$*" ]; then
    echo
  else
    DATEFORMAT="%d %b %Y %H:%M:%S %Z"
    echo -- [`date "+$DATEFORMAT"`]: $*
  fi
  return 0
}

function checkUpdate() {
  local UPDATE dir=$1 site=$2

  LogMsg "Checking Revision $REV in $REPOS for $dir update"
  /usr/bin/svnlook changed "$REPOS" -r "$REV" | grep $dir > /dev/null
  UPDATE=$?

  if [[ $UPDATE -eq 0 ]]; then
		LogMsg "Update found for $dir"
    sudo /usr/local/bin/update-site $site 2>&1
	else
		LogMsg "No Update Found for $dir"
  fi
}

# Switch to /tmp so that svnlook can create its tmp files without problems
cd /tmp

LogMsg "New Commit: $REV"

checkUpdate projects/trunk/holonet holonet-devel
checkUpdate projects/trunk/mybhg mybhg-devel
checkUpdate projects/trunk/ka ka-devel
checkUpdate projects/trunk/scum scum-devel

LogMsg "Revision $REV complete"
