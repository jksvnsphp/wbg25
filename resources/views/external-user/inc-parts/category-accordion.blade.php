<div class="accordion" id="accordion{{ $parentId }}">
    @foreach ($categories as $category)
        @if (!empty($category['childCategory']) || !empty($category['endchildcategory']))
            <div class="accordion-item ">
                <h2 class="accordion-header" id="headingCategory{{ $category['id'] }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseCategory{{ $category['id'] }}" aria-expanded="false"
                        aria-controls="collapseCategory{{ $category['id'] }}">
                        {{ $category['name'] }}
                        <i class="fas fa-angle-right icon"></i>
                    </button>
                </h2>
                <div id="collapseCategory{{ $category['id'] }}" class="accordion-collapse collapse"
                    aria-labelledby="headingCategory{{ $category['id'] }}"
                    data-bs-parent="#accordion{{ $parentId }}">
                    <div class="accordion-body">
                        @if (!empty($category['childCategory']))
                            @include('external-user.inc-parts.category-accordion', [
                                'categories' => $category['childCategory'],
                                'parentId' => $category['id'],
                            ])
                        @elseif (!empty($category['endchildcategory']))
                            <ul class="list-unstyled mx-0">
                                @foreach ($category['endchildcategory'] as $childCategory)
                                    <li>
                                        <a href="{{ $childCategory['route'] }}">{{ $childCategory['name'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <ul class="list-unstyled mx-0">
                <li>
                    <a href="{{ $category['route'] }}">{{ $category['name'] }}</a>
                </li>
            </ul>
        @endif

    @endforeach
</div>
