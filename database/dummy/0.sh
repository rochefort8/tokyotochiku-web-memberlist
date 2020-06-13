#!/bin/bash

count_m=1
count_w=1

while IFS=, read f1 f2 f3 f4 f5 f6 f7 f8 f9 f10 f11 f12 f13 f14_; do
    if [ ! -n "$f9" ]; then
        continue
    fi
    if [ "$f9" ==  "0" ]; then
        let count=count_m
        let count_m++
        dfn=./person_m.csv
    else
        let count=count_w
        let count_w++
        dfn=./person_w.csv
    fi
    
    dl=$(sed -n $count"P" $dfn)

    d2=$(echo $dl | cut -d, -f2)
    d3=$(echo $dl | cut -d, -f3)
    d4=$(echo $dl | cut -d, -f4)
    d5=$(echo $dl | cut -d, -f5)
    d6=$(echo $dl | cut -d, -f6)
    d7=$(echo $dl | cut -d, -f7)
    d8=$(echo $dl | cut -d, -f8)
    d9=$(echo $dl | cut -d, -f9)
    d10=$(echo $dl | cut -d, -f10)
    d11=$(echo $dl | cut -d, -f11)
    d12=$(echo $dl | cut -d, -f12)
    d13=$(echo $dl | cut -d, -f13)
    d14=$(echo $dl | cut -d, -f14)

#    echo $d2 $d3 $d4 $d5 $d6 $d7 $d8 $d9 $d10 $d11$d12$d13 $d14

     f4="$d2"
     f5="$d3"
     f7="$d4"
     f8="$d5"

    # Address
    if [ -n "$f10"  -a "$f10" != "-" -a "$f10" != "ー" ]; then
        f10="$d10,$d11$d12$d13$d14"
    fi 

    # Phone1
    if [ -n "$f11"  -a "$f11" != "-" -a "$f11" != "ー" ]; then
        f11="$d7"
    fi 

    # Phone2
    if [ -n "$f12"  -a "$f12" != "-" -a "$f12" != "ー" ]; then
        f12="$d8"
    fi 

    if [ -n "$f13"  -a "$f13" != "-" -a "$f13" != "ー" ]; then
        f13="$d9"
    fi 

    echo $f1,$f2,$f3,$f4,$f5,$f6,$f7,$f8,$f9,$f10,$f11,$f12,$f13,$f14_
done < ./tt_org.csv

