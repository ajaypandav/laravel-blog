@extends('layouts.default')

@section('css_before')
<meta name="description" content="{{ $blog->meta_desc }}">
	<meta name="keywords" content="{{ $blog->meta_keyword }}">
	<meta name="author" content="{{ $blog->author->name }}">
	
	<title>{{ $blog->meta_title }}</title>
@endsection

@section('page_header')
<div id="post-header" class="page-header">
	<div class="page-header-bg" style="background-image: url({{ asset('public/uploads/blog/cover/'.$blog->header_image) }});" data-stellar-background-ratio="0.5"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-10">
				<div class="post-category">
					@foreach($blog->category as $category)
					<a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }}</a>
					@endforeach
				</div>
				<h1>{{ $blog->title }}</h1>
				<ul class="post-meta">
					<li><a href="{{ url('/author/'.strtolower($blog->author->name)) }}">{{ $blog->author->name }}</a></li>
					<li>{{ date('d F Y', strtotime($blog->created_at)) }}</li>
					<li><i class="fa fa-comments"></i> {{ count($blog->comments) }}</li>
					<li><i class="fa fa-eye"></i> {{ $blog->view_count }}</li>
				</ul>
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
				<!-- post share -->
				<div class="section-row">
					<div class="post-share">
						<a href="#" class="social-facebook"><i class="fa fa-facebook"></i><span>Share</span></a>
						<a href="#" class="social-twitter"><i class="fa fa-twitter"></i><span>Tweet</span></a>
						<a href="#" class="social-pinterest"><i class="fa fa-pinterest"></i><span>Pin</span></a>
						<a href="#" ><i class="fa fa-envelope"></i><span>Email</span></a>
					</div>
				</div>
				<!-- /post share -->

				<!-- post content -->
				<div class="section-row">
					{!! $blog->description !!}
				</div>
				<!-- /post content -->

				<!-- post tags -->
				@if(!empty($blog->tag))
				<div class="section-row">
					<div class="post-tags">
						<ul>
							<li>TAGS:</li>
							@foreach($blog->tag as $tag)
							<li><a href="{{ url('/tag/'.$tag->tag) }}">{{ $tag->tag }}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
				@endif
				<!-- /post tags -->

				<!-- post nav -->
				<div class="section-row">
					<div class="post-nav">
						@if(!empty($previous))
						<div class="prev-post">
							<a class="post-img" href="{{ url('/'.$previous->url_slug) }}"><img src="{{ asset('public/uploads/blog/'.$previous->image) }}" alt=""></a>
							<h3 class="post-title"><a href="{{ url('/'.$previous->url_slug) }}">{{ $previous->title }}</a></h3>
							<span>Previous post</span>
						</div>
						@endif

						@if($next)
						<div class="next-post">
							<a class="post-img" href="{{ url('/'.$next->url_slug) }}"><img src="{{ asset('public/uploads/blog/'.$next->image) }}" alt=""></a>
							<h3 class="post-title"><a href="{{ url('/'.$next->url_slug) }}">{{ $next->title }}</a></h3>
							<span>Next post</span>
						</div>
						@endif
					</div>
				</div>
				<!-- /post nav  -->

				<!-- post author -->
				<div class="section-row">
					<div class="section-title">
						<h3 class="title">About <a href="{{ url('/author/'.strtolower($blog->author->name)) }}">{{ $blog->author->name }}</a></h3>
					</div>
					<div class="author media">
						<div class="media-left">
							<a href="{{ url('/author/'.strtolower($blog->author->name)) }}">
								<img class="author-img media-object" src="{{ asset('public/admin/uploads/users/'.$blog->author->profile_pic) }}" alt="">
							</a>
						</div>
						<div class="media-body">
							<p>{{ $blog->author->bio }}</p>
							<ul class="author-social">
								<li><a href="{{ $blog->author->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
								<li><a href="{{ $blog->author->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
								<li><a href="{{ $blog->author->youtube }}" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
								<li><a href="{{ $blog->author->instagram }}" target="_blank"><i class="fa fa-instagram"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /post author -->

				@if($related)
				<!-- /related post -->
				<div>
					<div class="section-title">
						<h3 class="title">Related Posts</h3>
					</div>
					<div class="row">
						@foreach($related as $related)
						<!-- post -->
						<div class="col-md-4">
							<div class="post post-sm">
								<a class="post-img" href="{{ url('/'.$related->url_slug) }}"><img src="{{ asset('public/uploads/blog/'.$related->image) }}" alt=""></a>
								<div class="post-body">
									<div class="post-category">
										@foreach($related->category as $category)
										<a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }}</a>
										@endforeach
									</div>
									<h3 class="post-title title-sm"><a href="{{ url('/'.$related->url_slug) }}">{{ $related->title }}</a></h3>
									<ul class="post-meta">
										<li><a href="{{ url('/author/'.strtolower($related->author)) }}">{{ $related->author }}</a></li>
										<li>{{ date('d F Y', strtotime($related->created_at)) }}</li>
									</ul>
								</div>
							</div>
						</div>
						<!-- /post -->
						@endforeach
					</div>
				</div>
				<!-- /related post -->
				@endif

				@if(!$blog->comments->isEmpty())
				<!-- post comments -->
				<div class="section-row">
					<div class="section-title">
						<h3 class="title">{{ count($blog->comments) }} Comments</h3>
					</div>
					<div class="post-comments">
						@foreach($blog->comments as $comment)
						<!-- comment -->
						<div class="media">
							<!-- <div class="media-left">
								<img class="media-object" src="{{ asset('public/front/img/avatar-2.jpg') }}" alt="">
							</div> -->
							<div class="media-body">
								<div class="media-heading">
									<h4>{{ $comment->name }}</h4>
									<span class="time">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
								</div>
								<p class="mb-0">{{ $comment->message }}</p>
							</div>
						</div>
						<!-- /comment -->
						@endforeach
					</div>
				</div>
				<!-- /post comments -->
				@endif

				<!-- post reply -->
				<div class="section-row" id="comment">
					<div class="section-title">
						<h3 class="title">Leave a reply</h3>
					</div>
					
					@if(Session::has('success'))
			            <div class="alert alert-success">
			                {{ Session::get('success') }}
			            </div>
			        @endif

					<form class="post-reply" id="comment-form" method="post" action="{{ route('blog.comment') }}">
						@csrf
						{{ Form::hidden('bid', $blog->id) }}
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<textarea class="input" name="message" placeholder="Message" required="" minlength="15">{{ old('message') }}</textarea>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input class="input" type="text" name="name" placeholder="Name" required="" value="{{ old('name') }}">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input class="input" type="email" name="email" placeholder="Email" required="" value="{{ old('email') }}">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input class="input" type="url" name="website" placeholder="Website" value="{{ old('website') }}">
								</div>
							</div>
							<div class="col-md-12">
								<button class="primary-button" type="submit">Submit</button>
							</div>
						</div>
					</form>
				</div>
				<!-- /post reply -->
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
<script type="text/javascript">
	$(document).ready(function() {
		$('#comment-form').validate({
			errorClass: 'error mb-0',
			errorPlacement: (error, e) => {
                jQuery(e).parents('.form-group').append(error);
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
	
	<?php if(Session::has('success')): ?>
		$(function(){
		    $('html, body').animate({
		        scrollTop: ($("#comment").offset().top)-140
		    }, 500);
		});
	<?php endif; ?>
</script>
@endsection