<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	@yield('css_before')

	<link rel="shortcut icon" href="{{ asset('public/uploads/'.$config->favicon) }}">

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7CMuli:400,700" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="{{ asset('public/front/css/bootstrap.min.css') }}" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="{{ asset('public/front/css/font-awesome.min.css') }}">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="{{ asset('public/front/css/style.css') }}" />
	<link type="text/css" rel="stylesheet" href="{{ asset('public/front/css/custom.css') }}" />
</head>

<body>
	<!-- HEADER -->
	<header id="header">
		<!-- NAV -->
		<div id="nav">
			<!-- Top Nav -->
			<div id="nav-top">
				<div class="container">
					<!-- social -->
					<ul class="nav-social">
						<li><a href="{{ $config->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<li><a href="{{ $config->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
						<li><a href="{{ $config->youtube }}" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
						<li><a href="{{ $config->instagram }}" target="_blank"><i class="fa fa-instagram"></i></a></li>
					</ul>
					<!-- /social -->

					<!-- logo -->
					<div class="nav-logo">
						<a href="{{ url('/') }}" class="logo"><img src="{{ asset('public/uploads/'.$config->logo) }}" alt=""></a>
					</div>
					<!-- /logo -->

					<!-- search & aside toggle -->
					<div class="nav-btns">
						<button class="aside-btn"><i class="fa fa-bars"></i></button>
						<button class="search-btn"><i class="fa fa-search"></i></button>
						<div id="nav-search">
							<form action="{{ url('/search') }}">
								<input class="input" name="s" placeholder="Enter your search...">
							</form>
							<button class="nav-close search-close">
								<span></span>
							</button>
						</div>
					</div>
					<!-- /search & aside toggle -->
				</div>
			</div>
			<!-- /Top Nav -->

			<!-- Main Nav -->
			<div id="nav-bottom">
				<div class="container">
					<!-- nav -->
					<ul class="nav-menu">
						<li><a href="{{ url('/') }}">Home</a></li>
						<li class="has-dropdown megamenu">
							<a href="javascript:void(0);">Categories</a>
							<div class="dropdown tab-dropdown">
								<div class="row">
									<div class="col-md-2">
										<ul class="tab-nav">
											@foreach($categories as $key => $category)
											<li class="@if($key == 0) active @endif"><a data-toggle="tab" href="#tab{{$key}}">{{ $category->title }}</a></li>
											@endforeach
										</ul>
									</div>
									<div class="col-md-10">
										<div class="dropdown-body tab-content">
											@foreach($categories as $key => $category)
											<div id="tab{{$key}}" class="tab-pane fade in @if($key == 0) active @endif">
												<div class="row">
													<!-- post -->
													@foreach($category->blogs as $blog)
													<div class="col-md-4">
														<div class="post post-sm">
															<a class="post-img" href="{{ url('/'.$blog->url_slug) }}"><img src="{{ asset('/public/uploads/blog/'.$blog->image) }}" alt=""></a>
															<div class="post-body">
																<div class="post-category">
																	<a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }}</a>
																</div>
																<h3 class="post-title title-sm"><a href="{{ url('/'.$blog->url_slug) }}">{{ $blog->title }}</a></h3>
																<ul class="post-meta">
																	<li><a href="{{ url('/author/'.strtolower($blog->author)) }}">{{ $blog->author }}</a></li>
																	<li>{{ date('d F Y', strtotime($blog->created_at)) }}</li>
																</ul>
															</div>
														</div>
													</div>
													@endforeach
													<!-- /post -->
												</div>
											</div>
											@endforeach
										</div>
									</div>
								</div>
							</div>
						</li>
						<li><a href="{{ url('/about-us') }}">About Us</a></li>
						<li><a href="{{ url('/contact-us') }}">Contact Us</a></li>
					</ul>
					<!-- /nav -->
				</div>
			</div>
			<!-- /Main Nav -->

			<!-- Aside Nav -->
			<div id="nav-aside">
				<ul class="nav-aside-menu">
					<li><a href="{{ url('/') }}">Home</a></li>
					<li class="has-dropdown"><a>Categories</a>
						<ul class="dropdown">
							@foreach($categories as $category)
							<li><a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }}</a></li>
							@endforeach
						</ul>
					</li>
					<li><a href="{{ url('/about-us') }}">About Us</a></li>
					<li><a href="{{ url('/contact-us') }}">Contact Us</a></li>
				</ul>
				<button class="nav-close nav-aside-close"><span></span></button>
			</div>
			<!-- /Aside Nav -->
		</div>
		<!-- /NAV -->
		@yield('page_header')
	</header>
	<!-- /HEADER -->

	@yield('content')

	<!-- FOOTER -->
	<footer id="footer">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<div class="col-md-3">
					<div class="footer-widget">
						<div class="footer-logo">
							<a href="{{ url('/') }}" class="logo"><img src="{{ asset('public/uploads/'.$config->logo_alt) }}" alt=""></a>
						</div>
						<p>Nec feugiat nisl pretium fusce id velit ut tortor pretium. Nisl purus in mollis nunc sed. Nunc non blandit massa enim nec.</p>
						<ul class="contact-social">
							<li><a href="{{ $config->facebook }}" target="_blank" class="social-facebook"><i class="fa fa-facebook"></i></a></li>
							<li><a href="{{ $config->twitter }}" target="_blank" class="social-twitter"><i class="fa fa-twitter"></i></a></li>
							<li><a href="{{ $config->youtube }}" target="_blank" class="social-google-plus"><i class="fa fa-youtube-play"></i></a></li>
							<li><a href="{{ $config->instagram }}" target="_blank" class="social-instagram"><i class="fa fa-instagram"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-3">
					<div class="footer-widget">
						<h3 class="footer-title">Categories</h3>
						<div class="category-widget">
							<ul>
								@foreach($categories as $category)
								<li><a href="{{ url('/category/'.$category->url_slug) }}">{{ $category->title }} <span>{{ $category->count }}</span></a></li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="footer-widget">
						<h3 class="footer-title">Tags</h3>
						<div class="tags-widget">
							<ul>
								@foreach($tags as $tag)
								<li><a href="{{ url('/tag/'.$tag->tag) }}">{{ $tag->tag }}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="footer-widget">
						<h3 class="footer-title">Newsletter</h3>
						<div class="newsletter-widget">
							<form id="footer-newsletter">
								<p>Subscribe to our newsletter to receive latest updates.</p>
								<input type="email" class="input" name="footer_email" id="footer_email" placeholder="Enter Your Email">
								<button class="primary-button mt-4" type="submit">Subscribe</button>
								<div id="footer-res"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /row -->

			<!-- row -->
			<div class="footer-bottom row">
				<div class="col-md-6 col-md-push-6">
					<ul class="footer-nav">
						<li><a href="{{ url('/') }}">Home</a></li>
						<li><a href="{{ url('/about-us') }}">About Us</a></li>
						<li><a href="{{ url('/contact-us') }}">Contact Us</a></li>
					</ul>
				</div>
				<div class="col-md-6 col-md-pull-6">
					<div class="footer-copyright">
						Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved |  Developed by <a href="https://ajaypandav.github.io" target="_blank">Ajay Pandav</a>
					</div>
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</footer>
	<!-- /FOOTER -->

	<!-- jQuery Plugins -->
	<script src="{{ asset('public/front/js/jquery.min.js') }}"></script>
	<script src="{{ asset('public/front/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('public/front/js/jquery.stellar.min.js') }}"></script>
	<script src="{{ asset('public/front/js/main.js') }}"></script>
	<script src="{{ asset('public/front/js/jquery.validate.min.js') }}"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#footer-newsletter').validate({
				errorClass: 'error mb-0',
				highlight: e => {
	                jQuery(e).closest('#footer-newsletter').removeClass('is-invalid').addClass('is-invalid');
	            },
	            success: e => {
	                jQuery(e).closest('#footer-newsletter').removeClass('is-invalid');
	                jQuery(e).remove();
	            },
				rules: {
					footer_email: {
						required: true,
						email: true
					}
				},
				messages: {
					footer_email: {
						required: 'Please enter your email.'
					}
				},
				submitHandler: function(form) {
					var email = $(form).find('#footer_email').val();
					
					$.ajax({
						url: '{{ url("/newsletter") }}',
						type: 'POST',
						data: {email: email, _token: $('meta[name="csrf-token"]').attr('content')},
						success: function(response) {
							var res = $.parseJSON(response);

							if (res['success'] == 1) {
								$('#footer-newsletter')[0].reset();
								$('#footer-res').html('<div class="alert alert-success mt-2">'+res['msg']+'</div>');
							} else {
								$('#footer-res').html('<div class="alert alert-danger mt-2">'+res['msg']+'</div>');
							}
						}
					});

					return false;
				}
			});
		});
	</script>

	@yield('js_after')
</body>

</html>
