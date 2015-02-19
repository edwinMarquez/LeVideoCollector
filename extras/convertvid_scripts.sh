#!/bin/bash
/usr/bin/nice -n 19 /usr/local/bin/ffmpeg -y -v 40 -i ./video/$1.$2 -b 1500k -vcodec libx264 -g 30 -s 640x364 ./video/mp4/$1.mp4
/usr/bin/nice -n 19 /usr/local/bin/ffmpeg -y -v 8 -i ./video/$1.$2 -b 1500k -vcodec libvpx -acodec libvorbis -ab 160000 -f webm -g 30 -s 640x364 ./video/webm/$1.webm
/usr/bin/nice -n 19 /usr/local/bin/ffmpeg -y -v 8 -i ./video/$1.$2 -b 1500k -vcodec libtheora -acodec libvorbis -ab 160000 -g 30 -s 640x364 ./video/ogv/$1.ogv
