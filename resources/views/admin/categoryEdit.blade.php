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
	        <h2 class="content-heading pt-0">Edit Category</h2>

	        <!-- Dynamic Table Full -->
	        <div class="block">
	        	<div class="block-content">
                    <div class="row">
                        <div class="col-xl-6">
                            <form id="form" action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
                            	@csrf
                                @method('PUT')
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter category title" required="" value="{{ $category->title }}">
                                        <label for="title">Title</label>
                                    </div>
                                    @if ($errors->has('title'))
                                    <span class="invalid-feedback animated fadeInDown d-block">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="file" class="form-control" id="cover_image" name="cover_image">
                                        <label for="cover_image">Cover Image <span class="text-danger ml-3">Image size 1920x480</span></label>
                                    </div>
                                    @if(!empty($category->cover_image))
                                    <img src="{{URL::to('/')}}/public/uploads/category/{{ $category->cover_image }}" class="mt-3" alt="" width="100px">
                                    @endif

                                    @if ($errors->has('cover_image'))
                                    <span class="invalid-feedback animated fadeInDown d-block">{{ $errors->first('cover_image') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
	                                <label class="form-control-label">Status</label>
                                	<div class="">
	                                	<label class="css-control css-control-sm css-control-success css-radio">
	                                        <input type="radio" class="css-control-input" name="status" required="" value="1" @if($category->status == 1) checked @endif>
	                                        <span class="css-control-indicator"></span> Active
	                                    </label>
	                                    <label class="css-control css-control-sm css-control-danger css-radio">
	                                        <input type="radio" class="css-control-input" name="status" value="0" @if($category->status == 0) checked @endif>
	                                        <span class="css-control-indicator"></span> Inactive
	                                    </label>
	                                </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-alt-primary mr-1"><i class="fa fa-check-circle"></i> Submit</button>
                                    <a href="{{ route('category.index') }}" class="btn btn-alt-danger"><i class="fa fa-times-circle"></i> Cancel</a>
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
            }
        });
	});
</script>
@endsection