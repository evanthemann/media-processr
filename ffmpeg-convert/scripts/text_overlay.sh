#!/bin/bash

text="$1"
bgcolor="$2"
log_file="$3"

pwd >> "$log_file"

title_safe=$(echo "$text" | sed 's/[^a-zA-Z0-9\_\-]/_/g')

outfile="/usr/local/var/www/media-processr/ffmpeg-convert/uploads/output.mp4"

# 1. Generate cellauto video
/usr/local/bin/ffmpeg -f lavfi -i cellauto=s=1920x1080:rule=30 -t 10 -c:v libx264 /usr/local/var/www/media-processr/ffmpeg-convert/uploads/cellauto.mp4 -y

# 2. Generate red color video yellow/gold #F7DC6F pale green (good) #C9E4CA pale blue #C5E3F4 pale red (good) #FFC6C9
/usr/local/bin/ffmpeg -f lavfi -i color=c=$bgcolor:s=1920x1080 -t 10 -c:v libx264 /usr/local/var/www/media-processr/ffmpeg-convert/uploads/color.mp4 -y

# 3. Overlay red on top of cellauto and blend with multiply
/usr/local/bin/ffmpeg -i /usr/local/var/www/media-processr/ffmpeg-convert/uploads/cellauto.mp4 -i /usr/local/var/www/media-processr/ffmpeg-convert/uploads/color.mp4 -filter_complex "[0:v] format=rgba [bg]; [1:v] format=rgba [fg]; [bg][fg] blend=all_mode='multiply':all_opacity=1, format=rgba" /usr/local/var/www/media-processr/ffmpeg-convert/uploads/out.mp4 -y

# 4. Blur the overlaid video
/usr/local/bin/ffmpeg -i /usr/local/var/www/media-processr/ffmpeg-convert/uploads/out.mp4 -vf "gblur=sigma=2" -c:a copy /usr/local/var/www/media-processr/ffmpeg-convert/uploads/outblur.mp4 -y

# 5. Add title slide and output to file with safe filename
/usr/local/bin/ffmpeg -i /usr/local/var/www/media-processr/ffmpeg-convert/uploads/outblur.mp4 -vf "drawtext=text='$text':x=(w-text_w)/2:y=(h-text_h)/2:fontsize=100:fontcolor=white" -c:a copy $outfile -y

# Remove temporary files
rm /usr/local/var/www/media-processr/ffmpeg-convert/uploads/cellauto.mp4
rm /usr/local/var/www/media-processr/ffmpeg-convert/uploads/color.mp4
rm /usr/local/var/www/media-processr/ffmpeg-convert/uploads/out.mp4
rm /usr/local/var/www/media-processr/ffmpeg-convert/uploads/outblur.mp4

# Confirm success
if [ -f "$outfile" ]; then
    echo "Thumbnail generated successfully: $outfile" >> "$log_file"

    # Derive relative web path
    base_url="http://192.168.0.53:8080/media-processr/ffmpeg-convert/uploads"
    filename=$(basename "$outfile")
    echo "➡️ View: $base_url/$filename" >> "$log_file"

else
    echo "Error: Failed to generate thumbnail." >> "$log_file"
fi
