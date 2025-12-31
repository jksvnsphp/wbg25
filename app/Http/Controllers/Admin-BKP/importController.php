<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\endsubcategory;
use App\Models\parent_category;
use App\Models\QuotationCategory;
use App\Models\quotations_subcategory;
use App\Models\subcategory;
use App\Models\tender_subcategory;
use App\Models\TenderCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class importController extends Controller
{
    //
    public function showImportCategoryCsv()
    {
        return view('admin.import.importCategoryCsv');
    }
    public function importCategoryCsv(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $csvFile = $request->file('csv_file');
            $csvData = array_map('str_getcsv', file($csvFile->getRealPath()));
            if (isset($csvData) && is_array($csvData)) {
                array_shift($csvData);

                foreach ($csvData as $row) {
                    $data = explode(' > ', $row[1]);
                    //  print_r($data);
                    //1: parent category manage
                    if (isset($data[0]) && $data[0] != '') {
                        $pslug = Str::slug($data[0]);
                        $parent_category_id = 0;
                        $parentCategory = parent_category::where('slug', $pslug)->first();
                        if (!$parentCategory) {
                            $parentCategory = new parent_category();
                            $parentCategory->name = $data[0];
                            $parentCategory->slug = $pslug;
                            $parentCategory->save();
                            $parent_category_id = $parentCategory->id;
                        } else {
                            $parent_category_id = $parentCategory->id;
                        }
                        //2:  categories manage
                        if (isset($data[1]) && $data[1] != '') {
                            $cslug = Str::slug($data[1]);
                            $category_id = 0;
                            $category = category::where('slug', $cslug)->first();
                            if (!$category) {
                                $category = new category();
                                $category->name = $data[1];
                                $category->slug = $cslug;
                                $category->parent_category_id = $parent_category_id;
                                $category->save();
                                $category_id = $category->id;
                            } else {
                                $category_id = $category->id;
                            }

                            // 3: store subcategory
                            if (isset($data[2]) && $data[2] != '') {
                                $scslug = Str::slug($data[2]);
                                $subcategory_id = 0;
                                $subcategory = subcategory::where('slug', $scslug)->first();
                                if (!$subcategory) {

                                    $subcategory = new subcategory();
                                    $subcategory->name = $data[2];
                                    $subcategory->slug = $scslug;
                                    $subcategory->category_id = $category_id;
                                    $subcategory->save();
                                    $subcategory_id = $subcategory->id;
                                } else {
                                    $subcategory_id = $subcategory->id;
                                }
                                // 4: store childcategory
                                if (isset($data[3]) && $data[3] != '') {
                                    $ccslug = Str::slug($data[3]);
                                    $endsubcategory_id = 0;
                                    $endsubcategory = endsubcategory::where('slug', $ccslug)->first();
                                    if (!$endsubcategory) {
                                        $endsubcategory = new endsubcategory();
                                        $endsubcategory->name = $data[3];
                                        $endsubcategory->slug = $ccslug;
                                        $endsubcategory->subcategories_id = $subcategory_id;
                                        $endsubcategory->save();
                                        $endsubcategory_id = $endsubcategory->id;
                                    } else {
                                        $endsubcategory_id = $endsubcategory->id;
                                    }
                                }
                            }
                        }
                    }
                }
                return response(['status' => true, 'message' => 'Successfully imported.']);
            } else {
                return response(['status' => false, 'message' => 'Could not imported']);
            }
        }
    }
    public function showImportQuotationCategoryCsv()
    {
        return view('admin.import.importQuotationsCsv');
    }
    public function importQuotationCategoryCsv(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $csvFile = $request->file('csv_file');
            $csvData = array_map('str_getcsv', file($csvFile->getRealPath()));
            if (isset($csvData) && is_array($csvData)) {
                array_shift($csvData);

                foreach ($csvData as $row) {
                    $data = explode(' > ', $row[1]);
                    //  print_r($data);
                    //1: parent category manage
                    if (isset($data[0]) && $data[0] != '') {
                        $pslug = Str::slug($data[0]);
                        $parent_category_id = 0;
                        $parentCategory = QuotationCategory::where('slug', $pslug)->first();
                        if (!$parentCategory) {
                            $parentCategory = new QuotationCategory();
                            $parentCategory->name = $data[0];
                            $parentCategory->slug = $pslug;
                            $parentCategory->save();
                            $parent_category_id = $parentCategory->id;
                        } else {
                            $parent_category_id = $parentCategory->id;
                        }
                        //2:  categories manage
                        if (isset($data[1]) && $data[1] != '') {
                            $cslug = Str::slug($data[1]);
                            $category = quotations_subcategory::where('slug', $cslug)->first();
                            if (!$category) {
                                $category = new quotations_subcategory();
                                $category->name = $data[1];
                                $category->slug = $cslug;
                                $category->category_id = $parent_category_id;
                                $category->save();
                            }
                        }
                    }
                }
                return response(['status' => true, 'message' => 'Successfully imported.']);
            } else {
                return response(['status' => false, 'message' => 'Could not imported']);
            }
        }
    }
    public function showImportTenderCategoryCsv()
    {
        return view('admin.import.importTenderCsv');
    }
    public function importTenderCategoryCsv(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $csvFile = $request->file('csv_file');
            $csvData = array_map('str_getcsv', file($csvFile->getRealPath()));
            if (isset($csvData) && is_array($csvData)) {
                array_shift($csvData);

                foreach ($csvData as $row) {
                    $data = explode(' > ', $row[1]);
                    //  print_r($data);
                    //1: parent category manage
                    if (isset($data[0]) && $data[0] != '') {
                        $pslug = Str::slug($data[0]);
                        $parent_category_id = 0;
                        $parentCategory = TenderCategory::where('slug', $pslug)->first();
                        if (!$parentCategory) {
                            $parentCategory = new TenderCategory();
                            $parentCategory->name = $data[0];
                            $parentCategory->slug = $pslug;
                            $parentCategory->save();
                            $parent_category_id = $parentCategory->id;
                        } else {
                            $parent_category_id = $parentCategory->id;
                        }
                        //2:  categories manage
                        if (isset($data[1]) && $data[1] != '') {
                            $cslug = Str::slug($data[1]);
                            $category = tender_subcategory::where('slug', $cslug)->first();
                            if (!$category) {
                                $category = new tender_subcategory();
                                $category->name = $data[1];
                                $category->slug = $cslug;
                                $category->category_id = $parent_category_id;
                                $category->save();
                            }
                        }
                    }
                }
                return response(['status' => true, 'message' => 'Successfully imported.']);
            } else {
                return response(['status' => false, 'message' => 'Could not imported']);
            }
        }
    }

    public function importCustomer(){
        return view('admin.import.import-customer');
    }
}
