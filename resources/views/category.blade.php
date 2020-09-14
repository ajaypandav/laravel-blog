@extends('layouts.default')

@section('css_before')
<title>{{ $page_title }} | {{ $config->site_title }}</title>
@endsection

@section('page_header')
<div class="page-header">
	<div class="page-header-bg" style="background-image: url({{ asset('public/uploads/category/'.$header_image) }});" data-stellar-background-ratio="0.5"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-offset-1 col-md-10 text-center">
				<h1 class="text-uppercase">{{ $page_title }}</h1>
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
				<!-- post -->
				<div class="post post-thumb">
					<a class="post-img" href="{{ url('/'.$blogs[0]->url_slug) }}"><img src="{{ asset('public/uploads/blog/'.$blogs[0]->image) }}" alt=""></a>
					<div class="post-body">
						<div class="post-category">
							@foreach($blogs[0]->category as $category)
							<a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }}</a>
							@endforeach
						</div>
						<h3 class="post-title title-lg"><a href="{{ url('/'.$blogs[0]->url_slug) }}">{{ $blogs[0]->title }}</a></h3>
						<ul class="post-meta">
							<li><a href="{{ url('/author/'.strtolower($blogs[0]->author)) }}">{{ $blogs[0]->author }}</a></li>
							<li>{{ date('d F Y', strtotime($blogs[0]->created_at)) }}</li>
						</ul>
					</div>
				</div>
				<!-- /post -->

				@if(count($blogs) > 1)
				<div class="row">
					@for($i = 1; $i < count($blogs); $i++)
					<!-- post -->
					<div class="col-md-6 col-sm-6">
						<div class="post">
							<a class="post-img" href="{{ url('/'.$blogs[$i]->url_slug) }}"><img src="{{ asset('public/uploads/blog/'.$blogs[$i]->image) }}" alt="{{ $blogs[$i]->title }}"></a>
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
							</div>
						</div>
					</div>
					@if($i % 2 == 0)
					<div class="clearfix col-sm-12"></div>
					@endif
					<!-- /post -->
					@if($i == 4) @break @endif
					@endfor
				</div>
				@endif

				@if(count($blogs) > 5)
				@for($i = 5; $i < count($blogs); $i++)
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
				@endif

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