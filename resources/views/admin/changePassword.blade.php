@extends('admin.layouts.default')

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
	        <h2 class="content-heading pt-0">Change Password</h2>

	        <!-- Dynamic Table Full -->
	        <div class="block">
	        	<div class="block-content">
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

                    <div class="row">
                        <div class="col-xl-6">
                            <form id="form" action="{{ route('update.password') }}" method="post" enctype="multipart/form-data">
                            	@csrf
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="password" class="form-control" id="current_pass" name="current_pass" placeholder="Enter current password" required="">
                                        <label for="current_pass">Current Password</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="password" class="form-control" id="new_pass" name="new_pass" placeholder="Enter new password" required="">
                                        <label for="new_pass">New Password</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="password" class="form-control" id="confirm_pass" name="confirm_pass" placeholder="Enter password again" required="">
                                        <label for="confirm_pass">Confirm Password</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-alt-primary mr-1"><i class="fa fa-check-circle"></i> Submit</button>
                                    <a href="{{ url('/admin/dashboard') }}" class="btn btn-alt-danger"><i class="fa fa-times-circle"></i> Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
	        </div>
	        <!-- END Dynamic Table Full -->
	    </div>
	</main>
</div>
@endsection

@section('js_after')
<script type="text/javascript">
	$(document).ready(function() {
		jQuery('#form').validate({
            errorClass: 'invalid-feedback animated fadeInDown',
            errorElement: 'div',
            errorPlacement: (error, e) => {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: e => {
                jQuery(e).closest('.form-group').removeClass('is-invalid').addClass('is-invalid');
            },
            success: e => {
                jQuery(e).closest('.form-group').removeClass('is-invalid');
                jQuery(e).remove();
            },
            rules: {
                current_pass: {
                    required: true,
                    minlength: 8
                },
                new_pass: {
                    required: true,
                    minlength: 8
                },
                confirm_pass: {
                    required: true,
                    equalTo: '#new_pass'
                }
            },
            messages: {
                confirm_pass: {
                    equalTo: 'Enter same password again.'
                }
            }
        });
	});
</script>
@endsection