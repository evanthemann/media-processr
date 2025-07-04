#!/bin/bash
input_file="$1"
output_file="$2"
log_file="$3"              # third arg comes from run.php

echo "========== $(date) =========="  >> "$log_file"
echo "Starting conversion…"          >> "$log_file"
echo "Input:  $input_file"           >> "$log_file"
echo "Output: $output_file"          >> "$log_file"
echo ""                              >> "$log_file"

/usr/local/bin/ffmpeg -i "$input_file" \
        -vf "scale=-1:1080" \
        -c:v libx264 -preset fast -crf 23 \
        -c:a aac -b:a 128k \
        "$output_file"                >> "$log_file" 2>&1

if [ -f "$output_file" ]; then
    echo "✅ Conversion complete"    >> "$log_file"
    rm "$input_file"
else
    echo "❌ Conversion failed"      >> "$log_file"
fi
