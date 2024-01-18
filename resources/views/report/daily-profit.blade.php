@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">
            
                <h2>Daily Profit for {{ $monthName }} {{ $selectedYear }}</h2>

                <div class="row h-100">
                    <div class="col-sm-4">
                        <p>Total Profit: {{ number_format($totalProfit) }}</p>
                        <form action="/report/daily-profit" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="month" class="form-label">Select Month:</label>
                                <select name="month" id="month" class="form-select">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                    @endfor
                                </select>
                            </div>
                    
                            <div class="mb-3">
                                <label for="year" class="form-label">Select Year:</label>
                                <select name="year" id="year" class="form-select">
                                    @php
                                        $currentYear = date('Y');
                                        $startYear = 2020; // Change this to your desired start year
                                    @endphp
                                    @for ($i = $currentYear; $i >= $startYear; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                            </div>
                    <div class="col-sm overflow-y-auto">
                        <table class="table table-bordered">
                            <!-- Table header and other HTML here -->
                        
                            <tbody class="table-group-divider">
                                @foreach ($data as $item)
                                <thead>
                                    <tr class="table-dark">
                                      <th colspan="2">{{ $item['date'] }}</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Pendapatan (Revenue)</td>
                                      <td class="text-end">{{ number_format($item['revenue']) }}</td>
                                    </tr>
                                    <tr>
                                      <td>Harga Pokok Penjualan (Cost)</td>
                                      <td class="text-end">{{ number_format($item['cost']) }}</td>
                                    </tr>
                                    <tr class="table-primary fw-bold">
                                      <td>Gross Profit</td>
                                      <td class="text-end">{{ number_format($item['profit']) }}</td>
                                    </tr>
                                  </tbody>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                
                

        </main>
@endsection 