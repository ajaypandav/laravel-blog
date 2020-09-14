@extends('layouts.default')

@section('css_before')
<title> {{ $config->site_title }} </title>
@endsection

@section('content')
@if(!$hot_post->isEmpty())
<!-- SECTION -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div id="hot-post" class="row hot-post">
			<div class="@if(count($hot_post) == 1) col-md-12 @else col-sm-8 @endif hot-post-left">
				<!-- post -->
				<div class="post post-thumb">
					<a class="post-img" href="{{ url('/'.$hot_post[0]->url_slug) }}"><img src="{{ asset('public/uploads/blog/'.$hot_post[0]->image) }}" alt=""></a>
					<div class="post-body">
						<div class="post-category">
							@foreach($hot_post[0]->category as $category)
								<a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }}</a>
							@endforeach
						</div>
						<h3 class="post-title title-lg"><a href="{{ url('/'.$hot_post[0]->url_slug) }}">{{ $hot_post[0]->title }}</a></h3>
						<ul class="post-meta">
							<li><a href="{{ url('/author/'.strtolower($hot_post[0]->author)) }}">{{ $hot_post[0]->author }}</a></li>
							<li>{{ date('d M Y', strtotime($hot_post[0]->created_at)) }}</li>
						</ul>
					</div>
				</div>
				<!-- /post -->
			</div>
			@if(count($hot_post) > 1)
			<div class="col-sm-4 hot-post-right">
				<!-- post -->
				@for($i = 1; $i< count($hot_post); $i++)
				<div class="post post-thumb">
					<a class="post-img" href="{{ url('/'.$hot_post[$i]->url_slug) }}"><img src="{{ asset('public/uploads/blog/'.$hot_post[$i]->image) }}" alt=""></a>
					<div class="post-body">
						<div class="post-category">
							@foreach($hot_post[$i]->category as $category)
								<a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }}</a>
							@endforeach
						</div>
						<h3 class="post-title"><a href="{{ url('/'.$hot_post[$i]->url_slug) }}">{{ $hot_post[$i]->title }}</a></h3>
						<ul class="post-meta">
							<li><a href="{{ url('/author/'.strtolower($hot_post[$i]->author)) }}">{{ $hot_post[$i]->author }}</a></li>
							<li>{{ date('d M Y', strtotime($hot_post[$i]->created_at)) }}</li>
						</ul>
					</div>
				</div>
				@endfor
				<!-- /post -->
			</div>
			@endif
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->
@endif

<!-- SECTION -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-8">
				@if(!$recent_post->isEmpty())
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="section-title">
							<h2 class="title">Recent posts</h2>
						</div>
					</div>
					<!-- post -->
					@for($i = 0; $i < count($recent_post); $i++)
					<div class="col-sm-6">
						<div class="post">
							<a class="post-img" href="{{ url('/'.$recent_post[$i]->url_slug) }}"><img src="{{ asset('public/uploads/blog/'.$recent_post[$i]->image) }}" alt=""></a>
							<div class="post-body">
								<div class="post-category">
									@foreach($recent_post[$i]->category as $category)
										<a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }}</a>
									@endforeach
								</div>
								<h3 class="post-title"><a href="{{ url('/'.$recent_post[$i]->url_slug) }}">{{ $recent_post[$i]->title }}</a></h3>
								<ul class="post-meta">
									<li><a href="{{ url('/author/'.strtolower($recent_post[$i]->author)) }}">{{ $recent_post[$i]->author }}</a></li>
									<li>{{ date('d M Y', strtotime($recent_post[$i]->created_at)) }}</li>
								</ul>
							</div>
						</div>
					</div>
					@if($i % 2 !== 0)
					<div class="col-sm-12"></div>
					@endif
					@if ($i == 3) @break @endif
					@endfor
					<!-- /post -->
				</div>
				<!-- /row -->

				@if(count($recent_post) > 4)
				<!-- row -->
				<div class="row">
					<!-- post -->
					@for($i = 4; $i < count($recent_post); $i++)
					<div class="col-sm-4">
						<div class="post post-sm">
							<a class="post-img" href="{{ url('/'.$recent_post[$i]->url_slug) }}"><img src="{{ asset('public/uploads/blog/'.$recent_post[$i]->image) }}" alt=""></a>
							<div class="post-body">
								<div class="post-category">
									@foreach($recent_post[$i]->category as $category)
										<a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }}</a>
									@endforeach
								</div>
								<h3 class="post-title title-sm"><a href="{{ url('/'.$recent_post[$i]->url_slug) }}">{{ $recent_post[$i]->title }}</a></h3>
								<ul class="post-meta">
									<li><a href="{{ url('/author/'.strtolower($recent_post[$i]->author)) }}">{{ $recent_post[$i]->author }}</a></li>
									<li>{{ date('d M Y', strtotime($recent_post[$i]->created_at)) }}</li>
								</ul>
							</div>
						</div>
					</div>

					@if($i % 3 == 0)
					<div class="col-sm-12"></div>
					@endif

					@if ($i == 9) @break @endif
					@endfor
					<!-- /post -->
				</div>
				<!-- /row -->
				@endif
				@endif
			</div>
			<div class="col-md-4">
				<!-- ad widget-->
				<div class="aside-widget text-center">
					<a href="#" style="display: inline-block;margin: auto;">
						<img class="img-responsive" src="{{ asset('public/front/img/ad-3.jpg') }}" alt="">
					</a>
				</div>
				<!-- /ad widget -->

				<!-- category widget -->
				<div class="aside-widget">
					<div class="section-title">
						<h2 class="title">Categories</h2>
					</div>
					<div class="category-widget">
						<ul>
							@foreach($categories as $category)
							<li><a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }} <span>{{ $category->count }}</span></a></li>
							@endforeach
						</ul>
					</div>
				</div>
				<!-- /category widget -->

				@if(!$popular_post->isEmpty())
				<!-- post widget -->
				<div class="aside-widget">
					<div class="section-title">
						<h2 class="title">Popular Posts</h2>
					</div>
					
					@foreach($popular_post as $blog)
					<!-- post -->
					<div class="post post-widget">
						<a class="post-img" href="{{ url('/'.$blog->url_slug) }}"><img src="{{ asset('public/uploads/blog/'.$blog->image) }}" alt=""></a>
						<div class="post-body">
							<div class="post-category">
								@foreach($blog->category as $category)
								<a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }}</a>
								@endforeach
							</div>
							<h3 class="post-title"><a href="{{ url('/'.$blog->url_slug) }}">{{ $blog->title }}</a></h3>
						</div>
					</div>
					<!-- /post -->
					@endforeach
				</div>
				<!-- /post widget -->
				@endif
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->

<!-- SECTION -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<!-- ad -->
			<div class="col-md-12 section-row text-center">
				<a href="#" style="display: inline-block;margin: auto;">
					<img class="img-responsive" src="{{ asset('public/front/img/ad-2.jpg') }}" alt="">
				</a>
			</div>
			<!-- /ad -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->

<!-- SECTION -->
<div class="section">
	<!-- container -->
	<div class="container">
		@if(count($recent_post) > 10)
		<!-- row -->
		<div class="row">
			@for($i = 10; $i < count($recent_post); $i++)
			<div class="col-md-4">
				<!-- post -->
				<div class="post post-widget">
					<a class="post-img" href="{{ url('/'.$recent_post[$i]->url_slug) }}"><img src="{{ asset('public/uploads/blog/'.$recent_post[$i]->image) }}" alt=""></a>
					<div class="post-body">
						<div class="post-category">
							@foreach($recent_post[$i]->category as $category)
								<a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }}</a>
							@endforeach
						</div>
						<h3 class="post-title"><a href="{{ url('/'.$recent_post[$i]->url_slug) }}">{{ $recent_post[$i]->title }}</a></h3>
					</div>
				</div>
				<!-- /post -->
			</div>
			@if($i % 3 == 0)
			<div class="col-md-12 clearfix"></div>
			@endif
			@if ($i == 18) @break @endif
			@endfor
		</div>
		<!-- /row -->
		@endif
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->

<!-- SECTION -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-8">
				@if(count($recent_post) > 19)
				@for($i = 19; $i < count($recent_post); $i++)
				<!-- post -->
				<div class="post post-row">
					<a class="post-img" href="{{ url('/'.$recent_post[$i]->url_slug) }}"><img src="{{ asset('public/uploads/blog/'.$recent_post[$i]->image) }}" alt=""></a>
					<div class="post-body">
						<div class="post-category">
							@foreach($recent_post[$i]->category as $category)
								<a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }}</a>
							@endforeach
						</div>
						<h3 class="post-title"><a href="{{ url('/'.$recent_post[$i]->url_slug) }}">{{ $recent_post[$i]->title }}</a></h3>
						<ul class="post-meta">
							<li><a href="{{ url('/author/'.strtolower($recent_post[$i]->author)) }}">{{ $recent_post[$i]->author }}</a></li>
							<li>{{ date('d M Y', strtotime($recent_post[$i]->created_at)) }}</li>
						</ul>
						<p>{{ $recent_post[$i]->meta_desc }}</p>
					</div>
				</div>
				<!-- /post -->
				@endfor
				@endif
			</div>
			<div class="col-md-4">
				<!-- Ad widget -->
				<div class="aside-widget text-center">
					<a href="#" style="display: inline-block;margin: auto;">
						<img class="img-responsive" src="{{ asset('public/front/img/ad-1.jpg') }}" alt="">
					</a>
				</div>
				<!-- /Ad widget -->
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->
@endsection