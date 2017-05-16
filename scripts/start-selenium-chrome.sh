#!/bin/bash


KILL=0;
START=1;

for i in "$@"
do
case $i in
    -k=*|--kill=*)
    KILL="${i#*=}"
    shift # past argument=value
    ;;
    -s=*|--start=*)
    START="${i#*=}"
    shift # past argument=value
    ;;
esac
done


if [ $KILL -eq 1 ]; then


    pid=`ps aux | grep -v grep | grep selenium-server | awk '{print $2}'`
    if [ "$pid" != '' ]; then
        echo "Killing Selenium $pid"
        kill -9 $pid
    fi


    pid=`ps aux | grep -v grep | grep Xvfb | awk '{print $2}'`
    if [ "$pid" != '' ]; then
        echo "Killing Xvfb $pid"
        kill -9 $pid
     fi

fi


if [ $START -eq 1 ]; then


    ps cax | grep -v grep | grep Xvfb > /dev/null
    if [ $? -ne 1 ]; then
        echo "Xvfb Process is running."
    else
        echo "Starting Xvfb Process ..."
        sudo Xvfb :10 -ac &
    fi

    export DISPLAY=:10

    ps cax | grep -v grep | grep selenium-server > /dev/null
    if [ $? -ne 1 ]; then
        echo "Selenium Process is running."
    else
        scriptdir=`dirname "$BASH_SOURCE"`
        jarFolder="$PWD/"$scriptdir"/../bin/"
        echo "Starting Selenium Process ... ($jarFolder)"
        #DEFAULT (FIREFOX):
        # java -jar $jarFolder"selenium-server-standalone-2.53.1.jar" &

        # CHROME
        # java -jar "./bin/selenium-server-standalone-2.53.1.jar" -Dwebdriver.chrome.driver="./bin/chromedriver.2.27"  -Dwebdriver.chrome.whitelistedIps="localhost" &
        java -Dwebdriver.chrome.driver="./bin/chromedriver.2.27"  -Dwebdriver.chrome.whitelistedIps="localhost"  -jar "./bin/selenium-server-standalone-3.3.0.jar" &

        #CHROME => java -jar {$jarFolder}selenium-server-standalone-2.53.1.jar -Dwebdriver.chrome.driver="./bin/chromedriver" &
        #DEFAULT SETTING FIREFOX PATH (/usr/local/bin/firefox)=> java -jar {$jarFolder}selenium-server-standalone-2.53.1.jar -Dwebdriver.firefox.bin="/usr/bin/firefox" &

    fi

fi
