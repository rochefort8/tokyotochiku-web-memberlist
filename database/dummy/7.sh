#!/bin/bash

count_m=1
count_w=1







while IFS=, read f1 f2 f3 f4 ; do

    echo $f1,$f2,$f4;
done < ./tt_base.csv

