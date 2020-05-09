<?php
# base site url
#URL to your dojomvc root. Typically this will be your base URL,
#WITH a trailing slash:
# http::/localhost/myproject/
$config['base_url'] = 'http://localhost/';

# database config
#	['hostname'] The hostname of your database server.
#	['username'] The username used to connect to the database
#	['password'] The password used to connect to the database
#	['database'] The name of the database you want to connect to
#	dbdriver only support mysqli
$database['hostname'] = 'localhost';
$database['username'] = 'root';
$database['password'] = '';
$database['database'] = '';


# controllers & method default
# if the user types the controller in a url that does not exist, the default controller will be used and the default controller will run when a web is opened, each controller must have a default method with the name index.

$config['controller_default'] = 'Home';

$config['404_controller'] = 'Notfound';

#auto connecting to database
#if false, you must load or called database class $this->database();
#if true connecting to database will run automatic
$config['auto_connect_db'] = false;