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
  echo $REVLOG | grep $dir > /dev/null
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

REVLOG=`/usr/bin/svnlook changed "$REPOS" -r "$REV"`

#checkUpdate users/gravant/trunk/workspace gravant-workspace
checkUpdate users/adamh/trunk/sdboard-2 boards-devel
checkUpdate projects/trunk/holonet holonet3-devel
checkUpdate projects/trunk/holonet4 holonet4-devel
checkUpdate projects/trunk/ka ka-devel
checkUpdate projects/trunk/lyarna lyarna-devel
checkUpdate projects/trunk/mybhg mybhg-devel
checkUpdate projects/trunk/roster4 roster4
checkUpdate projects/trunk/roster roster-devel
checkUpdate projects/trunk/scum scum-devel
checkUpdate projects/trunk/tactician tactician-devel
checkUpdate projects/trunk/donate donate

LogMsg "Revision $REV complete"
