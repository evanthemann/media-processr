#!/bin/bash

input_file="$1"
output_file="$2"
text="$3"
bgcolor="$4"
log_file="$5"

title_safe=$(echo "$text" | sed 's/[^a-zA-Z0-9\_\-]/_/g')

ffmpeg -f lavfi -i cellauto=s=1920x1080:rule=30 -t 10 -c:v libx264 cellauto.mp4 -y

# 1. Generate cellauto video
ffmpeg -f lavfi -i cellauto=s=1920x1080:rule=30 -t 10 -c:v libx264 cellauto.mp4 -y

# 2. Generate red color video yellow/gold #F7DC6F pale green (good) #C9E4CA pale blue #C5E3F4 pale red (good) #FFC6C9
ffmpeg -f lavfi -i color=c=$bgcolor:s=1920x1080 -t 10 -c:v libx264 color.mp4 -y

# 3. Overlay red on top of cellauto and blend with multiply
ffmpeg -i cellauto.mp4 -i color.mp4 -filter_complex "[0:v] format=rgba [bg]; [1:v] format=rgba [fg]; [bg][fg] blend=all_mode='multiply':all_opacity=1, format=rgba" out.mp4 -y

# 4. Blur the overlaid video
ffmpeg -i out.mp4 -vf "gblur=sigma=2" -c:a copy outblur.mp4 -y

# 5. Add title slide and output to file with safe filename
ffmpeg -i outblur.mp4 -vf "drawtext=text='$title_text':x=(w-text_w)/2:y=(h-text_h)/2:fontsize=100:fontcolor=white" -c:a copy "${title_safe//[^a-zA-Z0-9\_\-]/_}.mp4" -y

# Remove temporary files
rm cellauto.mp4
rm color.mp4
rm out.mp4
rm outblur.mp4

ffplay "${title_safe//[^a-zA-Z0-9\_\-]/_}.mp4"

# Confirm success
if [ -f "$output_file" ]; then
    echo "Thumbnail generated successfully: $output_file" >> "$log_file"

    # Derive relative web path
    base_url="http://192.168.0.53:8080/media-processr/ffmpeg-convert/uploads"
    filename=$(basename "$output_file")
    echo "➡️ View: $base_url/$filename" >> "$log_file"
    echo "➡️ View: ${title_safe//[^a-zA-Z0-9\_\-]/_}.mp4" >> "$log_file"


    # Optional: clean up input
    rm "$input_file"
else
    echo "Error: Failed to generate thumbnail." >> "$log_file"
fi
