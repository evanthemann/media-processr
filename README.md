# 🎞️ Media-Processr

A lightweight, home-hosted PHP web app for converting and processing media files using **FFmpeg** and **ImageMagick** — built to run on macOS, especially older hardware.

## 🧠 Overview

This project turns an old **MacBook Air** into a DIY always-on media server. Through a simple PHP web interface, you can:

- Upload a media file
- Choose an action (e.g., convert to H.264, extract MP3, generate GIF)
- Run the conversion in the background
- Check the real-time progress of your FFmpeg commands
- Download the output once complete

No JavaScript, no frameworks — just PHP, Bash, and powerful CLI tools.

---

## 🧱 Project Structure

```bash
media-processr/
├── index.php               # Homepage – select tools (FFmpeg, ImageMagick, etc.)
├── ffmpeg-convert/         # FFmpeg tools
│   ├── index.php           # File upload
│   ├── uploaded.php        # Upload confirmation + action buttons
│   ├── run.php             # Kicks off background FFmpeg scripts
│   ├── check.php           # Shows FFmpeg log tail
│   ├── scripts/            # Bash scripts for each operation
│   └── uploads/            # Temporary working directory
├── imagemagick-tools/      # ImageMagick tools (coming soon)
└── ...
