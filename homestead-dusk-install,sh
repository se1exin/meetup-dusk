
#!/bin/bash

# makes sure all your repos are up to date
sudo apt-get update
# chrome dependencies I think
sudo apt-get -y install libxpm4 libxrender1 libgtk2.0-0 libnss3 libgconf-2-4
# Install Chromium Browser
sudo apt-get -y install chromium-browser
# XVFB for headless applications
sudo apt-get -y install xvfb gtk2-engines-pixbuf
# fonts for the browser
sudo apt-get -y install xfonts-cyrillic xfonts-100dpi xfonts-75dpi xfonts-base xfonts-scalable
# support for screenshot capturing
sudo apt-get -y install imagemagick x11-apps

# Set Xvfb to start at boot
sudo sh -c 'echo "#!/bin/sh -e\nXvfb -ac :0 -screen 0 1280x100000x16 &\nexit 0" > /etc/rc.local'

# Now start Xvfb for the current session
Xvfb -ac :0 -screen 0 1280x100000x16 &
