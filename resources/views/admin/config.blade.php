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
	        <h2 class="content-heading pt-0">System Configuration</h2>

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

                    <form id="form" action="{{ route('update.config') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="bg-primary p-2 text-white mb-2">Site Settings</div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="text" class="form-control" id="site_title" name="site_title" placeholder="Enter site title" required="" value="@if(old('site_title')){{old('site_title')}}@elseif($config->site_title){{$config->site_title}}@endif">
                                        <label for="site_title">Site Title</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="file" class="form-control" id="favicon" name="favicon">
                                        <label for="favicon">Favicon</label>
                                    </div>
                                    @if ($errors->has('favicon'))
                                    <span class="invalid-feedback animated fadeInDown d-block">{{ $errors->first('favicon') }}</span>
                                    @endif

                                    @if(!empty($config->favicon))
                                    <img src="{{URL::to('/')}}/public/uploads/{{ $config->favicon }}" class="mt-3" alt="Favicon" width="16px">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="file" class="form-control" id="logo" name="logo">
                                        <label for="logo">Logo</label>
                                    </div>
                                    @if ($errors->has('logo'))
                                    <span class="invalid-feedback animated fadeInDown d-block">{{ $errors->first('logo') }}</span>
                                    @endif

                                    @if(!empty($config->logo))
                                    <img src="{{URL::to('/')}}/public/uploads/{{ $config->logo }}" class="mt-3" alt="Favicon" width="100px">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="file" class="form-control" id="logo_alt" name="logo_alt">
                                        <label for="logo_alt">Logo Alt</label>
                                    </div>
                                    @if ($errors->has('logo_alt'))
                                    <span class="invalid-feedback animated fadeInDown d-block">{{ $errors->first('logo_alt') }}</span>
                                    @endif

                                    @if(!empty($config->logo_alt))
                                    <img src="{{URL::to('/')}}/public/uploads/{{ $config->logo_alt }}" class="mt-3" alt="Favicon" width="100px">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-primary p-2 text-white mb-2">Social Links</div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="url" class="form-control" id="facebook" name="facebook" placeholder="Enter facebook link" value="@if(old('facebook')){{old('facebook')}}@elseif($config->facebook){{$config->facebook}}@endif">
                                        <label for="facebook">Facebook Link</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="url" class="form-control" id="instagram" name="instagram" placeholder="Enter instagram link" value="@if(old('instagram')){{old('instagram')}}@elseif($config->instagram){{$config->instagram}}@endif">
                                        <label for="instagram">Instagram Link</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="url" class="form-control" id="twitter" name="twitter" placeholder="Enter twitter link" value="@if(old('twitter')){{old('twitter')}}@elseif($config->twitter){{$config->twitter}}@endif">
                                        <label for="twitter">Twitter Link</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="url" class="form-control" id="youtube" name="youtube" placeholder="Enter youtube link" value="@if(old('youtube')){{old('youtube')}}@elseif($config->youtube){{$config->youtube}}@endif">
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