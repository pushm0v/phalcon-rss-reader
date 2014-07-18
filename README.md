RSS READER
================

* Programming Test for KurioApps
* Position : API/Backend Developer
* Name : Bherly Novrandy

Get Started
-----------

#### Requirements
To run this application on your machine, you need at least:

* PHP >= 5.3.11
* Apache Web Server with mod rewrite enabled
* Phalcon PHP Framework extension enabled (0.5.x)
* MySQL >= 5.x

#### Installation
* Dump SQL from file dump.sql into your MySQL Database. ( mysql -uYOURUSER -p YOURSCHEMA < dump.sql )
* Open Console / CMD
* Change directory into project's root folder
* Run : php app/cli.php

#### Usage
* Add new source of RSS : php app/cli.php main newSource [URL] [RSS_URL]
* Ex: php app/cli.php main newSource www.detik.com http://rss.detik.com/index.php/detikcom
* Fetch All RSS Sources : php app/cli.php main fetchRss

#### Cron job
* Make sure you have add RSS Sources first
* Simply add cron.sh into cron job

