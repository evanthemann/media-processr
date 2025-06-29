#!/bin/bash

# -------------------------------
# Arguments
# -------------------------------
input_file="$1"                 # Full path to input video
output_file="$2"                # Full path to output video
log_file="$(dirname "$0")/../convert.log"  # Log file in main folder

# -------------------------------
# Log start of conversion
# -------------------------------
echo "========== $(date) ==========" >> "$log_file"
echo "Starting FFmpeg conversion..." >> "$log_file"
echo "Input: $input_file" >> "$log_file"
echo "Output: $output_file" >> "$log_file"
echo "" >> "$log_file"

# -------------------------------
# Run FFmpeg conversion
# -------------------------------
/usr/local/bin/ffmpeg -i "$input_file" \
  -vf "scale=-1:1080" \
  -c:v libx264 -preset fast -crf 23 \
  -c:a aac -b:a 128k \
  "$output_file" >> "$log_file" 2>&1

# -------------------------------
# Check if conversion was successful
# -------------------------------
if [ -f "$output_file" ]; then
  echo "✅ Conversion complete: $output_file" >> "$log_file"
  echo "Deleting original file: $input_file" >> "$log_file"
  rm "$input_file"
else
  echo "❌ Conversion failed." >> "$log_file"
fi

echo "" >> "$log_file"
