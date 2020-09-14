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

	<!-- Ad widget -->
	<div class="aside-widget text-center">
		<a href="#" style="display: inline-block;margin: auto;">
			<img class="img-responsive" src="{{ asset('public/front/img/ad-1.jpg') }}" alt="">
		</a>
	</div>
	<!-- /Ad widget -->