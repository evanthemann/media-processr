#!/bin/bash
input_file="$1"
output_file="$2"
log_file="$3"              # third arg comes from run.php

echo "========== $(date) =========="  >> "$log_file"
echo "Starting conversion…"          >> "$log_file"
echo "Input:  $input_file"           >> "$log_file"
echo "Output: $output_file"          >> "$log_file"
echo ""                              >> "$log_file"

/usr/local/bin/convert "$input_file" \
        -auto-orient -resize 1920x1080 -size 1920x1080 xc:black +swap -gravity center -composite \
        "$output_file"                >> "$log_file" 2>&1

# Check if output was created
if [ -f "$output_file" ]; then
    echo "✅ Conversion complete" >> "$log_file"
    
    # Derive relative web path
    base_url="http://192.168.0.53:8080/media-processr/imagemagick/uploads"
    filename=$(basename "$output_file")
    echo "➡️ View: $base_url/$filename" >> "$log_file"

    # Optional: clean up input
    rm "$input_file"
else
    echo "❌ Error: Conversion failed." >> "$log_file"
fi
