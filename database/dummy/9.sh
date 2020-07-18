#!/bin/bash

count_m=1
count_w=1

file=$1

rm -rf $file".csv"
touch $file".csv"

while IFS=, read s1; do

    found=
    while IFS=, read d1; do
        if [ "$d1" == "$s1" ]; then
            found="y"
            break
        fi
    done < $file".csv"
    if [ -z "$found" ]; then
        echo $s1
        echo $s1 >> $file".csv"
    fi
done < $file"_all.csv"

