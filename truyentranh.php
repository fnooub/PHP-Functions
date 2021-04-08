<?php

date_default_timezone_set("Asia/Ho_Chi_Minh");

$name = "dailao1";

exec("ffmpeg.exe");
// lap lai anh cho khop voi audio & resize
//exec("ffmpeg -r 1 -loop 1 -i data/".$name.".jpg -i data/".$name.".mp3 -acodec copy -r 1 -shortest -vf scale=1280:720 output/".$name.".mp4");

// video hoac audio ngan hon thi lay
//exec("ffmpeg -i input/".$name.".mp4 -i JimYosef.mp3 -map 0:v -map 1:a -c:v copy -shortest outputx.mp4");

// lap lai [video] cho khop voi [audio]
//exec("ffmpeg -stream_loop -1 -i haha2.mp4 -i rain_in_wd.mp3 -map 0:v -map 1:a -c:v copy -shortest rain3.mp4");
// lap lai audio cho khop voi video
exec("ffmpeg -y -i input/".$name.".mp4 -stream_loop -1 -i JimYosef.mp3 -map 0:v -map 1:a -c:v copy -shortest output/out-".$name.".mp4");

$timestamp = date('H:i:s');
echo $timestamp;