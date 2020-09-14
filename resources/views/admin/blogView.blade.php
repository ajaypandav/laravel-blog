@extends('admin.layouts.default')

@section('css_before')
<link rel="stylesheet" href="{{ asset('public/admin/assets/js/plugins/magnific-popup/magnific-popup.css') }}">
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
	        <h2 class="content-heading pt-0">View Blog <a href="{{ url('/admin/blog') }}" class="btn btn-alt-danger float-right"><i class="fa fa-chevron-circle-left"></i> Back</a></h2>


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
	        	<div class="block-header block-header-default d-block">
	        		<h3 class="block-title">{{ $blog->title }}</h3>
	        	</div>
	            <div class="block-content block-content-full">
	                <table class="table table-striped w-100 js-gallery">
	                    <tbody>
	                    	<tr>
	                    		<td>Title</td>
	                    		<td>{{ $blog->title }}</td>
	                    	</tr>
	                    	<tr>
	                    		<td>Categories</td>
	                    		<td>{{ $category }}</td>
	                    	</tr>
	                    	<tr>
	                    		<td>Header Image</td>
	                    		<td>
	                    			@if(!empty($blog->header_image))
	                    			<a class="img-link img-link-zoom-in img-thumb img-lightbox p-0" href="{{URL::to('/')}}/public/uploads/blog/cover/{{ $blog->header_image }}">
                                    	<img src="{{URL::to('/')}}/public/uploads/blog/cover/{{ $blog->header_image }}" alt="" width="100px">
                                    </a>
                                    @endif
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<td>Image</td>
	                    		<td>
	                    			@if(!empty($blog->image))
	                    			<a class="img-link img-link-zoom-in img-thumb img-lightbox p-0" href="{{URL::to('/')}}/public/uploads/blog/{{ $blog->image }}">
                                    	<img src="{{URL::to('/')}}/public/uploads/blog/{{ $blog->image }}" alt="" width="100px">
                                    </a>
                                    @endif
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<td>Description</td>
	                    		<td>{!! $blog->description !!}</td>
	                    	</tr>
	                    	<tr>
	                    		<td>Tags</td>
	                    		<td>{{ $tags }}</td>
	                    	</tr>
	                    	<tr>
	                    		<td>Hot Post</td>
	                    		<td>@if($blog->hot_post == 1) Yes @else No @endif</td>
	                    	</tr>
	                    	<tr>
	                    		<td>Status</td>
	                    		<td>@if($blog->status == 1) Active @else No @endif</td>
	                    	</tr>
	                    </tbody>
	                </table>
	            </div>
	        </div>
	        <!-- END Dynamic Table Full -->
	    </div>
	</main>
</div>
@endsection

@section('js_after')
<script src="{{ asset('public/admin/assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

<script type="text/javascript">
    jQuery(function () {
        Codebase.helpers('magnific-popup');
    });
</script>
@endsection
