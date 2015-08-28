# _Shoe Database_

##### _Lists retail outlets and shoe brands, allowing brands to be added to an outlet and visa-versa, 8/28/2015_

#### By _**Jordan J. Johansen**_

## Description

_This app allows users to browse for shoes (that may or may not be $300 f***ing dollars) either by retail outlet or by brand.  The user may add a retail outlet, update the information for that outlet, and add brands to that outlet (after the brand has been created in the first place).  The user may also create brands and then add them to individual outlets.  Either way a brand is added to a store, that match appears on both the individual brand page and the individual store page.  It utilizes a MYSQL database and a many-to-many relationship between stores and brands, connected via a join table and join statements._

## Setup

* _Clone the repository from GitHub._
* _Open a new terminal window and start the MYSQL server._
* _Start an Apache server by entering "apachectl start" in Terminal._
* _Log in to MYSQL._
* _You may either import the database directly or create it yourself._
* _Run composer install from another terminal window inside the project root folder._
* _Start a PHP server from the Terminal inside the web/ folder located in the project folder._

_For a complete list of SQL commands used to start the server and set up the appropriate databases and tables manually, consult sql.txt.  Once you've started apachectl, navigate to "localhost:8080/phpmyadmin" and log in using "root" as both username and password.  Click on the "shoes" database to the left, click on the "Operations" tab, and enter "shoes_test" into the "Copy database to" field.  Select the "Structure only" radio and then click "Go".  This will allow you to run the PHPUnit tests._

## Technologies Used

_MYSQL, phpMyAdmin, Apache Server, Silex, Twig, PHPUnit testing._

### Legal

Copyright (c) 2015 **_Jordan J. Johansen_**

This software is licensed under the MIT license.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
