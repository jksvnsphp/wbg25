<div class="row">
    <div class="col-md-9 ">
        <div class="position-relative">
            <div class="input-group">
                <input type="text" wire:model.live.debounce.250ms="searchTerm" autocomplete="off"
                    aria-label="Product Name Search" placeholder="Enter Your Product Name to find a matched category"
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
                        @php
                            $searchTerm = preg_quote(strtolower($searchTerm), '/');
                            $highlightedText = preg_replace(
                                '/(' . $searchTerm . ')/i',
                                '<span class="text-secondary">$1</span>',
                                strtolower($suggestion['name']),
                            );
                        @endphp
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
      <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <h6 class="fw-bold mb-3">How to set Product Category</h6>

                <div class="ratio ratio-16x9">
                     
                        <video controls preload="metadata" style="width:100%; border-radius:6px;">
                            <source src="{{ asset('uploads/member_packages/How to set Product Category.mp4') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                </div>

                <small class="text-muted d-block mt-2">
                    Watch this video to understand  how set Pricing
                </small>
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
    <div class="col-12 mt-3">
        <div class="row">
            <div class="col-md-6 mb-3 d-flex align-items-center flex-row flex-sm-nowrap flex-wrap">
                <label for="condition" style="white-space:nowrap;"
                    class="form-label mb-sm-0 mb-1 me-2 fw-bold text-primary">Set Condition</label>
                <select name="item_condition" id="condition" class="form-select">
                    <option @selected($itemCondition=="BrandNew") value="BrandNew">Brand New</option>
                    <option @selected($itemCondition=="NewWithTags") value="NewWithTags">New with tags</option>
                    <option @selected($itemCondition=="NewWithoutTags") value="NewWithoutTags">New without tags</option>
                    <option @selected($itemCondition=="BStock") value="BStock">B-Stock</option>
                    {{-- <option @selected($itemCondition=="PreOwned") value="PreOwned">Pre-Owned</option> --}}
                </select>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="d-flex">
            <h6 class="mb-0 pb-0 d-flex align-items-center"><strong class="text-primary">Item Specifics: </strong> </h6>
            <label for="" class="fw-bold mx-2">Buyer interest in this Details</label>
            <div class="form-check form-switch">
                <input wire:click="BuyerNeedDetail" class="form-check-input" name="buyer_need_detail"
                    type="checkbox" id="optionalToggle"  @if ($buyerNeedDetail) checked @endif>
            </div>
        </div>
        <div id="attribute_container" class="row mt-4"
            @if (!$buyerNeedDetail) style="display: none;" @endif>

            <div class="col-12">
                <div class="row">
                    @foreach ($attributes_data as $attribute)
                        
                        @php
                            
                            $old_attributes = array_filter($old_attributes_data, function ($oldAttr) use ($attribute) {
                                return $oldAttr['attribute_id'] === $attribute['id'];
                            });
                            $old_attribute_value = !empty($old_attributes) ? reset($old_attributes)['attribute_value'] : '';
                            // print_r($old_attributes);
                            // break;
                        @endphp
                        <div class="col-md-3 mb-3">
                            <label for="attribute_{{ $attribute['id'] }}"
                                class="form-label">{{ $attribute['name'] }}</label>

                            @switch($attribute['input_option'])
                                @case('text')
                                    <input type="text" class="form-control" id="attribute_{{ $attribute['id'] }}"
                                        name="attribute[{{ $attribute['id'] }}]"
                                        placeholder="Enter {{ $attribute['name'] }}" value="{{ $old_attribute_value }}">
                                @break

                                @case('textarea')
                                    <textarea class="form-control" id="attribute_{{ $attribute['id'] }}" name="attribute[{{ $attribute['id'] }}]"
                                        rows="3" placeholder="Enter {{ $attribute['name'] }}">{{ $old_attribute_value }}</textarea>
                                @break

                                @case('radio')
                                    @foreach ($attribute['items'] as $item)
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input"
                                                id="attribute_{{ $attribute['id'] }}_{{ $item['id'] }}"
                                                name="attribute[{{ $attribute['id'] }}]" value="{{ $item['id'] }}" @if ($old_attribute_value == $item['id']) checked @endif>
                                            <label class="form-check-label"
                                                for="attribute_{{ $attribute['id'] }}_{{ $item['id'] }}">{{ $item['attribute_option'] }}</label>
                                        </div>
                                    @endforeach
                                @break

                                @case('checkbox')
                                    <div class="d-flex flex-wrap">
                                        @foreach ($attribute['items'] as $item)
                                            <div class="input-check d-flex me-2">
                                                <input type="checkbox" class="form-check-input me-2"
                                                    id="attribute_{{ $attribute['id'] }}_{{ $item['id'] }}"
                                                    name="attribute[{{ $attribute['id'] }}][]" value="{{ $item['id'] }}" 
                                                    @php
                                                      // Decode the old attribute value if it's JSON
                                                      $old_values = is_string($old_attribute_value) ? json_decode($old_attribute_value, true) : (array) $old_attribute_value;
                                                    @endphp
                                                    @if (isset($old_values) && in_array($item['id'], $old_values)) checked @endif>
                                                <label class="form-check-label"
                                                    for="attribute_{{ $attribute['id'] }}_{{ $item['id'] }}">{{ $item['attribute_option'] }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @break

                                @case('number')
                                    <input type="number" class="form-control" id="attribute_{{ $attribute['id'] }}"
                                        name="attribute[{{ $attribute['id'] }}]"
                                        placeholder="Enter {{ $attribute['name'] }}" value="{{ $old_attribute_value }}">
                                @break

                                @case('date')
                                    <input type="date" class="form-control" id="attribute_{{ $attribute['id'] }}"
                                        name="attribute[{{ $attribute['id'] }}]" value="{{ $old_attribute_value }}">
                                @break

                                @case('year')
                                    <input type="number" class="form-control" id="attribute_{{ $attribute['id'] }}"
                                        name="attribute[{{ $attribute['id'] }}]" min="1900" max="{{ date('Y') }}"
                                        placeholder="Enter {{ $attribute['name'] }}" value="{{ $old_attribute_value }}">
                                @break

                                @case('select')
                                    <select class="form-select" id="attribute_{{ $attribute['id'] }}"
                                        name="attribute[{{ $attribute['id'] }}]">
                                        <option value="">Select {{ $attribute['name'] }}</option>
                                        @foreach ($attribute['items'] as $item)
                                            <option value="{{ $item['id'] }}" @if ($old_attribute_value == $item['id']) selected @endif>{{ $item['attribute_option'] }}</option>
                                        @endforeach
                                    </select>
                                @break

                                @case('datetime')
                                    <input type="datetime-local" class="form-control" id="attribute_{{ $attribute['id'] }}"
                                        name="attribute[{{ $attribute['id'] }}]">
                                @break

                                @default
                                    <input type="text" class="form-control" id="attribute_{{ $attribute['id'] }}"
                                        name="attribute[{{ $attribute['id'] }}]"
                                        placeholder="Enter {{ $attribute['name'] }}">
                            @endswitch
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-9" id="other_specific">
                <h6 class="mb-3 pb-0 d-flex align-items-center"><strong class="text-primary">Other Specifics:
                    </strong> </h6>
                @foreach ($specificDetails as $index => $specific)
                    <div class="row align-items-center mb-3" wire:key="specific-{{ $index }}">
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Enter Specific Name"
                                wire:model="specificDetails.{{ $index }}.name" name="spacific_name[]">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Enter Specific Details"
                                wire:model="specificDetails.{{ $index }}.value" name="spacific_detail[]">
                        </div>
                        <div class="col-sm-4 d-flex align-items-center">
                            @if ($index > 0)
                                <span style="cursor: pointer;" class="text-danger me-2"
                                    wire:click="removeSpecificDetail({{ $index }})">
                                    <i class="fas fa-trash-alt"></i>
                                </span>
                            @endif
                            @if ($loop->last && count($specificDetails) < 4)
                                <span style="cursor: pointer;" wire:click="addSpecificDetail">
                                    <i class="fas fa-plus"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
                @if (session()->has('error'))
                    <div class="text-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
