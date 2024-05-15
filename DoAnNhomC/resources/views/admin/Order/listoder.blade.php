@extends('admin.navbar')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<!-- Content Wrapper. Contains page content -->

				<!-- Content Header (Page header) -->
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Orders</h1>
							</div>
							<div class="col-sm-6 text-right">
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<div class="card">
							<div class="card-header">
								<div class="card-tools">
									<div class="input-group input-group" style="width: 250px;">
										<input type="text" name="table_search" class="form-control float-right" placeholder="Search">
					
										<div class="input-group-append">
										  <button type="submit" class="btn btn-default">
											<i class="fas fa-search"></i>
										  </button>
										</div>
									  </div>
								</div>
							</div>
							<div class="card-body table-responsive p-0">								
								<table class="table table-hover text-nowrap">
									<thead>
										<tr>
											<th>Orders #</th>											
                                            <th>Customer</th>
                                            <th>Email</th>
                                            <th>Phone</th>
											<th>Status</th>
                                            <th>Total</th>
                                            <th>Date Purchased</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach($dsList->items() as $ds)
										<tr>
											<td><a href="order-detail.html">{{$ds['zip_order']}}</a></td>
											<td>{{$ds['first_fullName']}}</td>
                                            <td>{{$ds['first_email']}}</td>
                                            <td>{{$ds['first_phone']}}</td>
                                            <td>
                                                @if($ds['first_status'] == 0)
                                                    <span class="badge bg-warning">Undelivery</span>
                                                @else
                                                    <span class="badge bg-success">Delivered</span>
                                                @endif
                                            </td>
											<td>${{$ds['total_sum']}}</td>
                                            <td>{{$ds['latest_created_at']}}</td>																				
										</tr>
                                        @endforeach
										
									</tbody>
								</table>										
							</div>
                            {!! $dsList->links('pagination::bootstrap-5',) !!}
						</div>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->
			
			<!-- /.content-wrapper -->
@endsection