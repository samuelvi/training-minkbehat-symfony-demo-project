#!/bin/bash
  
EXPECTED_ARGS=3
E_BADARGS=65
MYSQL=`which mysql`

# CREATE DATABASE IF NOT EXISTS mb_dev;
# GRANT USAGE ON *.* TO mb_dev@localhost IDENTIFIED BY 'mb_dev';
# GRANT ALL PRIVILEGES ON mb_dev.* TO mb_dev@localhost;
# FLUSH PRIVILEGES;

# CREATE DATABASE IF NOT EXISTS mb_test;
# GRANT USAGE ON *.* TO mb_test@localhost IDENTIFIED BY 'mb_test';
# GRANT ALL PRIVILEGES ON mb_test.* TO mb_test@localhost;
# FLUSH PRIVILEGES;

Q1="CREATE DATABASE IF NOT EXISTS $1;"
Q2="GRANT USAGE ON *.* TO $2@localhost IDENTIFIED BY '$3';"
Q3="GRANT ALL PRIVILEGES ON $1.* TO $2@localhost;"
Q4="FLUSH PRIVILEGES;"
SQL="${Q1}${Q2}${Q3}${Q4}"
  
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 dbname dbuser dbpass"
  exit $E_BADARGS
fi
  
$MYSQL -uroot -p -e "$SQL"
