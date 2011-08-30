chapter: Getting PHP to Talk to MySQL
==================

mysql_connect($db_host, $db_username, $db_password);

    
    
====================================

$connection = DB::connect("mysql://$db_username:$db_password@$db_host/$db_database");

    
    
====================================
Example: A template for setting database login settings
<?php
$db_host='hostname of database server';
$db_database='database name';
$db_username='username';
$db_password='password';
?>

    
    
====================================
Example: The db_login.php file with sample values filled in
<?php
$db_host='localhost';
$db_database='test';
$db_username='test';
$db_password='yourpass';
?>

    
    
====================================
Example: The SQL to recreate the test objects
--
-- Table structure for table authors
--
DROP TABLE IF EXISTS authors;
CREATE TABLE authors (
  author_id int(11) NOT NULL auto_increment,
  title_id int(11) NOT NULL default '0',
  author varchar(125) default NULL,
  PRIMARY KEY  (author_id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
--
-- Dumping data for table authors
--
INSERT INTO authors VALUES (1,1,'Ellen Siever'),(2,1,'Aaron Weber'),
                           (3,2,'Arnold Robbins'),(4,2,'Nelson H.F. Beebe');
--
-- Table structure for table books
--

DROP TABLE IF EXISTS books;
CREATE TABLE books (
  title_id int(11) NOT NULL auto_increment,
  title varchar(150) default NULL,
  pages int(11) default NULL,
  PRIMARY KEY  (title_id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
--
-- Dumping data for table books
--
INSERT INTO books VALUES (1,'Linux in a Nutshell',476),(2,'Classic Shell Scripting',256);
--
-- Table structure for table purchases
--
DROP TABLE IF EXISTS purchases;
CREATE TABLE purchases (
  id int(11) NOT NULL auto_increment,
  user varchar(10) default NULL,
  title varchar(150) default NULL,
  day date default NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
--
-- Dumping data for table purchases
--
LOCK TABLES purchases WRITE;
INSERT INTO purchases VALUES (1,'Mdavis','Regular Expression Pocket Reference','2005-02-15'),
                             (2,'Mdavis','JavaScript & DHTML Cookbook','2005-02-10');

    
    
====================================

mysql -u username -ppassword -D database_name < backup_file_name.sql

    
    
====================================

mysql -u test -pyourpass -D test < backup.sql

    
    
====================================
Example: Including the connection values and calling mysql_connect in db_test.php
// Include our login information
include('db_login.php');
// Connect
$connection = mysql_connect($db_host, $db_username, $db_password);
if (!$connection){
    die ("Could not connect to the database: <br />". mysql_error());
}

    
    
====================================

Fatal error: Call to undefined function mysql_connect() in C:\Program Files\Apache
Software Foundation\Apache2.2\htdocs\db_test.php on line 4

    
    
====================================

extension_dir = "c:/PHP/ext/"
extension=php_mysql.dll

    
    
====================================

// Select the database
$db_select=mysql_select_db($db_database);
if (!$db_select)
{
    die ("Could not select the database: <br />". mysql_error());
}

    
    
====================================

// Assign the query
$select = ' SELECT ';
$column = ' * ';
$from = ' FROM ';
$tables = ' books ';
$where = ' NATURAL JOIN authors';
$query = $select.$column.$from.$tables.$where;

    
    
====================================

// Assign the query
$query = "SELECT * FROM books NATURAL JOIN authors";

    
    
====================================

// Execute the query
$result = mysql_query( $query );
if (!$result){
   die ("Could not query the database: <br />". mysql_error(  ));
}

    
    
====================================

array mysql_fetch_row ( resource $result);

    
    
====================================

// Fetch and display the results
while ($result_row = mysql_fetch_row(($result))){
       echo 'Title: '.$result_row[1] . '<br />';
       echo 'Author: '.$result_row[4] . '<br /> ';
       echo 'Pages: '.$result_row[2] . '<br /><br />';
}

    
    
====================================

// Fetch and display the results
while ($result_row = mysql_fetch_array($result, MYSQL_ASSOC)){
       echo 'Title: '.$result_row['title'] . '<br />';
       echo 'Author: '.$result_row['author'] . '<br /> ';
       echo 'Pages: '.$result_row['pages'] . '<br /><br />';
}

    
    
====================================

mysql_close($connection)

    
    
====================================
Example: Displaying the books and authors
<?php
// Include our login information
include('db_login.php');
// Connect
$connection = mysql_connect( $db_host, $db_username, $db_password );
if (!$connection){
   die ("Could not connect to the database: <br />". mysql_error());
}
// Select the database
$db_select=mysql_select_db($db_database);
if (!$db_select){
   die ("Could not select the database: <br />". mysql_error());
}

// Assign the query
$query = "SELECT * FROM books NATURAL JOIN authors";
// Execute the query
$result = mysql_query( $query );
if (!$result){
   die ("Could not query the database: <br />". mysql_error());
}

// Fetch and display the results
while ($result_row = mysql_fetch_row(($result))){
       echo 'Title: '.$result_row[1] . '<br />';
       echo 'Author: '.$result_row[4] . '<br /> ';
       echo 'Pages: '.$result_row[2] . '<br /><br />';
}
/ /Close the connection
mysql_close($connection);
?>

    
    
====================================

Title: Linux in a Nutshell<br />Author: Ellen Siever<br /> Pages: 476<br />
<br />Title: Linux in a Nutshell<br />Author: Aaron Weber<br /> Pages: 476<br />
<br />Title: Classic Shell Scripting<br />Author: Arnold Robbins<br /
> Pages: 256<br />
<br />Title: Classic Shell Scripting<br />Author: Nelson H.F. Beebe<br /> Pages:
256<br /><br />

    
    
====================================
Example: Displaying the results of a query in an HTML table
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Displaying in an HTML table</title>
</head>
<body>
<table border="1">
    <tr>
        <th>Title</th>
        <th>Author</th>
    <th>Pages</th>
</tr>
<?php
//Include our login information
include('db_login.php');
// Connect
$connection = mysql_connect($db_host, $db_username, $db_password);
if (!$connection){
    die("Could not connect to the database: <br />". mysql_error());
}
// Select the database
$db_select = mysql_select_db($db_database);
if (!$db_select){
    die ("Could not select the database: <br />". mysql_error());
}
// Assign the query
$query = "SELECT * FROM books NATURAL JOIN authors";
// Execute the query
$result = mysql_query($query);
if (!$result){
    die ("Could not query the database: <br />". mysql_error());
}
// Fetch and display the results
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
    $title = $row["title"];
    $author = $row["author"];
    $pages = $row["pages"];
    echo "<tr>";
    echo "<td>$title</td>";
    echo "<td>$author</td>";
    echo "<td>$pages</td>";
    echo "</tr>";
}

// Close the connection
mysql_close($connection);
?>
</table>
</body>
</html>

    
    
====================================

lynx -source http://go-pear.org/ | php

    
    
====================================

php go-pear.phar

    
    
====================================

include_path = ".;c:\php\includes;c:\php\PEAR"

    
    
====================================

C:\>cd c:\php
C:\>pear install DB
C:\>pear list

    
    
====================================
Example: Displaying the books table with PEAR DB
<?php

include('db_login.php');
require_once('DB.php');

$connection = DB::connect("mysql://$db_username:$db_password@$db_host/$db_database");

if (DB::isError($connection)){
    die("Could not connect to the database: <br />".DB::errorMessage($connection));
}

$query = "SELECT * FROM books NATURAL JOIN authors";
$result = $connection->query($query);

if (DB::isError($result)){
    die("Could not query the database:<br />$query ".DB::errorMessage($result));
}

echo('<table border="1">');
echo '<tr><th>Title</th><th>Author</th><th>Pages</th></tr>';

while ($result_row = $result->fetchRow()) {
    echo "<tr><td>";
    echo $result_row[1] . '</td><td>';
    echo $result_row[4] . '</td><td>';
    echo $result_row[2] . '</td></tr>';
}

echo("</table>");
$connection->disconnect();

?>

    
    
====================================

include('db_login.php');

    
    
====================================

require_once( "DB.php" );

    
    
====================================

$connection = DB::connect("mysql://$db_username:$db_password@$db_host/$db_database");

    
    
====================================

dbtype://username:password@host/database

    
    
====================================

"mysql://test:test@localhost/test"

    
    
====================================

$query = "SELECT * FROM books"
$result = $connection->query($query);

    
    
====================================

while ($result_row = $result->fetchRow()) {
    echo 'Title: '.$result_row[1] . '<br />';
    echo 'Author: '.$result_row[4] . '<br /> ';
    echo 'Pages: '.$result_row[2] . '<br /><br />';
}

    
    
====================================

$connection->disconnect();

    
    
====================================

<?php
if ( DB::isError( $demoResult = $db->query( $sql)))
{
    echo DB::errorMessage($demoResult);
} else
{
    while ($demoRow = $demoResult->fetchRow())
     {
           echo $demoRow[2] . '<br />';
    }
}
?>

    
    
====================================
Example: Displaying the books table with PEAR:: MDB2
<?php

include('db_login.php');
require_once('MDB2.php');

//Translate our database login information into an array.
$dsn = array(
    'phptype'  => 'mysql',
    'username' => $db_username,
    'password' => $db_password,
    'hostspec' => $db_host,
    'database' => $db_database
    );

//Create the connection as an MDB2 instance.
$mdb2 = MDB2::factory($dsn);
if (PEAR::isError($mdb2)) {
    die($mdb2->getMessage());
}

//Set the fetchmode to field associative.
$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);

$query = "SELECT * FROM books NATURAL JOIN authors";
$result =$mdb2->query($query);
if (PEAR::isError($result)){
    die("Could not query the database:<br />$query ".$result->getMessage());
}

//Display the results.
echo('<table border="1">');
echo '<tr><th>Title</th><th>Author</th><th>Pages</th></tr>';

//Loop through the result set.
while ($row = $result->fetchRow()) {
    echo "<tr><td>";
    echo htmlentities($row['title']) . '</td><td>';
    echo htmlentities($row['author']) . '</td><td>';
    echo htmlentities($row['pages']) . '</td></tr>';
}

echo("</table>");

//Close the connection.
$result->free();
?>

    
    
==================