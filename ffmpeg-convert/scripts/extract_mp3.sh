#!/bin/bash
in="$1"; out="$2"; log="$3"
echo "Extracting MP3…" >> "$log"
ffmpeg -i "$in" -vn -c:a libmp3lame -q:a 2 "$out" >> "$log" 2>&1