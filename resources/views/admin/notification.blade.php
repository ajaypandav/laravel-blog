<button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-flag"></i>
    <span class="badge badge-primary badge-pill">{{ count($notification) }}</span>
</button>
<div class="dropdown-menu dropdown-menu-right min-width-300" aria-labelledby="page-header-notifications">
    <h5 class="h6 text-center py-10 mb-0 border-b text-uppercase">Notifications</h5>
    @if(!empty($notification))
    <ul class="list-unstyled my-20">
        @foreach($notification as $key => $value)

        @if($key == 'contacts')
        <li>
            <a class="text-body-color-dark media mb-15" href="{{ url('/admin/contact') }}">
                <div class="ml-5 mr-15">
                    <i class="fa fa-fw fa-phone text-success"></i>
                </div>
                <div class="media-body pr-10">
                    <p class="mb-0">Contact inquiry</p>
                    <div class="text-muted font-size-sm font-italic">{{ Carbon\Carbon::parse($value['created_at'])->diffForHumans() }}</div>
                </div>
                <div class="ml-5 mr-10">
                    <span class="badge badge-danger badge-pill">{{ $value['count'] }}</span>
                </div>
            </a>
        </li>
        @elseif($key == 'subscribers')
        <li>
            <a class="text-body-color-dark media mb-15" href="{{ url('/admin/subscriber') }}">
                <div class="ml-5 mr-15">
                    <i class="fa fa-fw fa-envelope text-warning"></i>
                </div>
                <div class="media-body pr-10">
                    <p class="mb-0">New subscriber</p>
                    <div class="text-muted font-size-sm font-italic">{{ Carbon\Carbon::parse($value['created_at'])->diffForHumans() }}</div>
                </div>
                <div class="ml-5 mr-10">
                    <span class="badge badge-secondary badge-pill">{{ $value['count'] }}</span>
                </div>
            </a>
        </li>
        @elseif($key == 'comments')
        <li>
            <a class="text-body-color-dark media mb-15" href="{{ url('/admin/blog') }}">
                <div class="ml-5 mr-15">
                    <i class="fa fa-fw fa-comments text-primary"></i>
                </div>
                <div class="media-body pr-10">
                    <p class="mb-0"> New blog comments</p>
                    <div class="text-muted font-size-sm font-italic">{{ Carbon\Carbon::parse($value['created_at'])->diffForHumans() }}</div>
                </div>
                <div class="ml-5 mr-10">
                    <span class="badge badge-success badge-pill">{{ $value['count'] }}</span>
                </div>
            </a>
        </li>
        @endif

        @endforeach
    </ul>
    @else
    <p class="text-center my-2">No notification found.</p>
    @endif
</div>