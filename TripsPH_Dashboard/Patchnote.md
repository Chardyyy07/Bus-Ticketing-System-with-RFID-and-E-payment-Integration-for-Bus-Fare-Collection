====================================================================
Update v0.0.8
====================================================================
Todo if need:
\*Bus Type Column
\*Email Sent sa transactions
\*Bus Schedules yung may Arrival and Departed like yungg nasa victory liners

New:
\*add link or add another page for the registered cards with credentials like total balance
\*add "no transaction found" if di na recover yung rfid sa database then back button
\*(di kaya)add load amount, email or any necessary data for the success payment
====================================================================
Update v0.0.7
====================================================================
Todo:
\*add load amount, email or any necessary data for the success payment
\*add "no transaction found" if di na recover yung rfid sa database then back button
\*add link or add another page for the registered cards with credentials like total balance
\*Bus Schedules yung may Arrival and Departed like yungg nasa victory liners

New:
\*Dashboard ilan nag load, ilan na nag transact sa bus etc
\*Jay ar save excell and edited front end sa gdrive
\*Fix yung view history with Available Balance

====================================================================
Update v0.0.6
====================================================================
Todo:
\*Dashboard ilan nag load, ilan na nag transact sa bus etc
\*Jay ar save excell and edited front end sa gdrive
\*Fix yung view history

New:
\*fix yung current_balance and total_balance of the tbl_reload_history and passenger table pero front end lang
\*Also yung "failed" type nalang is yung sa load then pag sa passenger tas failed, "insuffient balance" na
\*if fare > total_balance "insuffient balance"
\*if total_balance < 200 "insuffient balance" no computation
\*if failed yung reloading sa reload table no computation
\*if galing sa reload, "reloading" yung type
\*if galing sa passenger table without fare value, "Departed" yung type
\*if galing sa passenger table with fare value, "Arrived" yung type
\*ticket_no. resets every-day composed ng number ng row and date ex. 1-270723 (1 is row no. 27 day, 07 month, 23 )

====================================================================
Update v0.0.5
====================================================================
Todo:
\*Dashboard ilan nag load, ilan na nag transact sa bus etc
\*Jay ar save excell and edited front end sa gdrive
\*Fix yung view history
\*ayaw pa fix kaya remove ko nalang yung current_balance and total_balance of the tbl_reload_history and passenger hanap ako iba pang ways nalalagay naman yung mga balances pero pag nag uupdate lahat ng row nababago kagaya dati

New:
\*bawattt update kasama yung new sql
\*Bus ticketing code nalagay na din
\*Sql km travelled and front end
\*auto increment the id
\*ayaw pa fix kaya remove ko nalang yung current_balance and total_balance of the tbl_reload_history and passenger

====================================================================
Update v0.0.4
====================================================================
Todo:
\*Dashboard ilan nag load, ilan na nag transact sa bus etc
\*auto increment the id
\*fix the current_balance and total_balance of the tbl_reload_history and passenger na based na siya sa rfid_transaction table
\*Jay ar save excell and edited front end sa gdrive
====================================================================
New:
\*Expiration date or card validity
\*the ticket_no. and exp date work if the date is change
\*auto reset the ticket no. back to one if the date is change

Triggers sa rfid_transac
\*if fare > total_balance failed
\*if total_balance < 200 failed no computation
\*if failed yung reloading sa reload table no computation
\*if galing sa reload, "reloading" yung type
\*if galing sa passenger table without fare value "Departed" yung type
\*if galing sa passenger table with fare value "Arrived" yung type
\*ticket_no. resets every-day composed ng number ng row and date ex. 1-270723 (1 is row no. 27 day, 07 month, 23 )
====================================================================
Here is the modified code that changes the expiry date from 6 years to 2 minutes:

-- New Trigger
DELIMITER $$
CREATE TRIGGER `before_rfid_transaction_insert_check_validity` BEFORE INSERT ON `rfid_transaction` FOR EACH ROW BEGIN
DECLARE first_trans_date DATE;
DECLARE expiry_date DATE;

    SET first_trans_date = (
        SELECT MIN(date_created) FROM rfid_transaction WHERE rfid = NEW.rfid
    );

    IF first_trans_date IS NOT NULL THEN
        SET expiry_date = DATE_ADD(first_trans_date, INTERVAL 2 MINUTE);

        IF NOW() > expiry_date THEN
            SET NEW.type = 'Expired';
            SET NEW.amount = 0;
            SET NEW.Fare = 0;
            SET NEW.current_balance = 0;
            SET NEW.total_balance = 0;
            SET NEW.valid_until = expiry_date;
        ELSE
            SET NEW.valid_until = expiry_date;
        END IF;
    ELSE
        SET NEW.valid_until = DATE_ADD(NOW(), INTERVAL 2 MINUTE);
    END IF;

END

$$
DELIMITER ;
$$

==================================================================
code that changes the expiry date to 6 years :

-- New Trigger
DELIMITER $$
CREATE TRIGGER `before_rfid_transaction_insert_check_validity` BEFORE INSERT ON `rfid_transaction` FOR EACH ROW BEGIN
DECLARE first_trans_date DATE;
DECLARE expiry_date DATE;

    SET first_trans_date = (
        SELECT MIN(date_created) FROM rfid_transaction WHERE rfid = NEW.rfid
    );

    IF first_trans_date IS NOT NULL THEN
        SET expiry_date = DATE_ADD(first_trans_date, INTERVAL 6 YEAR);

        IF NOW() > expiry_date THEN
            SET NEW.type = 'Expired';
            SET NEW.amount = 0;
            SET NEW.Fare = 0;
            SET NEW.current_balance = 0;
            SET NEW.total_balance = 0;
            SET NEW.valid_until = expiry_date;
        ELSE
            SET NEW.valid_until = expiry_date;
        END IF;
    ELSE
        SET NEW.valid_until = DATE_ADD(NOW(), INTERVAL 6 YEAR);
    END IF;

END

$$
DELIMITER ;
$$

==================================================================
Update v0.0.3
==================================================================
\*Triggers sa rfid_transac
\*if fare > total_balance failed
\*if total_balance < 200 failed no computation
\*if failed yung reloading sa reload table no computation
\*if galing sa reload, "reloading" yung type
\*if galing sa passenger table without fare value, "Departed" yung type
\*if galing sa passenger table with fare value, "Arrived" yung type
\*ticket_no. resets every-day composed ng number ng row and date ex. 1-270723 (1 is row no. 27 day, 07 month, 23 )
