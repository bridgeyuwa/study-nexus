@unless ($breadcrumbs->isEmpty())
    <nav aria-label="breadcrumb d-flex justify-content-end">
        <ol itemscope itemtype="https://schema.org/BreadcrumbList" class="breadcrumb breadcrumb-alt bg-body-light px-4 py-2 rounded push">
            @foreach ($breadcrumbs as $breadcrumb)

                @if ($breadcrumb->url && !$loop->last)
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="breadcrumb-item">
						<a itemprop="item"  href="{{ $breadcrumb->url }}">
						<span itemprop="name">{{ $breadcrumb->title }}</span>
						</a>
						<meta itemprop="position" content="{{$loop->iteration}}" />
					</li>
                @else
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="breadcrumb-item active" aria-current="page">
						<span itemprop="item">
							<span itemprop="name">{{ $breadcrumb->title }}</span>
						</span>
						<meta itemprop="position" content="{{$loop->iteration}}" />
					</li>
                @endif

            @endforeach
        </ol>
    </nav>
@endunless
