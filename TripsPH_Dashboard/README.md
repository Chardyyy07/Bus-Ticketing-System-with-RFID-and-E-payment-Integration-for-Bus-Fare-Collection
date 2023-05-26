### ****Creating the Database Table****

Create a table named *tripsph* inside your MySQL database using the following code.

import the tripsph.sql or from C:\xampp\htdocs\TripsPH_Dashboard\assets\db\tripsph.sql to the sql section paste this in xampp SQL 

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table for users' credentials of the card
CREATE TABLE cards_user (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    card_holder_name VARCHAR(255) NULL,
    password VARCHAR(255) NULL,
    email VARCHAR(255) NOT NULL,
    card_id_number BIGINT NOT NULL,
    current_balance BIGINT NOT NULL,
    status VARCHAR(255) NOT NULL,
    date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY (email),
    UNIQUE KEY (card_id_number)
);

-- Table for users that transact and reload their card
CREATE TABLE card_reload (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    card_user_id BIGINT UNSIGNED NOT NULL,
    reload_amount BIGINT NOT NULL,
    transaction_details VARCHAR(255) NOT NULL,
    transaction_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (card_user_id) REFERENCES cards_user(id)
);

-- Table for users that transact in bus fare collection with their card
CREATE TABLE bus_fare_collection (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    card_user_id BIGINT UNSIGNED NOT NULL,
    origin VARCHAR(255) NOT NULL,
    destination VARCHAR(255) NOT NULL,
    total_fare BIGINT NOT NULL,
    transaction_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    transaction_details VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (card_user_id) REFERENCES cards_user(id)
);


### ****Copy files to htdocs folder****

Download the above files. Create a folder named *tripsph* inside *htdocs* folder in *xampp* directory. Finally, copy the *tripsph_dashbpard* folder inside *htdocs* folder. Now, visit [localhost/tripsph](http://localhost/tripsph_dashboard) in your browser and you should see the application.
