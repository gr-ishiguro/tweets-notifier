#!/bin/bash

if [ $# -lt 3 ]; then
    echo "usage: tweets_notifer_resident.sh LOOP_COUNT SLEEP_SECONDS [SHELL_OPTION]"
    exit 1
fi

LOOP=$1 # 実行回数
SLEEP=$2 # sleep秒数
shift 2 # 残りの引数を渡すため、引数をシフト

for i in `seq 1 1 $LOOP`
do
  bin/cake tweets_notifer $*

  if [ $i -lt $LOOP ]; then
      sleep $SLEEP
  fi
done