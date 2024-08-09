<?php

namespace Dao\Payments;

use Dao\Table;

class PaymentsDao extends Table 
{
    public static function getAllPayments()
    {
        $sqlstr = "SELECT * FROM Payments;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getPayment($PaymentID)
    {
        $sqlstr = "SELECT * FROM Payments WHERE PaymentID = :PaymentID;";
        return self::obtenerUnRegistro($sqlstr, ["PaymentID" => $PaymentID]);
    }

    public static function getPaymentWithFilter($InvoiceID){
        $sqlstr = "SELECT * FROM Payments WHERE InvoiceID = :InvoiceID;";
        return self::obtenerRegistros($sqlstr, ["InvoiceID" => $InvoiceID]);
    }

    public static function insertPayment(
        int $InvoiceID,
        string $PaymentDate,
        float $Amount,
        string $PaymentMethod
    )
    {
        $sqlstr = "INSERT INTO Payments (InvoiceID, PaymentDate, Amount, PaymentMethod)
        VALUES (:InvoiceID, :PaymentDate, :Amount, :PaymentMethod);";
        return self::executeNonQuery($sqlstr,
            [
                "InvoiceID" => $InvoiceID,
                "PaymentDate" => $PaymentDate,
                "Amount" => $Amount,
                "PaymentMethod" => $PaymentMethod
            ]
        );
    }

    public static function updatePayment(
        int $PaymentID,
        int $InvoiceID,
        string $PaymentDate,
        float $Amount,
        string $PaymentMethod
    )
    {
        $sqlstr = "UPDATE Payments SET InvoiceID = :InvoiceID, 
        PaymentDate = :PaymentDate, Amount = :Amount, PaymentMethod = :PaymentMethod
        WHERE PaymentID = :PaymentID;";
        return self::executeNonQuery(
        $sqlstr,
            [
                "PaymentID" => $PaymentID,
                "InvoiceID" => $InvoiceID,
                "PaymentDate" => $PaymentDate,
                "Amount" => $Amount,
                "PaymentMethod" => $PaymentMethod
            ]
        );
    }

    public static function deletePayment($PaymentID)
    {
        $sqlstr = "DELETE FROM Payments WHERE PaymentID = :PaymentID;";
        return self::executeNonQuery($sqlstr, ["PaymentID" => $PaymentID]);
    }
}

?>