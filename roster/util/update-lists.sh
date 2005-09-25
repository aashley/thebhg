#!/bin/bash

mkdir -p /tmp/lists
php ./update-lists.php
for list in `ls -1 /tmp/lists`
do
	/usr/lib/mailman/bin/add_members -r /tmp/lists/$list -w n
done
rm -rf /tmp/lists
