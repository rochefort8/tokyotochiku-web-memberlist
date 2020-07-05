#!/bin/bash

count_m=1
count_w=1







while IFS=, read f1 f2 f3 f4 f5 f6 f7 f8 f9 f10 f11 f12 f13 f14 f15 f16 f17 f18 f19 f20 f21 f22; do

    f11_0=""
    f11_1=""
    f11_2=""
    if [ -n "$f10"  ]; then
        while IFS=, read a1 a2 a3 a4 a5 a6 a7 a8 a9 a10; do

            if [ "$f10" == "$a3" ]; then
                f11_0=$a7
                f11_1=$a8$a9
                f11_2=${f11//$a7$a8$a9/}
                break
            fi

        done < ./KEN_ALL.csv    
    fi
    echo $f1,$f2,,$f3,$f4,$f5,$f6,$f7,$f8,$f9,$f10,$f11_0,$f11_1,$f11_2,$f12,$f13,$f14,$f15,$f16,$f17,$f18,$f19,$f20,$f21,$f22;
done < ./tt_base.csv

