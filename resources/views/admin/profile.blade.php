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
	        <h2 class="content-heading pt-0">Profile</h2>

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

                    <form id="form" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{ Form::hidden('id', $user->id) }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="bg-primary p-2 text-white mb-2">Personal Info</div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter site title" required="" value="@if(old('name')){{old('name')}}@elseif($user->name){{$user->name}}@endif">
                                        <label for="name">Name</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="file" class="form-control" id="profile_pic" name="profile_pic">
                                        <label for="profile_pic">Profile Picture</label>
                                    </div>
                                    @if ($errors->has('profile_pic'))
                                    <span class="invalid-feedback animated fadeInDown d-block">{{ $errors->first('profile_pic') }}</span>
                                    @endif

                                    @if(!empty($user->profile_pic))
                                    <img src="{{URL::to('/')}}/public/admin/uploads/users/{{ $user->profile_pic }}" class="mt-3" alt="Profile Picture" width="80px">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <textarea name="bio" id="bio" class="form-control" placeholder="Enter about you">@if(old('bio')){{old('bio')}}@elseif($user->bio){{$user->bio}}@endif</textarea>
                                        <label for="name">Bio</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-primary p-2 text-white mb-2">Social Links</div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="url" class="form-control" id="facebook" name="facebook" placeholder="Enter facebook link" value="@if(old('facebook')){{old('facebook')}}@elseif($user->facebook){{$user->facebook}}@endif">
                                        <label for="facebook">Facebook Link</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="url" class="form-control" id="instagram" name="instagram" placeholder="Enter instagram link" value="@if(old('instagram')){{old('instagram')}}@elseif($user->instagram){{$user->instagram}}@endif">
                                        <label for="instagram">Instagram Link</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="url" class="form-control" id="twitter" name="twitter" placeholder="Enter twitter link" value="@if(old('twitter')){{old('twitter')}}@elseif($user->twitter){{$user->twitter}}@endif">
                                        <label for="twitter">Twitter Link</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="url" class="form-control" id="youtube" name="youtube" placeholder="Enter youtube link" value="@if(old('youtube')){{old('youtube')}}@elseif($user->youtube){{$user->youtube}}@endif">
                                        <label for="youtube">YouTube Link</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-alt-primary mr-1"><i class="fa fa-check-circle"></i> Submit</button>
                                    <a href="{{ url('/admin/dashboard') }}" class="btn btn-alt-danger"><i class="fa fa-times-circle"></i> Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
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
        });
	});
</script>
@endsection