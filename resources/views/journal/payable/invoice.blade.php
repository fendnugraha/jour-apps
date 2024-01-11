@extends('include.main')

@section('container')

<div class="row">
    <div class="col">
        <h1 class="text-center">Invoice</h1>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <p><strong>Invoice Number:</strong> #INV001</p>
        <p><strong>Date:</strong> January 10, 2024</p>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <h4>Customer Information</h4>
        <p><strong>Name:</strong> John Doe</p>
        <p><strong>Email:</strong> john@example.com</p>
        <p><strong>Address:</strong> 123 Main St, City, Country</p>
    </div>
</div>
<div class="row mt-4">
    <div class="col">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Product 1</td>
                    <td>2</td>
                    <td>$20</td>
                    <td>$40</td>
                </tr>
                <tr>
                    <td>Product 2</td>
                    <td>1</td>
                    <td>$50</td>
                    <td>$50</td>
                </tr>
                <!-- More rows can be added here -->
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Subtotal</strong></td>
                    <td>$90</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end"><strong>Tax (10%)</strong></td>
                    <td>$9</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                    <td>$99</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection