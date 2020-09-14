@extends('layouts.default')

@section('css_before')
<title>404 Page not found | {{ $config->site_title }}</title>
@endsection


@section('content')
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row py-5">
			<div class="col-md-12 text-center">
				<h1>Oops!</h1>
				<h2>404 - Page Not Found</h2>
				<p class="mt-5 mb-2">The page you are looking for might have been removed</p>
				<p>had its name changed or temporarily unavailable</p>
				<a class="primary-button" href="{{ url('/') }}">Go to Homepage</a>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
@endsection