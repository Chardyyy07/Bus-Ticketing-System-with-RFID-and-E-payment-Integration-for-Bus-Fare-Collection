CREATE TABLE `fare_collection`(
    transaction_code VARCHAR(255) NOT NULL,
    card_uid VARCHAR(255) NOT NULL,
    total_fare BIGINT NOT NULL,
    origin VARCHAR(255) NOT NULL,
    destination VARCHAR(255) NOT NULL
);
ALTER TABLE
    fare_collection ADD PRIMARY KEY(transaction_code);
CREATE TABLE `card_info`(
    card_uid VARCHAR(255) NOT NULL,
    card_balance BIGINT NOT NULL,
    card_status VARCHAR(255) NOT NULL
);
ALTER TABLE
    card_info ADD PRIMARY KEY(card_uid);
CREATE TABLE `reload_transaction`(
    reload_id VARCHAR(255) NOT NULL,
    card_uid VARCHAR(255) NOT NULL,
    account_id BIGINT NOT NULL,
    reload_amount BIGINT NOT NULL,
    transaction_date TIMESTAMP NOT NULL
);
ALTER TABLE
    reload_transaction ADD PRIMARY KEY(reload_id);
CREATE TABLE `accounts`(
    account_id BIGINT NOT NULL,
    email VARCHAR(255) NOT NULL,
    user_fullname VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    card_uid VARCHAR(255) NOT NULL
);

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE
    accounts ADD PRIMARY KEY(account_id);
ALTER TABLE
    accounts ADD UNIQUE accounts_email_unique`(email`);
ALTER TABLE
    accounts ADD UNIQUE accounts_user_fullname_unique`(user_fullname`);
ALTER TABLE
    accounts ADD UNIQUE accounts_username_unique`(username`);
ALTER TABLE
    accounts ADD UNIQUE accounts_password_unique`(password`);
ALTER TABLE
    reload_transaction ADD CONSTRAINT reload_transaction_account_id_foreign FOREIGN KEY(account_id) REFERENCES accounts`(account_id`);
ALTER TABLE
    fare_collection ADD CONSTRAINT fare_collection_card_uid_foreign FOREIGN KEY(card_uid) REFERENCES card_info`(card_uid`);
ALTER TABLE
    accounts ADD CONSTRAINT accounts_card_uid_foreign FOREIGN KEY(card_uid) REFERENCES card_info`(card_uid`);
ALTER TABLE
    reload_transaction ADD CONSTRAINT reload_transaction_card_uid_foreign FOREIGN KEY(card_uid) REFERENCES card_info`(card_uid`);