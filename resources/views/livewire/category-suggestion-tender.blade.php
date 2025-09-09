<div class="row">
    <div class="col-md-9 ">
        <div class="position-relative">
            <div class="input-group">
                <input type="text" wire:model.live.debounce.250ms="searchTerm" autocomplete="off"
                    aria-label="Product Name Search" placeholder="Tell us what you want to sell with this offer"
                    class="form-control shadow" value="{{ $searchTerm }}">
                <button wire:click="usedThis" class="btn btn-secondary input-group-btn shadow"
                    type="button">Use</button>
            </div>
            <!-- Custom Inline Loading Message -->
            <div wire:loading.delay class="bg-white mt-2" style="z-index: 10; width: 100%;; overflow-y: auto;">
                <p class="text-primary fw-bold">please wait...</p>
            </div>
            <input type="hidden" name="parent_category_id" wire:model="parentCategoryId"
                value="{{ $parentCategoryId }}">
            <input type="hidden" name="category_id" wire:model="categoryId" value="{{ $categoryId }}">
            <input type="hidden" name="child_category_id" wire:model="childCategoryId" value="{{ $childCategoryId }}">
            <input type="hidden" name="endchild_category_id" wire:model="endChildCategoryId"
                value="{{ $endChildCategoryId }}">
            @if ($searchTerm && $suggestions && count($suggestions) > 0)
                <ul class="list-group bg-white position-absolute shadow rounded-md p-2"
                    style="z-index: 10; width: 100%; max-height: 20rem; overflow-y: auto;">
                    <h5 class="fs-5 my-2 mb-1 px-3 text-primary fw-bold">Can you be more specific?</h5>
                    <p class="text-muted px-3">Extra details will optimize your listing</p>
                    @foreach ($suggestions as $suggestion)
                       
                        <li class="list-group-item text-primary fw-semibold border-0 text-capitalize"
                            style="cursor: pointer;"
                            wire:click='selectCategory({{ $suggestion['id'] }}, {{ $suggestion['level'] }}, "{{ $suggestion['path'] }}","{{ $suggestion['name'] }}")'>
                            + {!! $this->highlightText($suggestion['path'], $searchTerm) !!}
                        </li>
                    @endforeach
                </ul>
            @elseif ($isEmpty && count($suggestions) === 0)
                <div class="list-group bg-white position-absolute shadow rounded p-3 "
                    style="z-index: 10; width: 100%; max-height: 6rem; overflow-y: auto;">
                    <h5 class="fs-5 my-2 mb-1 px-3 text-primary fw-bold">We Cant't find any suggestion.</h5>
                    <p class="text-muted px-3">Enter another product name or set the category manual.</p>
                </div>

            @endif

            <div class="mt-4">
                <strong class="fw-bold text-primary">Used Category: </strong> {{ $hasPath }}
            </div>
        </div>


    </div>
    @if ($isEmpty && count($suggestions) === 0)
        <strong class="fw-bold text-primary mt-5 pt-4">Select Category Manual</strong>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-4 mt-2">
                    <select wire:model.live="selectedParentCategory" class="form-control form-select"
                        id="parent_category">
                        <option value="">Select Category</option>
                        @foreach ($sparentCategories as $sparent)
                            <option value="{{ $sparent->id }}">{{ $sparent->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if (isset($scategories) && count($scategories) > 0)
                    <div class="col-md-4 mt-2">
                        <select wire:model.live="selectedCategory" class="form-control  form-select" id="category">
                            <option value="">Select Sub Category</option>
                            @foreach ($scategories as $scategory)
                                <option value="{{ $scategory->id }}">{{ $scategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if (isset($ssubcategories) && count($ssubcategories) > 0)
                    <div class="col-md-4 mt-2">
                        <select wire:model.live="selectedSubcategory" class="form-control form-select"
                            id="childcategory">
                            <option value="">Select child category</option>
                            @foreach ($ssubcategories as $ssubcategory)
                                <option value="{{ $ssubcategory->id }}">{{ $ssubcategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if (isset($sendSubcategories) && count($sendSubcategories) > 0)
                    <div class="col-md-4 mt-2">
                        <select wire:model.live="selectedEndSubcategory" class="form-control  form-select"
                            id="endcategory">
                            <option value="">Select End Category</option>
                            @foreach ($sendSubcategories as $sendSubcategory)
                                <option value="{{ $sendSubcategory->id }}">{{ $sendSubcategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="col-md-2 mt-2">
                    <button type="button" wire:click="saveCategory" class="btn btn-secondary">Use</button>
                </div>
                <div class="col-12 mt-2">
                    <strong class="text-primary">Manual Selected Path:</strong> {{ $manualPath }}
                </div>
            </div>
        </div>
    @endif
  
</div>
