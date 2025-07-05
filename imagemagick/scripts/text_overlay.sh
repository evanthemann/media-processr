#!/bin/bash

input_file="$1"
output_file="$2"
text="$3"
log="$4"

text=$(echo "$text" | tr '[:lower:]' '[:upper:]')

# Add black shadow caption first
/usr/local/bin/convert -size 1820x \
    -background none -fill black -font "Helvetica-Bold" -pointsize 210 caption:"$text" \
    miff:- | \
/usr/local/bin/convert "$input_file" \
    -resize 1920x1080^ -extent 1920x1080 - \
    -gravity northwest -geometry +110+110 -composite \
    miff:- | \
/usr/local/bin/convert - -size 1820x \
    -background none -fill "#fdff65" -font "Helvetica-Bold" -pointsize 210 caption:"$text" \
    -gravity northwest -geometry +100+100 -composite \
    "$output_file" >> "$log" 2>&1

# Confirm success
if [ -f "$output_file" ]; then
    echo "Thumbnail generated successfully: $output_file" >> "$log"
    echo "➡️ View: overlay_$(basename "$in")" >> "$log"
    rm "$in"
else
    echo "Error: Failed to generate thumbnail." >> "$log"
fi
