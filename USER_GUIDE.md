# folder
1. public folder
contains something that will be presented / displayed to the user, allowing you to save CSS, Javascript files and images
2. app folder
contains something that cannot be seen by the user except you (the developer).

# model-view-controller
Dojomvc is based on the model-view-controller,sure with helper query database
1. The Model represents your data structures. Typically your model classes will contain functions that help you retrieve, insert, and update information in your database.

2. The View is the information that is being presented to a user. A View will normally be a web page, but in Dojomvc, a view can also be a page fragment like a header or footer. It  can also be an RSS page, or any other type of “page”.

3. The Controller serves as an intermediary between the Model, the View, and any other resources needed to process the HTTP request and generate a web page.

# URI Segments

The segments in the URL, in following with the Model-View-Controller approach, usually represent.

> example.com/class/function/ID

1. The first segment represents the controller class.
1. The second segment represents the class function, or method, that should be called.
1. The third, and any additional segments, represent the ID and any variables that will be passed to the controller.


# controllers
A Controller is simply a class file that is named in a way that can be associated with a URI.

**define your controller**

if you want to make your own controller make sure it extends to 'Dojo_controller', by default, the default controller is 'Home', and you can change it in ***/app/core/config.php***.

if the user types the controller in a url that does not exist, the default controller will be used and the default controller will run when a web is opened, each controller must have a default method with the name index.

example, lets say user trying to access this URI :    
> **http://example.com/blog**

and then you can define your controller like this :    

```php
class blog extends Dojo_controller
{
  public function index()
  {
    echo "hello world";
  }
}
```

> keep it mind that controller name is case-sensitive, if the path url is **/blog** so you need give name the controller **blog** not **Blog**

# method
The “index” method is always loaded by default if the second segment of the URI is empty.

**The second segment of the URI determines which method in the controller gets called.**

lets try add a new method to your controller

```php
class blog extends Dojo_controller
{
  public function index() // index is a default method
  {
    echo "hello world";
  }
  public function read() {
    echo "its hello world from read method!";
  }
} 
```

# Dynamic route

if your URI contains more than two segments they will be passed to your method as parameters.

lets say you have a URI like this:   

> example.com/user/detail/12

your method will passed URI segments 3 (12):    

```php
<?php 
  class user extends Dojo_controller {

    public function detail($id) {
      echo $id;
    }

  }

?>
```

# models
if you make your own models make sure it extends to 'Dojo_model'.

**load and called model**
if the model is in a sub-directory, include the relative path from your models directory. For example, if you have a model located at app/models/blog/user.php you load it using:
$this->model->('blog/user');

example :    
```php
class home extends Dojo_controller
{
  public function index()
  {
    $this->model->('movies')->get_movies();
  }
}
```

# views
A view is simply a web page, or a page fragment, like a header, footer, sidebar, etc. In fact, views can flexibly be embedded within other views (within other views, etc., etc.) if you need this type of hierarchy.

**load view**

the view will be called from your controller, to load the view you must use the following method : 
$this->view('view_name');

example:   

```php
class home extends Dojo_controller
{
  public function index()
  {
    $this->view->('login');
  }
}
```

# passing data to the view

you can passing data to the view, look this example:   

```php
class home extends Dojo_controller
{
  public function index()
  {
    $data['user'] = $this->model('user')->get_user(); // data obtained from database queries and then sent to view
    $data['page'] = 'homepage';
    $this->view->('homepage', $data);
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
  <?php echo $data['user']; ?>
</body>
</html>
```

# database

1. config database
setting up your configuration database,in this framework, only for Mysql

2. Automatically Connecting
The “auto connect” feature will load and instantiate the database class with every page load. To enable “auto connecting”, open file config.php in app/core/config.php 
and set 'true'(by default is false) in option 'auto connect to database/auto_connect_db'

3. manually connecting
If only some of your pages require database connectivity you can manually connect to your database by adding this line of code in any function where it is needed, or in your class constructor to make the database available globally in that class, example : 
$this->database();

# query database
query builder class makes it easy for you to query the database, such as get data, inserting data, deleting data, where, select,

1. get_data()
function to build SQL SELECT, retrieve  all records from a table and return an array of assoc example :

return $this->db->get_data('mytable'); // SELECT * FROM mytable

2. where(), looking for specific data
you can use function where() for read, update & delete query.
This function enables you to set WHERE clauses using method assoc array example :
$this->db->where(['country' => 'USA']); //keys is field in table, values is condition
// WHERE country = 'USA';
$this->db->get_data('user'); //SELECT * FROM user WHERE country = 'USA';

other example :
$specific_data = [ 
  'country' => 'USA',
  'city' => 'new york',
  'type' => 'and' // 'type' by default is 'or', whenever you can change the type in end key/value
];
$this->db->where($specific_data); //keys is field in table, values is condition
return $this->db->get_data('user'); //SELECT * FROM user WHERE country = 'USA' AND city ='new york';

3. select(), Permits you to write the SELECT portion of your query
If you are selecting all (*) from a table you do not need to use this function. When omitted, dojomvc assumes that you wish to select all fields and automatically adds ‘SELECT *’.
example :
$this->db->select(['country', 'city']); //write of an array not a string!
return $this->db->get_data('user');
// SELECT country, city FROM user;

4. limit()
limit the number of rows you would like returned by, example :
$this->db->limit(10) // LIMIT 10
return $this->db->get_data('user'); // SELECT * FROM user LIMIT 10

5. order_by() // set an ORDER BY clause.
The first parameter contains the name of the column you would like to order by (ASC or DESC).
$this->db->order_by('country desc') //ORDER BY country DESC

if you need multiple fields, example : 
$this->db->order_by(['country asc', 'city desc']) //write of an array!
// ORDER BY country asc, city desc;

6. insert_data()
Generates data you supply, and runs the query(inserting data), you only can use assoc array to the function, example : 
$data = [
  'name' => 'andy',
  'country' => 'indonesia',
  'city' => 'jakarta'
]; // keys is table name, values is a data  you would like to insert to table.
$this->db->insert_data('user', $data); //INSERT INTO user (name, country, city) VALUES ('andy', 'indonesia', 'jakarta');
this function will return a boolean, true if success, false if failed.

7. delete_data()
delete SQL query, example :
$this->db->delete_data('user', ['id', '3']) // DELETE FROM user WHERE id = '3';
The first parameter is the table name, the second is the where clause, if the second parameter is null(by default null) so query will execute as "DELETE FROM mytable"

other example, use the where() : 
$this->db->where(['id' => '3']); // use where()
$this->db->delete_data(user);

specific data to delete : 
$this->db->where(['id' = > 3, 'first_name' = > 'andy', 'last_name' => 'john']); || $this->db->delete_data(['id' = > 3, 'first_name' = > 'andy', 'last_name' => 'john']])

8. update_data() 
UPDATE SQL query.
Generates an update string and runs the query based on the data you supply, example use assoc array : 
the first parameter is the table name, the second parameter is data write of an assoc array, keys is a field name, values is data you look to change, the third is the where clause.
$data = [
  'field1' => 'value1',
  'field2' => 'value2',
  'field3' => 'value3'
];
$this->db->update_data('mytable', $data, ['id' => '5']);

other example : 
$this->db->update_data('user', ['first_name' => 'morgan', 'last_name' = > 'freeman'], ['first_name' => 'morgen']);
// UPDATE user SET first_name = 'morgan', last_name = 'freeman',  WHERE first_name = 'morgen';

other example use method where() :
if you use method where(), then third parameter does not need to be written
$data = [
  'first_name' => 'morgan'
];
$this->db->where(['first_name' => 'morgen']);
$this->db->update_daa('user', $data);

