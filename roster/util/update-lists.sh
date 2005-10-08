#!/bin/bash

mkdir -p /tmp/lists
php ./update-lists.php
for list in `ls -1 /tmp/lists`
do
	/usr/lib/mailman/bin/remove_members -a $list
	/usr/lib/mailman/bin/add_members -r /tmp/lists/$list -w n $list
done
rm -rf /tmp/lists
