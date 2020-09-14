<script type="text/javascript">
	$(document).on('click', '#btn-load-more', function(e) {
		e.preventDefault();

		var url = $(this).attr('href');

		$.ajax({
			url: url,
			success: function(response) {
				if (response.data) {
					for (var i = 0; i < response.data.length; i++) {
						var blog = '\
							<div class="post post-row">\
								<a class="post-img" href="{{ url("/") }}/'+response.data[i].url_slug+'"><img src="{{ asset("/public/uploads/blog/") }}/'+response.data[i].image+'" alt="'+response.data[i].title+'"></a>\
								<div class="post-body">\
									<div class="post-category">\
									</div>\
									<h3 class="post-title"><a href="{{ url("/") }}/'+response.data[i].url_slug+'">'+response.data[i].title+'</a></h3>\
									<ul class="post-meta">\
										<li><a href="{{ url("/author") }}/'+response.data[i].author.toLowerCase()+'">'+response.data[i].author+'</a></li>\
										<li>'+getDate(response.data[i].created_at)+'</li>\
									</ul>\
									<p>'+response.data[i].meta_desc+'</p>\
								</div>\
							</div>\
						';

						$('#loadmore').append(blog);						
					}

					if (response.next_page_url) {
						$('#btn-load-more').attr('href', response.next_page_url);
					} else {
						$('.loadmore').remove();
					}
				}
			}
		});

		function getDate(date) {
			const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			var date = new Date(date);
			var day = date.getDate();

			return (day<10 ? '0' : '') + day + ' ' + monthNames[date.getMonth()] + ' ' + date.getFullYear();
		}
	});
</script>