### \***\*Creating the Database Table\*\***

Create a table named *tripsph* inside your MySQL database using the following code.

import the tripsph.sql from C:\xampp\htdocs\TripsPH_Dashboard\assets\db\tripsph.sql to the sql section

### \***\*Copy files to htdocs folder\*\***

Download the above files. Create a folder named _tripsph_ inside _htdocs_ folder in _xampp_ directory. Finally, copy the _tripsph_dashbpard_ folder inside _htdocs_ folder. Now, visit [localhost/tripsph](http://localhost/tripsph_dashboard) in your browser and you should see the application.

User == Password
1 yor@yor = yor123
3 anya@anya = anya123
1 Chard@chard = admin123

File/Folder ==== Description
Index.php ==== This is a login page
Dashboard.php ===== After successful login, User will land on this page.
Assets Folder ==== This folder has css, js, bootstarp and plugins file
Inc Folder ==== This folder has config.php file in which there is a database connection and getUserAccessRoleByID() function.
Layouts Folder ==== This folder has 3 files footer.php, header,left_sidebar.php. ==== I split static content of admin template in these files.

Update:
edit profile for who is signed in only

Todo tom:
