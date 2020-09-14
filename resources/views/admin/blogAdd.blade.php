@extends('admin.layouts.default')

@section('css_before')
<link rel="stylesheet" href="{{ asset('public/admin/assets/js/plugins/summernote/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/assets/js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/assets/js/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}">
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
	        <h2 class="content-heading pt-0">Add Blog</h2>

	        <!-- Dynamic Table Full -->
	        <div class="block">
	        	<div class="block-content">
                    <form id="form" action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter blog title" required=""  value="{{ old('title') }}">
                                        <label for="title">Title</label>
                                    </div>
                                    @if ($errors->has('title'))
                                    <span class="invalid-feedback animated fadeInDown d-block">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-material">
                                        <select class="js-select2 form-control" id="cids" name="cids[]" style="width: 100%;" data-placeholder="Select Categories" multiple required="">
                                            <option></option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if(null !== (old('cids')) && in_array($category->id, old('cids'))) selected @endif>{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                        <label for="example2-select2-multiple">Categories</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="file" class="form-control" id="header_image" name="header_image" required="">
                                        <label for="header_image">Header Image <span class="text-danger ml-3">Image size 1920x720</span></label>
                                    </div>
                                    @if ($errors->has('header_image'))
                                    <span class="invalid-feedback animated fadeInDown d-block">{{ $errors->first('header_image') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="file" class="form-control" id="image" name="image" required="">
                                        <label for="image">Image <span class="text-danger ml-3">Image size 1200x800</span></label>
                                    </div>
                                    @if ($errors->has('image'))
                                    <span class="invalid-feedback animated fadeInDown d-block">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-material">
                                        <textarea name="description" id="description" class="js-summernote" required="" data-height="250px">{{ old('description') }}</textarea>
                                        <label for="description">Blog Description</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="text" class="js-tags-input form-control" data-height="34px" id="tag" name="tag" value="{{ old('tag') }}">
                                        <label for="example-tags3">Tags</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
	                                <label class="form-control-label">Status</label>
                                	<div class="">
	                                	<label class="css-control css-control-sm css-control-success css-radio">
	                                        <input type="radio" class="css-control-input" name="status" required="" value="1" @if(old('status') == 1) checked="" @endif>
	                                        <span class="css-control-indicator"></span> Active
	                                    </label>
	                                    <label class="css-control css-control-sm css-control-danger css-radio">
	                                        <input type="radio" class="css-control-input" name="status" value="0" @if(old('status') == '0') checked="" @endif>
	                                        <span class="css-control-indicator"></span> Inactive
	                                    </label>
	                                </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="css-control css-control-primary css-checkbox">
                                        <input type="checkbox" class="css-control-input" value="1" name="hot_post" id="hot_post">
                                        <span class="css-control-indicator"></span> Hot Post
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="bg-primary text-white p-2 mb-3">Meta Data</div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="text" class="form-control js-maxlength" id="meta_title" name="meta_title" placeholder="Enter meta title" value="{{ old('meta_title') }}" maxlength="60" data-always-show="true" data-placement="top">
                                        <label for="meta_title">Meta Title</label>
                                    </div>
                                    @if ($errors->has('meta_title'))
                                    <span class="invalid-feedback animated fadeInDown d-block">{{ $errors->first('meta_title') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-material">
                                        <input type="text" class="js-tags-input form-control" data-height="34px" id="meta_keyword" name="meta_keyword" value="{{ old('meta_keyword') }}">
                                        <label for="meta_keyword">Meta Keywords</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-material">
                                        <textarea name="meta_desc" id="meta_desc" class="form-control js-maxlength" placeholder="Enter meta description" maxlength="155" data-always-show="true" data-placement="top">{{ old('meta_desc') }}</textarea>
                                        <label for="meta_desc">Meta Description</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-alt-primary mr-1"><i class="fa fa-check-circle"></i> Submit</button>
                                    <a href="{{ route('blog.index') }}" class="btn btn-alt-danger"><i class="fa fa-times-circle"></i> Cancel</a>
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
<script src="{{ asset('public/admin/assets/js/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('public/admin/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('public/admin/assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('public/admin/assets/js/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function() {
        Codebase.helpers(['summernote', 'select2', 'tags-inputs', 'maxlength']);

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