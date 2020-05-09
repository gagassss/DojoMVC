# what is Dojomvc
*dojomvc is framework PHP MVC for anyone who build a web sites. this is open source, so u can add features, fix some a bug*

# Dojomvc version
*V.1.0*

# Requirements
*PHP version ^5.6*

# features
- *Model-View-Controller Based System*
- *with a basic query database : CRUD, Where, select, orderBy, Limit clauses*
- *pretty URLs*

# User guide

## folder
**1. public folder**
contains something that will be presented / displayed to the user, allowing you to save CSS, Javascript files and images.

**2. app folder**
contains something that cannot be seen by the user except you (the developer).

## model-view-controller
Dojomvc is based on the model-view-controller,sure with helper query database
**1. The Model** represents your data structures. Typically your model classes will contain functions that help you retrieve, insert, and update information in your database.

**2. The View** is the information that is being presented to a user. A View will normally be a web page, but in dojoMVC, a view can also be a page fragment like a header or footer. It  can also be an RSS page, or any other type of “page”.

**3. The Controller** serves as an intermediary between the Model, the View, and any other resources needed to process the HTTP request and generate a web page.

## controllers
**1. what is a controllers**
A Controller is simply a class file that is named in a way that can be associated with a URI.

**2. create yourself controllers**
if you make your own controller make sure it extends to **'Dojo_controller'**, by default, the default controller is **'home'**, and you can change this in file config.php.
if the user types the controller in a url that does not exist, the default controller will be used and the default controller will run when a web is opened, each controller must have a default method with the name **index**.
example :
```php
class Home extends Dojo_controller
{
  public function index()
  {
    //
  }
}
```

**3. Organizing Your Controllers**
separate each controllers in a different file or Sub-directories.
controllers are stored in your **app/controllers/here**

## method
In the above example the method name is index(). The “index” method is always loaded by default if the second segment of the URI is empty.

example :
```php
class Home extends Dojo_controller
{
  public function index() // index is a default method
  {

  }
}
```

## models
**1. what is a model**
"Models are PHP classes that are designed to work with information in your database. You might have a model class that contains functions to insert, update, and retrieve your blog data". -codeigniter.
if you make your own models make sure it extends to **'Dojo_model'.**

**2. Organizing Your models**
separate each models in a different file or Sub-directories.
models are stored in your app/models/here

**3. load and called model**
the model will be loaded and called from your controller, to load the model you must use the following method : 
**$this->model('model_name')->method_name();**

if the model is in a sub-directory, include the relative path from your models directory. For example, if you have a model located at **app/models/blog/user.php** you load it using:
**$this->model->('blog/user');**

that a example of a controller, that load a model : 

```php
class home extends Dojo_controller
{
  public function index()
  {
    $this->model->('blog')->user();
  }
}
```
**4. create a model**
```php
class blog extends Dojo_model
{
  public function user()
  {
    //
  }
}
```

## views
**1. what is a view**
A view is simply a web page, or a page fragment, like a header, footer, sidebar, etc. In fact, views can flexibly be embedded within other views (within other views, etc., etc.) if you need this type of hierarchy.

Views are never called directly, they must be loaded by a controller. Remember that in an MVC framework, the Controller acts as the traffic cop, so it is responsible for fetching a particular view. If you have not read the Controllers page you should do so before continuing.

**## load and called view**

the view will be loaded and called from your controller, to load the model you must use the following method : 
**$this->view('view_name');**

## storing view with sub-directories
Your view files can also be stored within sub-directories if you prefer that type of organization. When doing so you will need to include the directory name loading the view. Example : 
**$this->view('directory_name/file_name');**

for example of a controller, that load a view : 
```php
class home extends Dojo_controller
{
  public function index()
  {
    $this->view->('login');
  }
}
```

## send data to view

Data is passed from the controller to the view by way of an object in the second parameter of the view loading method. Here is an example using an array : 
```php
class home extends Dojo_controller
{
  public function index()
  {
    $data['user'] = $this->db->get_data('user'); // data obtained from database queries and then sent to view
    $data['page'] = 'login';
    $this->view->('login', $data);
  }
}
```
in the file view, using data that has been sent from the controller can be in the following way, example : 
```php
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $data['page']; ?></title>
</head>
<body>
  <?php var_dump($data['user']); ?>
</body>
</html>
```
## database

**1. config database**
setting up your configuration database,in this framework, only for Mysql

**2. Automatically Connecting**
The “auto connect” feature will load and instantiate the database class with every page load. To enable “auto connecting”, open file config.php in **app/core/config.php**
and set 'true'(by default is false) in option 'auto connect to database/auto_connect_db'

**3. manually connecting**
If only some of your pages require database connectivity you can manually connect to your database by adding this line of code in any function where it is needed, or in your class constructor to make the database available globally in that class, example : 
**$this->database();**

## query database
query builder class makes it easy for you to query the database, such as get data, inserting data, deleting data, where, select,

**1. get_data()**
function to build SQL SELECT, retrieve  all records from a table and return an array of assoc example :

return $this->db->get_data('mytable'); // SELECT * FROM mytable

**2. where()**, looking for specific data
you can use function where() for read, update & delete query.
This function enables you to set WHERE clauses using method assoc array example :
```php
$this->db->where(['country' => 'USA']); //keys is field in table, values is condition
// WHERE country = 'USA';
$this->db->get_data('user'); //SELECT * FROM user WHERE country = 'USA';
```
other example :
```php
$specific_data = [ 
  'country' => 'USA',
  'city' => 'new york',
  'type' => 'and' 
  // 'type' by default is 'or', whenever you can change the type in end key/value, and make sure the type is at the end of the array
];
$this->db->where($specific_data); 
//keys is field in table, values is condition
return $this->db->get_data('user'); 
//SELECT * FROM user WHERE country = 'USA' AND city ='new york';
```
**3. select()**, Permits you to write the SELECT portion of your query
If you are selecting all (*) from a table you do not need to use this function. When omitted, dojomvc assumes that you wish to select all fields and automatically adds ‘SELECT *’.
example :
```php
$this->db->select(['country', 'city']); 
//write of an array not a string!
return $this->db->get_data('user');
// SELECT country, city FROM user;
```

**4. limit()**
limit the number of rows you would like returned by, example :
```php
$this->db->limit(10) 
// LIMIT 10
return $this->db->get_data('user'); 
// SELECT * FROM user LIMIT 10
```
**5. order_by()**, set an ORDER BY clause.
The first parameter contains the name of the column you would like to order by (ASC or DESC).
```php
$this->db->order_by('country desc') 
// ORDER BY country DESC
```
if you need multiple fields, example : 
```php
$this->db->order_by(['country asc', 'city desc']) //write of an array!
// ORDER BY country asc, city desc;
```
**6. insert_data()**
Generates data you supply, and runs the query(inserting data), you only can use assoc array to the function, example : 
```php
$data = [
  'name' => 'andy',
  'country' => 'indonesia',
  'city' => 'jakarta'
]; 
// keys is table name, values is a data  you would like to insert to table.
$this->db->insert_data('user', $data); 
// INSERT INTO user (name, country, city) VALUES ('andy', 'indonesia', 'jakarta');
```
this function will return a boolean, true if success, false if failed.

**7. delete_data()**
delete SQL query, example :
```php
$this->db->delete_data('user', ['id', '3']) 
// DELETE FROM user WHERE id = '3';
```
The first parameter is the table name, the second is the where clause, if the second parameter is null(by default null) so query will execute as "DELETE FROM mytable"

other example, use the where() : 
```php
$this->db->where(['id' => '3']); 
// use where()
$this->db->delete_data(user);
```
specific data to delete : 
```php
$this->db->where(['id' = > 3, 'first_name' = > 'andy', 'last_name' => 'john']); || $this->db->delete_data(['id' = > 3, 'first_name' = > 'andy', 'last_name' => 'john']])
```
**8. update_data()**
UPDATE SQL query.
Generates an update string and runs the query based on the data you supply, example use assoc array : 
the first parameter is the table name, the second parameter is data write of an assoc array, keys is a field name, values is data you look to change, the third is the where clause.
```php
$data = [
  'field1' => 'value1',
  'field2' => 'value2',
  'field3' => 'value3'
];
$this->db->update_data('mytable', $data, ['id' => '5']);
```
other example : 
```php
$this->db->update_data('user', ['first_name' => 'morgan', 'last_name' = > 'freeman'], ['first_name' => 'morgen']);
// UPDATE user SET first_name = 'morgan', last_name = 'freeman',  WHERE first_name = 'morgen';
```

other example use method where() :
if you use method where(), then third parameter does not need to be written
```php
$data = [
  'first_name' => 'morgan'
];
$this->db->where(['first_name' => 'morgen']);
$this->db->update_data('user', $data);
```

