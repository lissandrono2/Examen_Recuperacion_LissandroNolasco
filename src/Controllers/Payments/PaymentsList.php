<?php

namespace Controllers\Payments;

use Controllers\PublicController;
use Dao\Payments\PaymentsDao;
use Views\Renderer;

class PaymentsList extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["payments"] = PaymentsDao::getAllPayments();
        Renderer::render("payments/paymentslist", $viewData);
    }
}
?>