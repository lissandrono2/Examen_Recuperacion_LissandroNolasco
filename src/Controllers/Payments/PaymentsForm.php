<?php

namespace Controllers\Payments;

use Controllers\PublicController;
use Views\Renderer;
use Utilities\Site;
use Utilities\Validators;

class PaymentsForm extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";
    private $modeOptions = [
        "INS" => "New Payment",
        "UPD" => "Update Payment (%s)",
        "DEL" => "Delete Payment (%s)",
        "DSP" => "Payment Details (%s)"
    ];

    private $PaymentID = 0;
    private $InvoiceID = 0;
    private $PaymentDate = "";
    private $Amount = 0.00;
    private $PaymentMethod = "";
    private $payment_xss_token = "";

    private function loadData()
    {
        $this->PaymentID = isset($_GET["PaymentID"]) ? $_GET["PaymentID"] : 0;
        $this->mode = isset($_GET["mode"]) ? $_GET["mode"] : "DSP";
        $this->viewData["payment_xss_token"] = $this->payment_xss_token;

        if($this->PaymentID > 0){
            $payment = \Dao\Payments\PaymentsDao::getPayment($this->PaymentID);
            if ($payment){
                $this->InvoiceID = $payment["InvoiceID"];
                $this->PaymentDate = $payment["PaymentDate"];
                $this->Amount = $payment["Amount"];
                $this->PaymentMethod = $payment["PaymentMethod"];
            }
        }
    }

    private function prepareViewData(){
        $viewData["mode"] = $this->mode;
        $viewData["modeDesc"] = sprintf($this->modeOptions[$this->mode], $this->PaymentID);
        $viewData["PaymentID"] = $this->PaymentID;
        $viewData["InvoiceID"] = $this->InvoiceID;
        $viewData["PaymentDate"] = $this->PaymentDate;
        $viewData["Amount"] = $this->Amount;
        $viewData["PaymentMethod"] = $this->PaymentMethod;
        $viewData["payment_xss_token"] = $this->payment_xss_token;

        $this->viewData = $viewData; 
    }
    public function run(): void
    {
        $this->loadData();
        $this->prepareViewData();
        Renderer::render("payments/paymentsform", $this->viewData);
    }
}