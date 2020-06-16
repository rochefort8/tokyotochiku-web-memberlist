#!/bin/bash

count_m=1
count_w=1

while IFS=, read graduate id a2016 a2017 a2018 a2019 f_; do
    if [ ! -n "$id" ]; then
        continue
    fi
 
    a=""

    if [ -n "$a2016" ]; then 
        a="2016"$a2016"/"
    fi
    if [ -n "$a2017" ]; then    
        a+="2017"$a2017"/"
    fi
    if [ -n "$a2018" ]; then    
        a+="2018"$a2018"/"
    fi
    if [ -n "$a2019" ]; then    
        a+="2019"$a2019"/"
    fi
    if  [ -n "$a" ]; then
        echo $id,$a
    fi
done < ./tt_a.csv

