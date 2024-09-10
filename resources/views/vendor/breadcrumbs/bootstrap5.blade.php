@unless ($breadcrumbs->isEmpty())
    <nav aria-label="breadcrumb d-flex justify-content-end">
        <ol itemscope itemtype="https://schema.org/BreadcrumbList" class="breadcrumb no-new-line breadcrumb-alt bg-body-light px-4 py-2 rounded push">
            @foreach ($breadcrumbs as $breadcrumb)

                @if ($breadcrumb->url && !$loop->last)
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="breadcrumb-item text-truncate d-inline-block" style="max-width: 150px;" data-bs-toggle="tooltip" title="{{$breadcrumb->title}}">
						<a itemprop="item"  href="{{ $breadcrumb->url }}">
						<span itemprop="name">{{ $breadcrumb->title }}</span>
						</a>
						<meta itemprop="position" content="{{$loop->iteration}}" />
					</li>
                @else
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="breadcrumb-item active text-truncate " aria-current="page" >
						<span itemprop="name">{{ $breadcrumb->title }}</span>
						
						<meta itemprop="position" content="{{$loop->iteration}}" />
					</li>
                @endif

            @endforeach
        </ol>
    </nav>
@endunless


