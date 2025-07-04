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
```

---

## 🚀 Features

- 🎥 Convert uploaded videos to H.264 MP4
- 🎧 Extract MP3 audio
- 🎞️ Generate animated GIFs
- ✅ Background processing with shell scripts
- 📜 Log tailing and real-time progress checking
- 🧹 Old files are automatically cleaned up between runs

---

## 🖥️ System Requirements

- macOS (tested on Monterey, 12.x)
- PHP 8.2 (installed via bottled version due to OS support limits)
- Apache (via Homebrew or macOS built-in)
- `ffmpeg` (static binary or bottle)
- `imagemagick` (optional)

> ⚠️ This repo is optimized for **older MacBooks** with macOS — great for reuse as LAN appliances.

---

## ⚙️ Installation Notes

1. **Clone the repo**
   ```bash
   git clone https://github.com/yourusername/media-processr.git
   ```

2. **Set up Apache**  
   Point your Apache root to the `media-processr` directory.

3. **Install PHP (bottled) & FFmpeg**

   If you're on an older macOS version:
   - Use an older **bottled** PHP build via Homebrew:
     ```bash
     brew install php@8.2
     ```
   - Use a **precompiled FFmpeg binary** (e.g., from [evermeet.cx](https://evermeet.cx/ffmpeg/)).

4. **Make folders writable**
   ```bash
   chmod -R 775 ffmpeg-convert/uploads
   ```

5. **Run it**
   Open in browser at `http://localhost/media-processr/`

---

## 🧪 FFmpeg Workflow

1. **Upload a file**  
   Go to `ffmpeg-convert/index.php`, upload a file.

2. **Choose conversion action**  
   You’ll be redirected to `uploaded.php`, which displays buttons like:
   - Convert to H.264 MP4
   - Extract MP3
   - Generate GIF
   - (Add your own!)

3. **Run conversion**  
   Click a button → the file is passed to `run.php`, which triggers a shell script in the background.

4. **Check progress**  
   Click "Check Progress" to view the tail of the `log.txt` file, where FFmpeg output is written in real-time.

5. **Done!**  
   When the log shows ✅ Conversion complete, a download link is displayed.

---

## 🛠️ Adding New Tools

To add a new FFmpeg or ImageMagick action:

1. Create a new shell script in `/scripts/`
2. Add a button to `uploaded.php` with the desired `preset`
3. Update `run.php` to route the preset to the correct shell script

---

## 🧹 Cleanup Behavior

- The upload directory only holds one working file at a time.
- Old files are removed automatically before new uploads.
- Shell scripts also delete inputs once conversions complete.

---

## 👨‍💻 Development Workflow

1. Work locally on your MacBook Pro
2. Push to GitHub
3. SSH into your MacBook Air server
4. Pull changes into the live project:
   ```bash
   cd ~/Sites/media-processr
   git pull
   ```

---

## 💡 Why macOS?

This MacBook Air's **power button is broken**, so macOS's **Energy Saver → Schedule** ensures the system powers on after an outage. That’s why we stuck with macOS instead of Linux.

---

## 📎 License

MIT — free to modify and deploy as you see fit.

---

## 🙌 Credits

- FFmpeg.org
- ImageMagick.org
- evermeet.cx for precompiled FFmpeg binaries

---

## 📷 Screenshots (Coming Soon)

```
[ ] Upload screen
[ ] Action selection screen
[ ] Conversion progress view
```
