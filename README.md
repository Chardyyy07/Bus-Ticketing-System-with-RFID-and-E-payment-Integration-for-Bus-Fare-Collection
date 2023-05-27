# Bus Ticketing System with RFID and E-payment Integration for Bus Fare Collection
TripsPH: Transportation RFID Integrated Payment System using PHP
Repository natin para sa mga code para makita yung changes or per commit ng code sa project natin. Para 
maging organize yung mga code tas makita natin yung progress natin. Yun lang thanks.

### ****How to Deploy****
### ****Creating the Database Table****

Create a table named *tripsph* inside your MySQL database using the following code.

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Create Cardholders table
CREATE TABLE Cardholders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cardholder_id INT,
    card_number VARCHAR(255),
    cardholder_name VARCHAR(255),
    cardholder_email VARCHAR(255),
    PASSWORD VARCHAR(255),
    balance DECIMAL(10, 2),
    STATUS ENUM('Active', 'Inactive'),
    date_created DATE,
    INDEX idx_cardholder_id (cardholder_id),
    INDEX idx_card_number (card_number),
    INDEX idx_cardholder_email (cardholder_email)
    INDEX idx_ccardholder_name (cardholder_name)
    INDEX idx_balance (balance)
);

-- Create Transactions for Reloading Card table
CREATE TABLE Transactions_Reloading_Card (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cardtransaction_id INT,
    cardholder_name VARCHAR(255),
    cardholder_email VARCHAR(255),
    card_number VARCHAR(255),
    amount DECIMAL(10, 2),
    balance DECIMAL(10, 2),
    STATUS ENUM('Pending', 'Completed'),
    date_created DATE,
    INDEX idx_cardtransaction_id (cardtransaction_id),
    INDEX idx_cardholder_email (cardholder_email),
    INDEX idx_card_number (card_number)
    INDEX idx_cardholder_name (cardholder_name)
    INDEX idx_balance (balance)
);

-- Create Bus Fare Collection table
CREATE TABLE Bus_Fare_Collection (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bus_fare_id INT,
    cardholder_email VARCHAR(255),
    card_number VARCHAR(255),
    balance DECIMAL(10, 2),
    STATUS ENUM('in', 'out'),
    origin VARCHAR(255),
    destination VARCHAR(255),
    total_fare DECIMAL(10, 2),
    date_created DATE,
    INDEX idx_bus_fare_id (bus_fare_id),
    INDEX idx_cardholder_email (cardholder_email),
    INDEX idx_card_number (card_number)
    INDEX idx_balance (balance)
);


or import the tripsph.sql from C:\xampp\htdocs\TripsPH_Dashboard\assets\db\tripsph.sql to the sql section

### ****Copy files to htdocs folder****

Download the above files. Create a folder named *tripsph* inside *htdocs* folder in *xampp* directory. Finally, copy the *tripsph_dashbpard* folder inside *htdocs* folder. Now, visit [localhost/tripsph](http://localhost/tripsph_dashboard) in your browser and you should see the application.
