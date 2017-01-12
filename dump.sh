#!/usr/bin/env bash
host=$1;
user=$2;
pas=$3;
dbname=$4;
dumpdate=$5;
mysqldump -h $host -u $user -p$pas $dbname > dumps/$dbname$dumpdate.sql
