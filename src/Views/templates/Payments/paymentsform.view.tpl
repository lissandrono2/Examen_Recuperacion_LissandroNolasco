<h2>{{modeDesc}}</h2>
<section>
    <form action="index.php?page=Payments_PaymentsForm&mode={{mode}}&PaymentID={{PaymentID}}" method="post">
        <input type="hidden" name="PaymentID" value="{{PaymentID}}">
        <input type="hidden" name="token" value="{{~payment_xss_token}}" />
        <div class="row">
        <label for="PaymentID">Payment ID</label>
        <input type="text" name="PaymentID" id="PaymentID" value="{{PaymentID}}" disabled>
        </div>&nbsp;
        <div class="row">
        <label for="InvoiceID">Invoice ID</label>
        <input type="text" name="InvoiceID" id="InvoiceID" value="{{InvoiceID}}">
        </div>&nbsp;
        <div class="row">
            <label for="PaymentDate">Payment Date</label>
            <input type="date" name="PaymentDate" id="PaymentDate" value="{{PaymentDate}}">
        </div>&nbsp;
        <div class="row">
            <label for="Amount">Amount</label>
            <input type="number" step="0.01" name="Amount" id="Amount" value="{{Amount}}">
        </div>&nbsp;
        <div class="row">
            <label for="PaymentMethod">Payment Method</label>
            <input type="text" name="PaymentMethod" id="PaymentMethod" value="{{PaymentMethod}}">
        </div>&nbsp;
        <div class="row">
            <button type="submit" name="btnGuardar" id="btnGuardar">Save</button>
            &nbsp;
            <button name="btnCancelar" id="btnCancelar">Cancel</button>
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const btnCancelar = document.getElementById('btnCancelar');
        btnCancelar.addEventListener('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            window.location.href = 'index.php?page=Payments_PaymentsList';
        });
    });
</script>