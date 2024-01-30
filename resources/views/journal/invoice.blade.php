@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">
            <h1 class="text-start display-6">INVOICE</h1>
            <div class="row">
                <div class="col-lg-6">
                   <table class="table">
                       <tr>
                           <th>Date</th>
                           <td>{{$accountTrace->date_issued}}</td>
                       </tr>
                       <tr>
                           <th>Invoice Number</th>
                           <td>{{$accountTrace->invoice}}</td>
                       </tr>
                        <tr>
                            <th>Debt</th>
                            <td>{{$accountTrace->debt->acc_name}}</td>
                        </tr>
                        <tr>
                            <th>Credit</th>
                            <td>{{$accountTrace->cred->acc_name}}</td>
                        </tr>
                   </table>
                </div>
                <div class="col-lg-6">
                    <h1 class="text-end display-2"><sup>Rp</sup> {{ number_format($accountTrace->amount) }}</h1>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$accountTrace->description}}</td>
                                <td>{{number_format($accountTrace->amount)}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-end"><strong>Total</strong></td>
                                <td>{{number_format($accountTrace->amount)}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>        
            <div class="mt-5">
                <a href="/jurnal" class="btn btn-dark"><i class="fa-solid fa-arrow-left"></i> Back</a>
                <a href="/jurnal/{{$accountTrace->id}}/edit" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i> Edit {{ $accountTrace->invoice }}</a>
                <a href="#" class="btn btn-success"><i class="fa-solid fa-print"></i> Print</a>
            </div>
        </div>


        </main>
@endsection 