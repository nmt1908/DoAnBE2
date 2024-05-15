@extends('user.includes.header')

@section('content')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                   
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead> 
                                        <tr>
                                            <th>Orders #</th>
                                            <th>Date Purchased</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dslist as $ds)
                                        <tr>
                                            <td>
                                                <a href="{{route('user.orderDetail',$ds)}}">{{$ds}}</a>
                                            </td>
                                            <td>{{ $totals[$ds]['created_at'] }}</td>
                                            <td>
                                                <span class="badge bg-success">Delivered</span>
                                                
                                            </td>
                                            <td>
                                            {{ $totals[$ds]['total'] }}
                                                    
                                            </td>
                                        </tr>
                                        @endforeach  

                                    </tbody>
                                </table>
                                {!! $dslist->links('pagination::bootstrap-5',) !!}
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('customJs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



@endsection