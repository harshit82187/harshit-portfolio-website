<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Document</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.bootstrap4.min.css">
	</head>
	<body>
		<h1>Student Details </h1>
		<a href="demo_form" class="btn btn-primary">Registration Foam</a>
		<br><br>
		<div class="card">
			<div class="card-body">
				<table class="table table-striped" id="dataTable">
					<thead>
						<tr>
							<th>ID</th>
							<th>NAME</th>
							<th>Date</th>
							<th>Image</th>
							<th>Action</th>
							
						</tr>
					</thead>
					<tbody>
						@foreach($student as $data)
						<tr>
							<td>{{$loop->iteration}}</td>

							<td>
								{{ Illuminate\Support\Str::limit($data->gs_answers, 15) }} <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ $data->gs_answers }}"></i>
					     	</td>

							<td>
							{{ date('d-m-Y H-i-s A', strtotime($data->created_at)) }}
							</td>

							<td>
							@if($data->image)
							        <a href="{{ asset('blog_images/'.$data->b_image) }}" download="{{ $data->b_image }}">
									<img src="{{ asset('bookings/' .$data->image) }}" alt="image" style="width:74px; height:85px; border-radius:50%;"> </a>
									@else
									<img src="{{ asset('banners') }}">
							@endif
							</td>
							<td class="d-flex">
							   <a href="#" data-toggle="modal" data-target="#request_view{{ $data->id }}" class="btn btn-info btn-sm  mr-2" >View</a>

								<a href="#" data-toggle="modal" data-target="#two_wheeler_edit{{ $data->id }}" class="btn btn-success">Edit</a>  
								<a href="" class="btn btn-sm btn-warning mr-2">Show</a>
								<a href="" class="btn btn-icon btn-primary mr-2">Show</a>
								<a href="{{ route('click_delete',$data->id) }}" onclick="return confirm('Are you want delete?')" class="btn btn-sm btn-danger">Delete </a>

							</td>
							
						</tr>


						<!-- View  Details Modal -->
							<div class="modal" id="show{{$data->id}}">
													<div class="modal-dialog modal-lg">
														<div class="modal-content" style="margin-left:172px; width:697px; margin-top:75px;">
															<!-- Modal Header -->
															<div class="modal-header">
																<h4 class="modal-title">Show Details</h4>
																<button type="button" class="close" data-dismiss="modal" style="margin-top: -25px;" >&times;</button>
															</div>
															<!-- Modal Body -->
															<div class="modal-body">
																<div class="row">

																

																<div class="col-md-6">
																	<div class="mb-3">
																	<label for="question">Title</label>
																	<input type="text" class="form-control"  name="" value="{{ $data->title }}" readonly>
																	</div>
																</div>

																<div class="col-md-6">
																	<div class="mb-3">
																	<label for="question">Description</label>
																	<input type="text" class="form-control"  name="" value="{{ $data->description }}" readonly>
																	</div>
																</div>

																<div class="col-md-6">
																<div class="mb-3">
																	<label for="answer">Tenure</label>
																	<input type="text" class="form-control" value="{{ $data->tenure }}"readonly>
																	</div>
																</div>

																<div class="col-md-6">
																	<div class="mb-3">
																	<label for="answer">Start Date</label>
																	<input type="text" class="form-control"  value="{{ $data->start_date }}"readonly>
																	</div>
																</div>

																<div class="col-md-6">
																	<div class="mb-3">
																	<label for="answer">End Date</label>
																	<input type="text" class="form-control"  value="{{ $data->end_date }}"readonly>
																	</div>
																</div>

																<div class="col-md-6">
																	<div class="mb-3">
																	<label for="answer">Future Value</label>
																	<input type="text" class="form-control"  value="{{ $data->future_value }}"readonly>
																	</div>
																</div>

																<div class="col-md-6">
																	<div class="mb-3">
																	<label for="answer">Document Type</label>
																	<input type="text" class="form-control"  value="{{ $data->document_type }}"readonly>
																	</div>
																</div>

																<div class="col-md-12">
																	<div class="mb-3">
																	<label for="answer">Download Pdf</label>
																	@if($data->redirect_url)
																		<a href="{{ asset('banners/'.$data->redirect_url) }}" download="{{ $data->redirect_url }}">
																			
																		</a>
																		@else
																		<img src="{{ asset('mou/noimage.png') }}" alt="image" style="width:74px;height:85px;border-radius:50%;">
																	@endif
																	</div>
																</div>



																</div>
																															
															</div>
														</div>
													</div>
							</div>
						<!-- End  Details Modal -->

						 <!-- Edit Two Wheeler Modal -->
						 <div class="modal" id="two_wheeler_edit{{$data->id}}">
							<div class="modal-dialog modal-lg">
								<div class="modal-content" style="margin-left:102px;">
									<!-- Modal Header -->
									<div class="modal-header">
										<h4 class="modal-title">Edit Two Wheeler</h4>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<!-- Modal Body -->
									<div class="modal-body">
										<!-- Your Form -->
										<form action="{{ route('admin.two_wheller_edit') }}" method="post">
											@csrf  

											<input type="hidden" name="id" value="{{ $data->id }}">

											
											@if($data->image)
											<img src="{{ asset('bookings/' .$data->image) }}" alt="image" style="width:103px; height:103px; border-radius:50%; margin-left:339px;">
											@endif

											<div class="form-group">
												<label for="answer">Image</label>
												<input type="file" class="form-control" name="image">
											</div>
											
											<div class="form-group">
												<label for="question">Model Name</label>
												<input type="text" class="form-control"  name="name" value="{{ $data->name }}">
											</div>

											

											<div class="form-group">
												<label for="question">Sitting Capacity</label>
												<input type="text" class="form-control"  name="capacity" value="{{ $data->capacity }}">
											</div>

											<div class="form-group">
												<label for="answer">Amount</label>
												<input type="text" class="form-control"  name="amount" value="{{ $data->amount }}">
											</div>
											
											<div class="form-group">
												<button type="submit" class="btn btn-success">Update</button>
											</div>
										</form>
									</div>
								</div>
							</div>
                         </div>
                         <!-- End Edit Two Wheeler Modal -->
						 
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<!-- jQuery, Bootstrap JS and DataTables JS -->
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>
		<script>
			$(document).ready(function (){
			    $('#dataTable').DataTable();
			});
		</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<!-- Add Tooltip Script -->
		<script>
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();
			});
		</script>
	</body>
</html>


















////////////////////// Another Example Of Datatable /////////////////////////////////////////////////

@extends('admin.layouts.master')
@section('content')
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				
				<div class="col-md-12">
					@if(session('success'))
						<div class="alert alert-success alert-dismissible">
							<a href="#" class="close" data-bs-dismiss="alert" aria-label="close">&times;</a>
							{{ session('success') }} 
						</div>
					@endif
					@if(session('error'))
						<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-bs-dismiss="alert" aria-label="close">&times;</a>
							{{ session('error') }} 
						</div>
					@endif
				</div>
				
			
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">Social Media Links</h4>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title mb-0">Listing Social Media Links</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>S. No.</th>
											<th>Facebook</th>
											<th>Instagram</th>
											<th>Twitter</th>
											<th>Youtube</th>
                                            <th>Linkedin</th>
                                            <th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $cnt = 1; if($socials){ foreach($socials as $social){ ?>
											<tr>
												<td>{{ $cnt++ }}</td>
												<td>{{ $social->facebook }}</td>
												<td>{{ $social->instagram }}</td>
												<td>{{ $social->twitter }}</td>
												<td>{{ $social->youtube }}</td>
                                                <td>{{ $social->linkedin }}</td>
												<td>

                                                </td>
											</tr>
										<?php } } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Page-content -->


	<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css">

	
	<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>






	///////////////// If Tool Tip Not Working /////////////////////////////////
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"






	///////////////// Show Real Time And Date With Day /////////////////////////////////////
	<div class="head-date">
					<?=date("l, F d, Y", strtotime(date('Y-m-d')));?>
				</div>