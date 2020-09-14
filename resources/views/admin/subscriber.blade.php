@extends('admin.layouts.default')

@section('css_before')
<link rel="stylesheet" href="{{ asset('public/admin/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/assets/js/plugins/datatables/responsive.bootstrap4.min.css') }}">
@endsection

@section('content')
<div id="page-container" class="sidebar-o sidebar-inverse enable-page-overlay side-scroll page-header-fixed">
    <!-- Sidebar -->
    @include('admin.include.sidebar')
    <!-- END Sidebar -->

    <!-- Header -->
    @include('admin.include.header')
    <!-- END Header -->

	<main id="main-container">
	    <!-- Page Content -->
	    <div class="content">
	        <h2 class="content-heading pt-0">Subscribers</h2>

	        @if(Session::has('success'))
	            <div class="alert alert-primary">
	                {{ Session::get('success') }}
	            </div>
	        @endif

	        @if(Session::has('error'))
	            <div class="alert alert-danger">
	                {{ Session::get('error') }}
	            </div>
	        @endif

	        <!-- Dynamic Table Full -->
	        <div class="block">
	        	<form method="post" action="{{ route('subscriber.bulk') }}" onsubmit="return submitBulkAction();">
	        		@csrf
		        	<div class="block-header block-header-default d-block">
		        		<div class="row">
		        			<div class="col-sm-6 text-center text-sm-left mb-sm-0 mb-2">
		        				<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
		        					<select class="btn btn-alt-secondary pt-1 px-2" name="bulk_action" id="bulk_action">
		        						<option value=""> Bulk Action </option>
		        						<option value="2"> Delete </option>
		        					</select>
	                                <button type="submit" class="btn btn-alt-primary"><i class="fa fa-check"></i> Apply</button>
	                            </div>
		        			</div>
		        		</div>
		        	</div>
		            <div class="block-content block-content-full">
		                <table class="table table-bordered table-striped table-vcenter w-100" id="datatable">
		                    <thead>
		                        <tr>
		                            <th>
										<label class="css-control css-control-primary css-checkbox py-0">
				                            <input type="checkbox" class="css-control-input" id="check-all">
				                            <span class="css-control-indicator mr-0"></span>
				                        </label>
		                            </th>
		                            <th>Date Time</th>
		                            <th>Email</th>
		                            <th>Manage</th>
		                        </tr>
		                    </thead>
		                </table>
		            </div>
		        </form>
	        </div>
	        <!-- END Dynamic Table Full -->
	    </div>
	</main>
</div>
@endsection

@section('js_after')
<script src="{{ asset('public/admin/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/admin/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/admin/assets/js/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/admin/assets/js/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

<script type="text/javascript">
	jQuery('#datatable').dataTable({
        columnDefs: [ { orderable: false, targets: [ 0, 3 ] } ],
        order: [[ 1, "desc" ]],
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{{ url('admin/subscriber/data') }}',
        columns: [
            { data: 'checkbox', name: 'checkbox' },
            { data: 'created_at', name: 'created_at' },
            { data: 'email', name: 'email' },
            { data: 'manage', name: 'manage' }
        ]
    });
</script>
@endsection