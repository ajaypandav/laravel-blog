@extends('layouts.default')

@section('css_before')
<meta name="description" content="{{ substr($author->bio, 0, 155) }}">
	<meta name="keywords" content="{{ $author->name }}">
	<meta name="author" content="{{ $author->name }}">

	<title>{{ $author->name }} | {{ $config->site_title }}</title>
@endsection

@section('page_header')
<div class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-1 col-md-10 text-center">
				<div class="author">
					<img class="author-img center-block" src="{{ asset('/public/admin/uploads/users/'.$author->profile_pic) }}" alt="">
					<h1 class="text-uppercase">{{ $author->name }}</h1>
					<p class="lead">{{ $author->bio }}</p>
					<ul class="author-social">
						<li><a href="{{ $author->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<li><a href="{{ $author->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
						<li><a href="{{ $author->youtube }}" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
						<li><a href="{{ $author->instagram }}" target="_blank"><i class="fa fa-instagram"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('content')
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-8">
				@if(!$blogs->isEmpty())
				@for($i = 0; $i < count($blogs); $i++)
				<!-- post -->
				<div class="post post-row">
					<a class="post-img" href="{{ url('/'.$blogs[$i]->url_slug) }}"><img src="{{ asset('public/uploads/blog/'.$blogs[$i]->image) }}" alt=""></a>
					<div class="post-body">
						<div class="post-category">
							@foreach($blogs[$i]->category as $category)
							<a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }}</a>
							@endforeach
						</div>
						<h3 class="post-title"><a href="{{ url('/'.$blogs[$i]->url_slug) }}">{{ $blogs[$i]->title }}</a></h3>
						<ul class="post-meta">
							<li><a href="{{ url('/author/'.strtolower($blogs[$i]->author)) }}">{{ $blogs[$i]->author }}</a></li>
							<li>{{ date('d M Y', strtotime($blogs[$i]->created_at)) }}</li>
						</ul>
						<p>{{ $blogs[$i]->meta_desc }}</p>
					</div>
				</div>
				<!-- /post -->
				@endfor

				<div id="loadmore"></div>

				@if($blogs->nextPageUrl())
				<div class="section-row loadmore text-center">
					<a href="{{ $blogs->nextPageUrl() }}" class="primary-button" id="btn-load-more">Load More</a>
				</div>
				@endif

				@else
					<p>No post found.</p>
				@endif
			</div>

			<div class="col-md-4">
				@include('include.sidebar')
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
@endsection

@section('js_after')
@include('include.loadmore')
@endsection