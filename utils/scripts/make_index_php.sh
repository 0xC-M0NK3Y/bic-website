#!/bin/bash
if [ $# -ne 3 ]
then
	echo "Usage make_index_php.sh index_start.php filters.php index_end.php"
	exit 1
fi

cat $1 $2 $3 > index.php

