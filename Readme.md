**Infirmary Integrated: Electronic Health Record**
<br>
(c) 2024, Ibi Keller (tanjera)

Infirmary Integrated is free and open-source software suite consisting of the Infirmary Integrated Simulator, Scenario Editor, and Development Tools designed to advance healthcare education for medical and nursing professionals and students. Developed as in-depth, accurate, and accessible educational tools, Infirmary Integrated can meet the needs of clinical simulators in emergency, critical care, obstetric, and many other medical and nursing specialties.

Infirmary Integrated's Electronic Health Record (EHR) is a simulated electronic health record for use in medical and nursing education.

**Instructions for Setup**

Instructions are provided with commands for setting up Infirmary Integrated's EHR on a <u>fresh installation of [Debian](https://www.debian.org/) Linux</u>. Commands are identical on [Ubuntu](https://ubuntu.com/) and analogous to other Linux platforms (package managers and default directories may vary!). Instructions are analogous to other operating systems (e.g. Windows, Mac OS) but will have vastly different commands, programs, and installation paths. Some configuration may be necessary specific to your purposes. Many commands will need administrator (`root`) access, obtained using `sudo`.

<u>Installing the project files (this will likely need administrator `root` access):</u>

1. Download the latest release from the [Github repository's Release page](https://github.com/tanjera/infirmary-integrated-ehr/releases)
2. Unzip the .tar.gz archive with `tar -xzvf <path-to-downloaded-file>`
3. Move the unzipped directory to the web server's directory with `sudo mv infirmary-integrated-ehr /var/www/`

<u>Setting up the installation files and installing dependencies:</u>

4. Move to the installation directory with `cd /var/www/infirmary-integrated-ehr`
5. Create the .env file from .env.example with `cp .env.example .env`
6. Edit the .env file to your own specifications with `nano .env` ... note: testing or evaluation purposes do not need changes here.
7. Install dependencies including `php`, a few `php` packages, `composer`, and `npm` ... `sqlite` is only needed if you are not using a separate datebase (e.g. MariaDB, PostgreSQL, etc.) ... the command is `sudo apt install php php-curl php-xml php-sqlite3 npm composer`

<u>Setting up the installation's underlying Laravel framework (recommended <u>not</u> to be done as `root`!):</u>

8. Run `composer update` to refresh composer's cache
9. Run `composer install` to fetch the necessary composer package dependencies
10. Run `npm install` to fetch the necessary npm package dependences
11. Run `npm update` to update npm packages to the newest version (alternatively, you can run `npm audit fix` to just receive security updates)
12. Run `php artisan key:generate` to create your installation's cryptographic key
13. Run `php artisan migrate` to create your installation's database tables. If you are using SQLite (default), this will create your SQLite database as well.
14. Run `npm run build` to compile runtime scripts and packages- this also hosts a temporary web service that you can cancel/escape from using `Ctrl-C`

<u>Preparing the installation as a web service:</u>

14. The `storage`, `bootstrap/cache`, and `database` (if using `sqlite`) directories need to be <u>writable</u> by the web server- this can be achieved with the command `sudo chown -R www-data:www-data storage/ bootstrap/cache/ database/`

**The project is now ready to be hosted!** For testing or evaluation purposes, running `npm run build` will host your project locally but will not persist across reboots. For a persistent web service, you will need to set up a web server. Instructions for setting up a persistent web server are below, but you will still need to configure the installation with the following instructions.

<u>Configuring Infirmary Integrated: Electronic Health Record</u>

15. The installation must be hosted by a temporary or persistent web server for configuration- you can use `npm run build` for this purpose.
16. In a web browser, navigate to the installation's homepage. If on the installation machine, `http://localhost` or else you will need to navigate to the host's IP address.
17. Register as a new user. <u>The first user registered to the site automatically receives `administrator` privileges as an intentional part of this setup process.</u> All following users who register will receive minimal privileges.
18. Proceed into the Electronic Health Record and browse or customize as you'd like!

<u>Optional: Setting up an nginx web server:</u>

1. Install the web server and processing modules using `sudo apt install nginx php-fpm`
2. The package manager or operating system installer may have installed the Apache2 web server. With default configurations, only one web server can run at a time. Uninstall Apache2 with `sudo apt remove apache2` or stop and disable it with `sudo systemctl stop apache2` and `sudo systemctl disable apache2`.
3. Download the [pre-made nginx configuration file](https://github.com/tanjera/infirmary-integrated-ehr/blob/main/package/nginx/infirmary-integrated-ehr) and copy it to the `sites-available` directory with `cp <path-to-downloaded-file> /etc/nginx/sites-available/infirmary-integrated-ehr`
4. Enable the configuration file by linking it with `ln -s /etc/nginx/sites-available/infirmary-integrated-ehr /etc/nginx/sites-enabled/infirmary-integrated-ehr`
5. Reset the nginx server with `sudo systemctl restart nginx` and confirm it is running with `sudo systemctl status nginx`. To ensure that it restarts when the machine boots, enable it with `sudo systemctl enable nginx`
6. Consider increasing your web server's file upload sizes to allow for note attachments and diagnostic imaging uploads (e.g. images, videos; up to 100 Mb allowed per form submission). This may need to be set for *both* your web server and the PHP interpreter. Instructions for nginx [can be found here.](https://www.cyberciti.biz/faq/linux-unix-bsd-nginx-413-request-entity-too-large/)

<u>Optional: Setting up an Apache web server:</u>

1. Install the web server and processing modules using `sudo apt install apache2 php-fpm`
2. The package manager or operating system installer may have installed the nginx web server. With default configurations, only one web server can run at a time. Uninstall nginx with `sudo apt remove nginx` or stop and disable it with `sudo systemctl stop nginx` and `sudo systemctl disable nginx`.
3. Download the [pre-made apache2 configuration file](https://github.com/tanjera/infirmary-integrated-ehr/blob/main/package/apache2/infirmary-integrated-ehr.conf) and copy it to the `sites-available` directory with `cp <path-to-downloaded-file> /etc/apache2/sites-available/infirmary-integrated-ehr.conf`
4. Enable the configuration file by linking it with `ln -s /etc/apache2/sites-available/infirmary-integrated-ehr.conf /etc/apache2/sites-enabled/infirmary-integrated-ehr.conf`
5. Reset the apache2 server with `sudo systemctl restart apache2` and confirm it is running with `sudo systemctl status apache2`. To ensure that it restarts when the machine boots, enable it with `sudo systemctl enable apache2`
6. Consider increasing your web server's file upload sizes to allow for note attachments and diagnostic imaging uploads (e.g. images, videos; up to 100 Mb allowed per form submission). This may need to be set for *both* your web server and the PHP interpreter. Instructions for nginx [can be found here.](https://www.cyberciti.biz/faq/linux-unix-bsd-nginx-413-request-entity-too-large/)

**If exposing your web server to the internet, remember to utilize strong passwords and set up a firewall! [`ufw`](https://launchpad.net/ufw) is highly recommended and comes with a graphical frontend!**


Enjoy!
<br>
***
<br>
Copyright 2024 Ibi Keller

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
<br>
***
<br>
Note: Laravel, the framework utilized for this project and its files in their original state are licensed under the MIT license. Copyright and licensing for the Laravel framework and its packages are as follows:

Copyright (c) Taylor Otwell

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the “Software”), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
