#!/bin/bash
in="$1"; out="$2"; log="$3"
echo "Making GIF…" >> "$log"
ffmpeg -i "$in" -vf "fps=10,scale=480:-1:flags=lanczos" -loop 0 "$out" >> "$log" 2>&1
