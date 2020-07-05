#!/bin/bash

count_m=1
count_w=1

while IFS=, read f1 f2 f3 f4 f5 f6 f7 f8 f9 f10 f11 f12 f13 f14 f15 f16 f17 f18 f19 f20 f21 f22; do

    if [ -z "$f10" -a -n "$f11" ]; then
        echo $f11
    fi

    f10=${f10//-/}

    echo $f1,$f2,$f3,$f4,$f5,$f6,$f7,$f8,$f9,$f10,$f11,$f12,$f13,$f14,$f15,$f16,$f17,$f18,$f19,$f20,$f21,$f22;
done < ./tt_base.csv

