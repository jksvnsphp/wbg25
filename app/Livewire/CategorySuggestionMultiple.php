<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\category;
use App\Models\category_attribute;
use App\Models\endsubcategory;
use App\Models\parent_category;
use App\Models\subcategory;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;

class CategorySuggestionMultiple extends Component
{
    use WithFileUploads;

    // For the image upload and preview
    public $image;
    public $imagePreview = null;

    public $specificDetails = [['name' => '', 'value' => '']];
    public $itemCondition = '';
    public $sparentCategories = [];
    public $scategories = [];
    public $ssubcategories = [];
    public $sendSubcategories = [];

    public $selectedParentCategory = null;
    public $selectedCategory = null;
    public $selectedSubcategory = null;
    public $selectedEndSubcategory = null;


    public $buyerNeedDetail = false;
    public $searchTerm = '';
    public $suggestions = [];
    public $attributes_data = [];
    public $old_attributes_data = [];
    public $isEmpty = false;
    public $selectedPath = '';
    public $levelCat = '';
    public $selectedCatId = '';
    public $hasPath = 'No Selected Category Path Found!';
    public $manualPath = 'No Selected Category Path Found!';

    public $parentCategoryId, $categoryId, $childCategoryId, $endChildCategoryId;

    public $variants = []; // Stores variants with their values
    public $newVariantName = ''; // For adding a new variant
    public $newValue = ''; // For adding a new value to a variant
    public $combinations = []; // Stores generated combinations
    public $editingVariantIndex = null; // For editing variant name
    public $editingValueIndex = null; // For editing variant value
    public $editingValueVariantIndex = null; // For editing value of specific variant

    public function mount()
    {

        if ($this->categoryId != "") {
            $this->attributes_data = $this->getAttributes();
        }
        $this->sparentCategories = parent_category::where('status', 1)->orderBy('name', 'ASC')->get();
    }


    // for other specific
    public function addSpecificDetail()
    {
        if (count($this->specificDetails) < 4) {
            $this->specificDetails[] = ['name' => '', 'value' => ''];
        } else {
            session()->flash('error', 'You cannot add more than 4 specifics.');
        }
    }

    public function removeSpecificDetail($index)
    {
        unset($this->specificDetails[$index]);
        $this->specificDetails = array_values($this->specificDetails); // Reindex the array
    }

    public function updatedSelectedParentCategory($sparentCategoryId)
    {
        $this->attributes_data = [];
        $this->manualPath = 'No Selected Category Path Found!';
        $this->scategories = category::where('parent_category_id', $sparentCategoryId)->where('status', 1)->orderBy('name', 'ASC')->get();
        $this->selectedCategory = null;
        $this->selectedParentCategory = $sparentCategoryId;
        $this->ssubcategories = [];
        $this->sendSubcategories = [];
    }

    public function updatedSelectedCategory($scategoryId)
    {
        $this->attributes_data = [];
        $this->manualPath = 'No Selected Category Path Found!';
        $this->ssubcategories = subcategory::where('category_id', $scategoryId)->where('status', 1)->orderBy('name', 'ASC')->get();
        $this->selectedSubcategory = null;
        $this->selectedCategory = $scategoryId;
        $this->sendSubcategories = [];
    }

    public function updatedSelectedSubcategory($ssubcategoryId)
    {
        $this->manualPath = 'No Selected Category Path Found!';
        $this->sendSubcategories = endsubcategory::where('subcategories_id', $ssubcategoryId)->where('status', 1)->orderBy('name', 'ASC')->get();
        $this->selectedEndSubcategory = null;
        $this->selectedSubcategory = $ssubcategoryId;
    }
    public function updatedselectedEndSubcategory($sendsubcategoryId)
    {
        $this->manualPath = 'No Selected Category Path Found!';
        $this->selectedEndSubcategory = $sendsubcategoryId;
    }

    public function getAttributes()
    {

        // dd($this->categoryId);
        $categoryAttributes = category_attribute::with(['attribute.items'])
            ->where('category_id', $this->categoryId)
            ->where('status', 1)
            ->get();
        $attributes = $categoryAttributes->map(function ($categoryAttribute) {
            return [
                'id' => $categoryAttribute->id,
                'name' => $categoryAttribute->attribute->name,
                'input_option' => $categoryAttribute->attribute->input_option,
                'items' => $categoryAttribute->attribute->items,
                'isRequired' => $categoryAttribute->isRequired
            ];
        });

        return $attributes;
    }
    public function highlightText($text, $searchTerm)
    {

        if (empty($searchTerm)) {
            return $text;
        }
        $escapedSearchTerm = preg_quote($searchTerm, '/');
        $pattern = '/(' . str_replace(' ', '[\s-]*', $escapedSearchTerm) . ')/i';
        return preg_replace($pattern, '<span class="text-secondary">$1</span>', $text);
    }
    public function unsetManual()
    {
        $this->scategories = [];
        $this->ssubcategories = [];
        $this->sendSubcategories = [];
        $this->selectedParentCategory = null;
        $this->selectedCategory = null;
        $this->selectedSubcategory = null;
        $this->selectedEndSubcategory = null;
        $this->manualPath = 'No Selected Category Path Found!';
    }
    public function fetchResult()
    {
        $this->attributes_data = [];
        $this->suggestions = [];
        $this->selectedPath = '';
        $this->hasPath = 'No Selected Category Path Found!';
        $this->levelCat = '';
        $this->selectedCatId = '';
        $this->parentCategoryId = null;
        $this->categoryId = null;
        $this->childCategoryId = null;
        $this->endChildCategoryId = null;
        $searchTerm = strtolower($this->searchTerm);
        $searchTerm = str_replace(' ', '%', $searchTerm);

        $parentCategories = parent_category::whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"])->limit(10)->get();
        foreach ($parentCategories as $parent) {
            $this->suggestions[] = [
                'id' => $parent->id,
                'level' => 1,
                'name' => $parent->name,
                'path' => $parent->name,
            ];
        }
        $categories = category::with('parentcategory')->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"])->limit(10)->get();
        foreach ($categories as $category) {
            $parentCategoryName = isset($category->parentcategory) ? $category->parentcategory->name : 'No Parent Name';
            $this->suggestions[] = [
                'id' => $category->id,
                'level' => 2,
                'name' => $category->name,
                'path' => "{$parentCategoryName} > {$category->name}",
            ];
        }


        $childCategories = subcategory::with('category.parentcategory')->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"])->limit(10)->get();
        foreach ($childCategories as $child) {
            $parentCategoryName = isset($child->category->parentcategory) ? $child->category->parentcategory->name : 'No Parent Name';
            $categoryName = isset($child->category) ? $child->category->name : 'No Category Name';
            $this->suggestions[] = [
                'id' => $child->id,
                'level' => 3,
                'name' => $child->name,
                'path' => "{$parentCategoryName} > {$categoryName} > {$child->name}",
            ];
        }


        $endChildCategories = endsubcategory::with('childCategory.category.parentcategory')->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"])->limit(10)->get();
        foreach ($endChildCategories as $endChild) {
            $parentCategoryName = isset($endChild->childCategory->category->parentcategory) ? $endChild->childCategory->category->parentcategory->name : 'No Parent Name';
            $categoryName = isset($endChild->childCategory->category) ? $endChild->childCategory->category->name : 'No Category Name';
            $subcategoryName = isset($endChild->childCategory) ? $endChild->childCategory->name : 'No Subcategory Name';
            $this->suggestions[] = [
                'id' => $endChild->id,
                'level' => 4,
                'name' => $endChild->name,
                'path' => "{$parentCategoryName} > {$categoryName} > {$subcategoryName} > {$endChild->name}",
            ];
        }

        if (count($this->suggestions) > 0) {
            $this->isEmpty = false;
        } else {
            $this->isEmpty = true;
            $this->unsetManual();
        }
    }

    public function usedThis()
    {
        if (strlen($this->selectedPath) > 0) {
            $this->hasPath = $this->selectedPath;
        } else {
            $this->hasPath = 'No Selected Category Path Found!';
        }
        if ($this->levelCat != "" && $this->selectedCatId != "") {
            if ($this->levelCat == 1) {
                $this->parentCategoryId = $this->selectedCatId;
            } elseif ($this->levelCat == 2) {
                $this->categoryId = $this->selectedCatId;
                $this->attributes_data = $this->getAttributes();
                $category = category::where('id', $this->selectedCatId)->first();
                $this->parentCategoryId = $category->parent_category_id;
            } elseif ($this->levelCat == 3) {
                $this->childCategoryId = $this->selectedCatId;

                $childcategory = subcategory::where('id', $this->selectedCatId)->first();
                $this->categoryId = $childcategory->category_id;
                $this->attributes_data = $this->getAttributes();
                $category = category::where('id', $childcategory->category_id)->first();
                $this->parentCategoryId = $category->parent_category_id;
            } elseif ($this->levelCat == 4) {
                $this->endChildCategoryId = $this->selectedCatId;
                $endchildcategory = endsubcategory::where('id', $this->selectedCatId)->first();
                $this->childCategoryId = $endchildcategory->subcategories_id;

                $childcategory = subcategory::where('id', $endchildcategory->subcategories_id)->first();
                $this->categoryId = $childcategory->category_id;
                $this->attributes_data = $this->getAttributes();
                $category = category::where('id', $childcategory->category_id)->first();
                $this->parentCategoryId = $category->parent_category_id;
            }
        }
    }

    public function getCategoryPath()
    {
        $path = [];
        if ($this->selectedParentCategory) {
            $parentCategory = parent_category::find($this->selectedParentCategory);
            $path[] = $parentCategory ? $parentCategory->name : '';
        }

        if ($this->selectedCategory) {
            $category = category::find($this->selectedCategory);
            $path[] = $category ? $category->name : '';
        }

        if ($this->selectedSubcategory) {
            $subcategory = subcategory::find($this->selectedSubcategory);
            $path[] = $subcategory ? $subcategory->name : '';
        }

        if ($this->selectedEndSubcategory) {
            $endSubcategory = endsubcategory::find($this->selectedEndSubcategory);
            $path[] = $endSubcategory ? $endSubcategory->name : '';
        }
        return implode(' > ', array_filter($path));
    }

    public function saveCategory()
    {

        if ($this->selectedCategory != null && $this->selectedCategory != '') {
            $this->parentCategoryId = $this->selectedParentCategory;
            $this->categoryId = $this->selectedCategory;
            $this->childCategoryId = $this->selectedSubcategory;
            $this->endChildCategoryId = $this->selectedEndSubcategory;
            $this->attributes_data = $this->getAttributes();

            // Retrieve and store the selected path
            $this->manualPath = $this->getCategoryPath();
        }
    }
    public function updatedSearchTerm()
    {

        if (strlen($this->searchTerm) > 0) {
            $this->isEmpty = false;
            $this->fetchResult();
        } else {
            $this->isEmpty = false;
            $this->suggestions = [];
            $this->attributes_data = [];
        }
    }

    public function selectCategory($id, $level, $path, $searchName)
    {
        // dd($level);
        $this->selectedPath = $path;
        $this->searchTerm = $searchName;
        $this->selectedCatId = $id;
        $this->levelCat = $level;
        $this->suggestions = [];
        $this->isEmpty = false;
        $this->attributes_data = [];
        if ($level == 1) {
            $this->parentCategoryId = $id;
        } elseif ($level == 2) {
            $this->categoryId = $id;
            $this->attributes_data = $this->getAttributes();
            $category = category::where('id', $id)->first();
            $this->parentCategoryId = $category->parent_category_id;
        } elseif ($level == 3) {
            $this->childCategoryId = $id;

            $childcategory = subcategory::where('id', $id)->first();
            $this->categoryId = $childcategory->category_id;
            $this->attributes_data = $this->getAttributes();
            $category = category::where('id', $childcategory->category_id)->first();
            $this->parentCategoryId = $category->parent_category_id;
        } elseif ($level == 4) {
            $this->endChildCategoryId = $id;
            $endchildcategory = endsubcategory::where('id', $id)->first();
            $this->childCategoryId = $endchildcategory->subcategories_id;

            $childcategory = subcategory::where('id', $endchildcategory->subcategories_id)->first();
            $this->categoryId = $childcategory->category_id;
            $this->attributes_data = $this->getAttributes();
            $category = category::where('id', $childcategory->category_id)->first();
            $this->parentCategoryId = $category->parent_category_id;
        }
    }

    // Add a new variant
    public function addVariant()
    {
        if (!empty($this->newVariantName)) {
            $this->variants[] = [
                'name' => $this->newVariantName,
                'values' => [],
                'newValue' => '' // Add a separate newValue field for each variant
            ];
            $this->newVariantName = '';
        }
    }



    // Edit a variant name
    public function editVariant($index)
    {
        $this->editingVariantIndex = $index;
    }

    public function saveVariant($index)
    {
        $this->editingVariantIndex = null;
    }

    // Delete a variant
    public function deleteVariant($index)
    {
        unset($this->variants[$index]);
        $this->variants = array_values($this->variants); // Reindex array
    }

    // Add a value to a specific variant
    public function addVariantValue($variantIndex)
    {
        if (!empty($this->variants[$variantIndex]['newValue'])) {
            $this->variants[$variantIndex]['values'][] = $this->variants[$variantIndex]['newValue'];
            $this->variants[$variantIndex]['newValue'] = ''; // Clear the new value input
        }
    }

    // Edit a value within a variant
    public function editValue($variantIndex, $valueIndex)
    {
        $this->editingValueVariantIndex = $variantIndex;
        $this->editingValueIndex = $valueIndex;
    }

    public function saveValue($variantIndex, $valueIndex)
    {
        $this->editingValueIndex = null;
        $this->editingValueVariantIndex = null;
    }

    // Delete a value within a variant
    public function deleteVariantValue($variantIndex, $valueIndex)
    {
        unset($this->variants[$variantIndex]['values'][$valueIndex]);
        $this->variants[$variantIndex]['values'] = array_values($this->variants[$variantIndex]['values']); // Reindex array
    }

    // Generate combinations
    public function generateCombinations()
    {
        $allValues = array_map(function ($variant) {
            return $variant['values'];
        }, $this->variants);

        if (empty($allValues)) {
            $this->combinations = [];
            return;
        }

        // dd($allValues);
        $combinations = $this->cartesianProduct($allValues);
        $this->combinations = array_map(function ($combination) {
            return [
                'attributes' => array_combine(array_column($this->variants, 'name'), $combination),
                "images" => [],
                "imagePreviews" => [],
                'quantity' => 1,
                'price' => 0.00,
            ];
        }, $combinations);
        //  dd($this->combinations);
    }

    private function cartesianProduct($arrays)
    {
        $result = [[]];
        foreach ($arrays as $propertyValues) {
            $temp = [];
            foreach ($result as $resultItem) {
                foreach ($propertyValues as $propertyValue) {
                    $temp[] = array_merge($resultItem, [$propertyValue]);
                }
            }
            $result = $temp;
        }
        return $result;
    }
    public function updatedCombinations($field, $index)
    {
        $index = explode('.', $index)[0];
        if (isset($this->combinations[$index])) {
            $newFiles = $this->combinations[$index]['newFiles'] ?? [];
            $existingFiles = $this->combinations[$index]['images'] ?? [];
            $this->combinations[$index]['images'] = collect($existingFiles)
                ->merge($newFiles)
                ->uniqueStrict()
                ->toArray();
            $this->combinations[$index]['imagePreviews'] = array_map(function ($file) {
                return $file->temporaryUrl();
            }, $this->combinations[$index]['images']);
            $this->combinations[$index]['newFiles'] = null;
        }
    }
    public function removeImage($combinationIndex, $imageIndex)
    {
        unset($this->combinations[$combinationIndex]['images'][$imageIndex]);
        unset($this->combinations[$combinationIndex]['imagePreviews'][$imageIndex]);

        // Reindex arrays
        $this->combinations[$combinationIndex]['images'] = array_values($this->combinations[$combinationIndex]['images']);
        $this->combinations[$combinationIndex]['imagePreviews'] = array_values($this->combinations[$combinationIndex]['imagePreviews']);
    }
    // Delete a combination
    public function deleteCombination($index)
    {
        unset($this->combinations[$index]);
        $this->combinations = array_values($this->combinations); // Reindex array
    }
    public function render()
    {
        return view('livewire.category-suggestion-multiple', [
            'sparentCategories' => $this->sparentCategories,
            'scategories' => $this->scategories,
            'ssubcategories' => $this->ssubcategories,
            'sendSubcategories' => $this->sendSubcategories,
            'variants' => $this->variants,
            'combinations' => $this->combinations,
        ]);
    }

    public function BuyerNeedDetail()
    {
        $this->buyerNeedDetail = $this->buyerNeedDetail ? false : true;
    }
}
