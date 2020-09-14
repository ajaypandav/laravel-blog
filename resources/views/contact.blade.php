@extends('layouts.default')

@section('css_before')
<title>Contact Us | {{ $config->site_title }}</title>
@endsection

@section('page_header')
<div class="page-header">
	<div class="page-header-bg"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-offset-1 col-md-10 text-center">
				<h1 class="text-uppercase">Contact Us</h1>
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
			<div class="col-md-7">
				<div class="section-row">
					<div class="section-title">
						<h2 class="title">Contact Information</h2>
					</div>
					<p>Have a question? Need a tip? You can find a host of brilliant articles in our knowledge base. If you can't find what you looking for, we'd be happy to point you in the right direction. Please feel free to send us an email or even give us a call.</p>
					<ul class="contact">
						<li><i class="fa fa-phone"></i>+91 99999 99999</li>
						<li><i class="fa fa-envelope"></i> <a href="#">laravelblog@gmail.com</a></li>
						<li><i class="fa fa-map-marker"></i> Surat, Gujarat, India.</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4 col-md-offset-1">
				<div class="section-row">
					<div class="section-title">
						<h2 class="title">Mail us</h2>
					</div>

					@if(Session::has('success'))
			            <div class="alert alert-success">
			                {{ Session::get('success') }}
			            </div>
			        @endif

					<form id="contact-form" method="post" action="{{ route('contact') }}">
						@csrf
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<input class="input" type="text" name="name" placeholder="Name" required="">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<input class="input" type="email" name="email" placeholder="Email" required="">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<input class="input" type="text" name="subject" placeholder="Subject" required="">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<textarea class="input" name="message" placeholder="Message" required=""></textarea>
								</div>
								<button class="primary-button" type="submit">Submit</button>
							</div>
						</div>
					</form>
				</div>
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
		$('#contact-form').validate({
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
</script>
@endsection