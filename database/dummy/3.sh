#!/bin/bash

count_m=1
count_w=1

while IFS=, read f1 f2 f3 
do
    l=$(echo ${f2:0:1})
    if [ "$l" == "_" ]; then
        f2=""   
#        echo $f1,$f2,$f3
    fi   
    if [ "$l" == "J" ]; then
        f2=${f2#J}   
    fi   
    echo $f1,$f2,$f3
done < ./tt_base.csv

