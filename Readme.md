**Infirmary Integrated: Electronic Health Record**
<br>
(c) 2024, Ibi Keller (tanjera)

Infirmary Integrated is free and open-source software suite consisting of the Infirmary Integrated Simulator, Scenario Editor, and Development Tools designed to advance healthcare education for medical and nursing professionals and students. Developed as in-depth, accurate, and accessible educational tools, Infirmary Integrated can meet the needs of clinical simulators in emergency, critical care, obstetric, and many other medical and nursing specialties.

Infirmary Integrated's Electronic Health Record (EHR) is a simulated electronic health record for use in medical and nursing education.

**Instructions for Setup**

Installing the project files:
1. Copy the repository to your web server of choice.
2. Create the environment file `base/.env`... you may want to use `base/.env.example` as a template.
3. Place your relevant database information in `base/.env`
4. Install dependencies: `composer` and `npm`
5. From the `base` directory, run `php artisan key:generate` to create a unique security key.
6. From the `base` directory, run `php artisan migrate` to setup your database.
7. From the `base` directory, run `php artisan storage:link` to setup the storage driver.

Setting up your web server:
1. Point your web server's web root to the folder `base/public`
2. Ensure your web server is serving the site's folder with PHP enabled.
3. Ensure your web server has proper access to all files (e.g. ownership and write access, especially to base/storage and base/bootstrap/cache)
4. You may use https://laravel.com/docs/11.x/deployment as a brief configuration guide.
5. Consider increasing your web server's file upload sizes to allow for note attachments and diagnostic imaging uploads (e.g. images, videos; up to 100 Mb allowed per form submission). This may need to be set for *both* your web server and the PHP interpreter. Instructions for nginx [can be found here.](https://www.cyberciti.biz/faq/linux-unix-bsd-nginx-413-request-entity-too-large/)

Configuring Infirmary Integrated: Electronic Health Record
1. In a web browser, navigate to the project site's main page. If on the web server: `http://localhost`
2. Register as a new user. The first user registered to the site automatically receives `administrator` privileges.
3. Proceed into the Electronic Health Record and customize as you'd like!

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
