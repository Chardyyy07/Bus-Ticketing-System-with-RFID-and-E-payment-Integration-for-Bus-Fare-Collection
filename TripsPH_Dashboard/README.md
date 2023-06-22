### \***\*Creating the Database Table\*\***

Create a table named *tripsph* inside your MySQL database using the following code.

import the code from tripsph.sql from C:\xampp\htdocs\TripsPH_Dashboard\database\tripsph.sql to the sql section. kopyahin niyo nalaang

### \***\*Copy files to htdocs folder\*\***

Download the above files. Create a folder named _tripsph_ inside _htdocs_ folder in _xampp_ directory. Finally, copy the _tripsph_dashbpard_ folder inside _htdocs_ folder. Now, visit [localhost/tripsph](http://localhost/tripsph_dashboard) in your browser and you should see the application.

### \***\*Accounts\*\***

User == Password
Admin == anya@anya = anya123
Editor == loid@loid = loid123
User only == yor@yor = yor123

### \***\*Buttons na maaccess ng per \*\***

1 admin = view, edit, delete, active, add, profile
2 editor = view, edit, profile, add deactivate
3 user only = view, profile, add deactivate

### \***\*Mga File Functions\*\***

Format: folder name\file with .php
admin\adminuser == folder for the admin dashboard module backend and front end
admin\adminuser\adminuser.php == Front end and backend ni Useradmin ng dashboard
admin\adminuser\ .php == the rest code para sa mga buttons

admin\bus_destination == folder for the bus_destination module backend and front end
admin\bus_destination\bus_destination.php == Front end and backend ni bus destination dashboard
admin\bus_destination\ .php == the rest code para sa mga buttons

Same also but wala pang maayos na backend and database code
admin\bus_management
admin\card_transactions
admin\personnel_management

admin\config.php == script para sa connection sa database
admin\dashboard.php == main dashboard after sign in
admin\login.php == backend and front end para sa login
admin\logout.php == logout button on admin page

assets == fonts, styles, img and javascripts
database == yung tripsph yung gagamitin

index.php == yung main website natin ng trips ph
payment.php == front end din ng payment channel natin

### \***\*Update:\*\***

### \***\*Todo:\*\***

==back-end implementation ng admin\bus_management, admin\card_transactions and admin\personnel_management
==payment channel pag aralan ko pa yung stripe then integrate sa payment.php then database
==integration ng hardware esp32 sa database natin
