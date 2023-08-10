<?php
class User
{
    /**
     * Register the user
     * @param $connection
     * @param $data
     * @return mixed
     */
    public function registerUser($connection, $data)
    {
        $date = date('Y-m-d H:i:s');
        $paymethod = isset($data['paymethod']) ? $data['paymethod'] : '';

        $query = "INSERT INTO tbl_reload_history SET rfid='{$data['rfid']}', email='{$data['email']}', paymethod='{$paymethod}', amount='{$data['amount']}'";
        $result = $connection->query($query) or die("Error in query: " . $connection->error);

        return $result;
    }


    /**
     * Update the payment status
     * @param $connection
     * @param $txnId
     * @param $userId
     * @return mixed
     */
    public function updatePaymentStatus($connection, $txnId, $userId)
    {
        $query = "UPDATE tbl_reload_history SET payment_status='Completed', payment_intent='$txnId' WHERE id='$userId' ";
        $result = $connection->query($query) or die("Error in query" . $connection->error);
        return $result;
    }
}
