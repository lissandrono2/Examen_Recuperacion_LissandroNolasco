<h2>Payments List</h2>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Invoice ID</th>
                <th>Payment Date</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>
                    <a href="index.php?page=Payments_PaymentsForm&mode=INS" class="btn">
                        New
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach payments}}
            <tr>
                <td>{{PaymentID}}</td>
                <td>{{InvoiceID}}</td>
                <td>{{PaymentDate}}</td>
                <td>{{Amount}}</td>
                <td>{{PaymentMethod}}</td>
                <td>
                    <a href="index.php?page=Payments_PaymentsForm&mode=DSP&PaymentID={{PaymentID}}">
                        View
                    </a>&nbsp;
                    <a href="index.php?page=Payments_PaymentsForm&mode=UPD&PaymentID={{PaymentID}}">
                        Edit
                    </a>&nbsp;
                    <a href="index.php?page=Payments_PaymentsForm&mode=DEL&PaymentID={{PaymentID}}">
                        Delete
                    </a>&nbsp;
                </td>
            </tr>
            {{endfor payments}}
        </tbody>
    </table>
</section>