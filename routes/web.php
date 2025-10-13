<?php

use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\AttributesController;
use App\Http\Controllers\admin\BulkMailController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\GeneralSettingController;
use App\Http\Controllers\admin\HomePageController;
use App\Http\Controllers\admin\importController;
use App\Http\Controllers\admin\LocationController as AdminLocationController;
use App\Http\Controllers\admin\NewsBlogController;
use App\Http\Controllers\admin\ProductCategoryController;
use App\Http\Controllers\admin\QuotationController;
use App\Http\Controllers\admin\QuotationsSubcategoryController;
use App\Http\Controllers\admin\SupplierController;
use App\Http\Controllers\admin\SuppliersSubcategoryController;
use App\Http\Controllers\admin\TendersController;
use App\Http\Controllers\admin\StoresController;
use App\Http\Controllers\admin\ProductVideoShowController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\admin\AdminInboxController;

use App\Http\Controllers\admin\TenderSubcategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankDetailsController;
use App\Http\Controllers\BusinessProfileSymbolController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CompanyCertificateController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomeCategoryController;
use App\Http\Controllers\FrontUIController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MemberPackageController;
use App\Http\Controllers\OfferTenderController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\seller\SellerNewsController;
use App\Http\Controllers\seller\SellerProductController;
use App\Http\Controllers\seller\SellerTenderController;
use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\sellerGalleryController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\SourceProController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\SupplierController as CSupplierController;
use App\Http\Controllers\UICartController;
use App\Http\Controllers\UICheckoutController;
use App\Http\Controllers\UINewsController;
use App\Http\Controllers\UIProductVideoShowController;
use App\Http\Controllers\UISellerController;
use App\Http\Controllers\UISupplierRegionController;
use App\Http\Controllers\UITendersController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\UserQuotationController;
use App\Http\Controllers\SmsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\TenderController;

use App\Http\Controllers\admin\BuyerInquiryController;
use App\Http\Controllers\admin\SellerInquiryController;
use App\Http\Controllers\admin\UserInquiryController;

//SellerInquiryController
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/update-autoload', function () {
        // Execute the Composer command
        exec('composer dump-autoload'); 
         Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

        return "Composer autoload dumped successfully!";
    });


Route::get('/send-sms', [SmsController::class, 'sendTest']);

Route::controller(CSupplierController::class)->group(function () {
 Route::get('/suppliers', 'allsuppliers')->name('all.suppliers');
    
});


Route::controller(UITendersController::class)->group(function () {
  Route::get('/tenders', 'index')->name('all.tenders');
    Route::get('/tender/{slug}', 'tenderDetails')->name('show.tender');
    
});

 
Route::controller(CSupplierController::class)->prefix('main')->group(function () {
  
   Route::post('/get-supplier-subcategory', 'getSubCategory')->name('all.supplier-subcategory');
   Route::post('/get-states', 'getStates')->name('all.country.states');
});
Route::controller(SearchController::class)->prefix('main')->group(function () {
   Route::get('/search', 'search')->name('search');
});
Route::controller(UISupplierRegionController::class)->group(function () {
   Route::get('/supplier-by-region', 'allsupplier_region')->name('all.supplier.region');
});
Route::controller(UIProductVideoShowController::class)->group(function () {
   Route::get('/product-videos', 'index')->name('all.product-video.show');
});
Route::controller(UINewsController::class)->group(function () {

   Route::get('/news/{slug?}', 'readNews')->name('read.news');
});

Route::controller(UINewsController::class)->group(function () {
    Route::get('/news', 'index')->name('all.news.show'); 
});
Route::controller(UserProductController::class)->group(function () {
   Route::post('/get-subcategories', 'getSubCategories')->name('public.get.subcategory');
   Route::post('/get-sub-subcategories', 'getSubSubCategories')->name('public.get.subsubcategory');
   Route::post('/get-child-categories', 'getChildCategories')->name('public.get.childcategory');
   Route::get('/products', 'allproducts')->name('all.products');
   Route::get('/{type}/products', 'allTypeProducts')->name('all.type.products');
   Route::get('/store/{code}/{category_slug?}', 'sellerSpotlight')->name('seller.spotlight');
   Route::get('/product/{slug?}', 'productDetails')->name('product.detail');
   Route::get('/product/category/{slug?}', 'allproducts')->name('categories.show');
   Route::post('/get-products-subcategory', 'getSubCategory')->name('all.products-subcategory');
});


Route::controller(FrontUIController::class)->group(function () {
   Route::get('/', 'home')->name('home');
   Route::get('/home', 'home')->name('home.show');
   Route::get('/my-sell-provision', 'mywallet')->name('mywallet.show');
   Route::get('/stores', 'allSpotlight')->name('all.spotlight');
   Route::get('/how-to-sell', 'howToSell')->name('howToSell');
   Route::get('/how-to-buy', 'howToBuy')->name('howToBuy');
   Route::get('/privacy-and-policy', 'privacyAndPolicy')->name('privacyAndPolicy');
   Route::get('/data-protection', 'dataProtection')->name('dataProtection');
   Route::get('/terms-and-conditions', 'termsAndCondition')->name('termsAndCondition');
   Route::get('/imprint', 'imprint')->name('imprint');
});

Route::controller(ArticleController::class)->prefix('main')->group(function () {
   Route::get('/help/business-profile', 'businessHelpArticles')->name('businessHelpArticles');
   Route::get('/help/spotlight-store', 'spotlightStoreHelpArticles')->name('spotlightStoreHelpArticles');
   Route::get('/help/product', 'productHelpArticles')->name('productHelpArticles');
   Route::get('/help/tender', 'tenderHelpArticles')->name('tenderHelpArticles');
   Route::get('/help/quotations', 'quotationHelpArticles')->name('quotationHelpArticles');

   Route::get('/help/buyer/product', 'productBuyerHelpArticles')->name('productBuyerHelpArticles');
   Route::get('/help/buyer/tender', 'tenderBuyerHelpArticles')->name('tenderBuyerHelpArticles');
   Route::get('/help/buyer/quotations', 'quotationBuyerHelpArticles')->name('quotationBuyerHelpArticles');

   Route::get('/help/sale-commission', 'saleCommissionHelpArticles')->name('saleCommissionHelpArticles');
});
Route::controller(UICartController::class)->prefix('main')->group(function () {
   Route::post('/add-cart', 'addToCart')->name('cart.add');
   Route::post('/ready-for-buy', 'checkoutNow')->name('checkoutNow');
});
Route::middleware('auth')->group(function () {
   Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
   Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
   Route::controller(UICartController::class)->prefix('main')->group(function () {
      Route::get('/cart', 'index')->name('cart.product');
      Route::get('/cart/tender', 'cartTender')->name('cart.tender');
      Route::get('/cart/quotation', 'cartQuotation')->name('cart.quotation');
      Route::get('/cart/{cartId}', 'deleteCartItem')->name('cart.product.remove');
   });
   Route::controller(UICheckoutController::class)->prefix('main')->group(function () {
      Route::get('/{ref_no}/checkout', 'index')->name('checkout.product');
      Route::get('/{ref_no}/checkout/tender', 'checkoutTender')->name('checkout.tender');
      Route::get('/{ref_no}/checkout/quotation', 'checkoutQuotation')->name('checkout.quotation');
      // Route::post('/order-now', 'orderNow')->name('order.now.product');
      Route::post('/order-now', 'orderNow2')->name('order.now.product');
      Route::post('/tender/order-now', 'orderNowTender')->name('order.now.tender');
      Route::post('/quotation/order-now', 'orderNowQuotation')->name('order.now.quotation');
      Route::get('/order-successfully-placed', 'orderPlaced')->name('order.placed');
      Route::get('/buyer/order-successfully-placed', 'orderPlaced2')->name('order.placed2');
      Route::get('paypal/status/order', 'payPalStatus')->name('order.paypal.status');
   });
});
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/forget-password', [AuthController::class, 'forgetPassword'])->name('forget.password');
Route::post('/login/verify', [AuthController::class, 'loginNow'])->name('login.now');
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('buyer.send.otp');
Route::post('/forget/send-otp', [AuthController::class, 'sendOtpForget'])->name('forget.send.otp');
Route::post('/forget/verify-otp', [AuthController::class, 'verifyOtpForget'])->name('forget.verify.otp');
Route::post('/change/password', [AuthController::class, 'updatePasswordForget'])->name('forget.update.password');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('buyer.verify.otp');
Route::get('/buyer-complete/{ref_no}/profile', [AuthController::class, 'buyerCompleteProfile'])->name('buyer.complete.profile');
Route::get('/buyer-quick-register', [AuthController::class, 'buyerQuickRegister'])->name('buyer.quick.register');
Route::post('/buyer-complete/profile/store', [AuthController::class, 'completeMyProfile'])->name('buyer.complete.profile.save');

Route::controller(LocationController::class)->group(function () {
   Route::get('/all/countries', 'AllCountries')->name('all.countries');
   Route::get('/all/states', 'AllStates')->name('all.states');
   Route::get('/all/cities', 'AllCities')->name('all.cities');
});

Route::controller(AdminAuthController::class)->group(function () {
   Route::get('admin/login', 'loginPage')->name('admin.login');
   Route::post('admin/login', 'loginNow')->name('admin.login.now');
});
Route::middleware(['role:admin'])->group(function () {
   Route::controller(AdminInboxController::class)->prefix('admin')->group(function () {
	Route::get('/inbox', 'index')->name('admin.inbox');
    Route::post('/inbox/read/{id}', 'markAsRead')->name('admin.inbox.read');
    Route::get('/inbox/dropdown', 'getDropdownMessages')->name('admin.inbox.dropdown');
	Route::delete('/inbox/delete/{id}', 'destroy')->name('admin.inbox.delete');
    Route::get('/inbox/unread-count', 'unreadCount')->name('admin.inbox.unreadCount');

	
	});
   
Route::prefix('admin')->name('admin.')->group(function () {

    Route::resource('sellers', SellerController::class);
    Route::resource('products', ProductController::class);
    Route::resource('tenders', TenderController::class);
   Route::resource('company-logos', App\Http\Controllers\admin\CompanyLogoController::class);
   Route::resource('profile-pictures', App\Http\Controllers\admin\ProfilePictureController::class);
   Route::resource('profile-banners', App\Http\Controllers\admin\ProfileBannerController::class);
   Route::resource('profile-galleries', App\Http\Controllers\admin\ProfileGalleryController::class);
   Route::resource('certificates', App\Http\Controllers\admin\CertificateController::class);

    Route::resource('inquiries', BuyerInquiryController::class)->only(['index','show','destroy']);
    Route::resource('sellerinquiries', SellerInquiryController::class)->only(['index','show','destroy']);
    Route::resource('userinquiries', UserInquiryController::class)->only(['index','show','destroy']);
    //SellerInquiryController
    Route::get('/product-approval', [ProductController::class, 'index'])->name('product.approval');
    Route::get('/product-managment', [ProductController::class, 'productmanagment'])->name('product.productmanagment');
    Route::get('/product-sellout-managment', [ProductController::class, 'productselloutmanagment'])->name('product.productselloutmanagment');
    Route::get('/product-store-managment', [ProductController::class, 'storeproductmanagment'])->name('product.storeproductmanagment');
    Route::get('/product-store-sellout-managment', [ProductController::class, 'storeselloutproductmanagment'])->name('product.storeselloutproductmanagment');

    //
    Route::post('products/approval', [ProductController::class, 'toggleApproval'])->name('products.approval');
    Route::get('/buy-tender-approval',[TenderController::class, 'index'])->name('buy.tender.approval');
    Route::post('tenders/approval', [TenderController::class, 'toggleApproval'])->name('tenders.approval');
    Route::get('/product-images', [ProductController::class, 'product_image'])->name('product.product_images');
    Route::get('/multiply-product-images', [ProductController::class, 'multiply_product_image'])->name('product.multiply_product_images');
    Route::get('/tender-images', [TenderController::class, 'tender_images'])->name('tender.tender_images');
    Route::post('product/toggleApproval', [ProductController::class, 'toggleApproval'])->name('product.approval');
 
    
  Route::get('/trade-sell-list', [TenderController::class, 'allIndex'])->name('sell.trade.list');
 
 Route::get('/all-tender-deal', [TenderController::class, 'allDealIndex'])->name('sell.trade.deal_list'); //
  // Route::get('/trade-sell-list', 'sellTradeList')->name('admin.sell.trade.list');
});

 


   Route::controller(DashboardController::class)->prefix('admin')->group(function () {
      Route::get('/dashboard', 'dashboard')->name('admin.dashboard');
      Route::get('/all-seller', 'showSellers')->name('admin.all.sellers');
      
      Route::get('/seller-approval', 'sellerApproval')->name('admin.seller.approval');

      Route::get('/sell-tender-approval', 'sellTenderApproval')->name('admin.sell.tender.approval');
      Route::get('/payment-center', 'paymentCenter')->name('admin.payment.center');
      Route::get('/product-manager', 'productManagement')->name('admin.product.manager');
      Route::get('/trade-buy-list', 'buyTradeList')->name('admin.buy.trade.list');
      //Route::get('/trade-sell-list', 'sellTradeList')->name('admin.sell.trade.list');
      Route::get('/ads-banners', 'adsBanners')->name('admin.ads.banners');
      Route::get('/all-buy-quotations', 'allBuyQuotation')->name('admin.all.buy.quotations');
      Route::get('/add-new-ads-banner', 'addNewBanner')->name('admin.add.new.banner');
      Route::get('/show-ads-banner', 'showBanner')->name('admin.show.ads.banner');
      Route::get('/seo-management', 'seoManagements')->name('admin.seo.manager');
      Route::get('/add-seo', 'addNewSeo')->name('admin.seo.add');
      Route::get('/all-enquiry', 'enquiryBox')->name('admin.all.enquiries');
      Route::get('/all-advertisement-enquiry', 'advertisementEnquiry')->name('admin.advertisement.enquiries');
      Route::get('/all-admin-enquiry', 'adminEnquiryBox')->name('admin.all.enquiries.admin');
      Route::get('/all-email-templates', 'adminEmailTemplates')->name('admin.all.email.templates');
      Route::get('/add-new-email-template', 'adminAddEmailTemplate')->name('admin.add.email.template');
      Route::get('/bulk-mail-send', 'adminBulkMailSend')->name('admin.bulk.email.send');
      Route::get('/video-show', 'adminVideoShow')->name('admin.video.show');
      //StoresController
   });
   Route::get('/admin/password', [AdminAuthController::class, 'adminPassword'])->name('admin.password.change');
   Route::post('/admin/update/password', [AdminAuthController::class, 'updateAdminPassword'])->name('admin.update.password');
   Route::controller(AdminLocationController::class)->prefix('admin')->group(function () {
      Route::get('/all/country', 'AllCountries')->name('admin.all.countries');
      Route::get('/all/state/{country_id}', 'AllStates')->name('admin.all.states');
      Route::get('/all/city/{state_id}', 'AllCities')->name('admin.all.city');
      Route::post('/add/country', 'AddCountry')->name('admin.add.country');
      Route::post('/add/state', 'AddStates')->name('admin.add.state');
      Route::get('/delete/country/{id}', 'DeleteCountry')->name('admin.delete.country');
      Route::get('/edit/country/{id}', 'EditCountry')->name('admin.edit.country');
      Route::post('/update/country', 'UpdateCountry')->name('admin.update.country');
      Route::post('/update/status', 'UpdateStatus')->name('admin.update.status.country');
      Route::get('/delete/state/{id}', 'DeleteState')->name('admin.delete.state');
      Route::get('/edit/state/{id}', 'EditState')->name('admin.edit.state');
      Route::post('/update/state', 'UpdateState')->name('admin.update.state');
      Route::post('/add/city', 'AddCity')->name('admin.add.city');
      Route::get('/delete/city/{id}', 'DeleteCity')->name('admin.delete.city');
      Route::get('/edit/city/{id}', 'EditCity')->name('admin.edit.city');
      Route::post('/update/city', 'UpdateCity')->name('admin.update.city');
   });
   Route::controller(ProductCategoryController::class)->prefix('admin')->group(function () {
      Route::get('/product/category', 'showParentCategory')->name('admin.show.all.productCategory');
      Route::get('/product/main/category/{id}', 'showCategory')->name('admin.show.all.category');
      Route::get('/product/sub/category/{id}', 'showSubCategory')->name('admin.show.all.subcategory');
      Route::get('/product/end/category/{id}', 'showEndCategory')->name('admin.show.all.endcategory');
      Route::get('/category/attributes/{id}', 'showAttributesCategory')->name('admin.category.attributes');
      Route::get('/delete/parent-category/{id}', 'DeleteParentCategory')->name('admin.delete.parentcategory');
      Route::get('/edit/parent-category/{id}', 'editParentCategory')->name('admin.edit.parentcategory');
      Route::get('/edit/category/{id}', 'editCategory')->name('admin.edit.category');
      Route::get('/edit/sub-category/{id}', 'editsubCategory')->name('admin.edit.subcategory');
      Route::get('/edit/end-sub-category/{id}', 'editendsubCategory')->name('admin.edit.endsubcategory');
      Route::post('/add/parent-category', 'AddParentCategory')->name('admin.add.parentcategory');
      Route::post('/add/category', 'AddCategory')->name('admin.add.category');
      Route::post('/add/sub-category', 'AddsubCategory')->name('admin.add.subcategory');
      Route::post('/add/end-sub-category', 'AddEndsubCategory')->name('admin.add.endsubcategory');
      Route::post('/add/category/attributes', 'AddAttrCategory')->name('admin.add.attrcategory');
      Route::post('/edit/parent-category', 'UpdateParentCategory')->name('admin.update.parentcategory');
      Route::post('/edit/category', 'UpdateCategory')->name('admin.update.category');
      Route::post('/edit/sub-category', 'UpdatesubCategory')->name('admin.update.subcategory');
      Route::post('/edit/end-sub-category', 'UpdateendsubCategory')->name('admin.update.endsubcategory');
      Route::post('/status/parent-category', 'updateStatusParentCategory')->name('admin.status.parentcategory');
      Route::post('/status/attribute-category', 'updateStatusAttrCategory')->name('admin.status.category.attribute');
      Route::post('/status/category', 'updateStatusCategory')->name('admin.status.category');
      Route::post('/status/sub-category', 'updateStatussubCategory')->name('admin.status.subcategory');
      Route::get('/delete/category/{id}', 'DeleteCategory')->name('admin.delete.category');
      Route::get('/delete/subcategory/{id}', 'DeletesubCategory')->name('admin.delete.subcategory');
      Route::get('/delete/endsubcategory/{id}', 'DeleteEndsubCategory')->name('admin.delete.endsubcategory');
      Route::get('/delete/category-attribute/{id}', 'DeleteCategoryAttr')->name('admin.delete.attrcategory');
      Route::post('/status/end-sub-category', 'updateStatusEndsubCategory')->name('admin.status.endsubcategory');
   });
   Route::controller(importController::class)->prefix('admin')->group(function () {
      Route::get('/show/import/category', 'showImportCategoryCsv')->name('admin.simport.category');
      Route::get('/show/import/quotation/category', 'showImportQuotationCategoryCsv')->name('admin.quotation.import.category');
      Route::get('/show/import/tender/category', 'showImportTenderCategoryCsv')->name('admin.tender.import.category');
      Route::post('/import/category', 'importCategoryCsv')->name('admin.import.category');
      Route::post('/import/quotation/category', 'importQuotationCategoryCsv')->name('admin.import.quotation.category');
      Route::post('/import/tender/category', 'importTenderCategoryCsv')->name('admin.import.tender.category');
      Route::get('/import-customer', 'importCustomer')->name('admin.import.customers');
   });
   Route::controller(SupplierController::class)->prefix('admin')->group(function () {
      Route::get('/suppliers-category', 'index')->name('admin.suppliers.category');
      Route::get('/delete/{id}/suppliers-category', 'DeleteCategory')->name('admin.delete.suppliers.category');
      Route::get('/edit/{id}/suppliers-category', 'edit')->name('admin.edit.suppliers.category');
      Route::post('/suppliers-category/status', 'changeStatus')->name('admin.status.supplier.category');
      Route::post('/store/suppliers-category', 'store')->name('admin.store.supplier.category');
      Route::post('/update/suppliers-category', 'update')->name('admin.update.supplier.category');
   });
   Route::controller(SuppliersSubcategoryController::class)->prefix('admin')->group(function () {
      Route::get('/suppliers-subcategory/{id}', 'index')->name('admin.suppliers.subcategory');
      Route::get('/delete/{id}/suppliers-subcategory', 'DeleteCategory')->name('admin.delete.suppliers.subcategory');
      Route::get('/edit/{id}/suppliers-subcategory', 'edit')->name('admin.edit.suppliers.subcategory');
      Route::post('/suppliers-subcategory/status', 'changeStatus')->name('admin.status.supplier.subcategory');
      Route::post('/store/suppliers-subcategory', 'store')->name('admin.store.supplier.subcategory');
      Route::post('/update/suppliers-subcategory', 'update')->name('admin.update.supplier.subcategory');
   });

   Route::controller(TendersController::class)->prefix('admin')->group(function () {
      Route::get('/tenders-category', 'index')->name('admin.tenders.category');
      Route::get('/delete/{id}/tender-category', 'DeleteCategory')->name('admin.delete.tender.category');
      Route::get('/edit/{id}/tender-category', 'edit')->name('admin.edit.tender.category');
      Route::post('/tender-category/status', 'changeStatus')->name('admin.status.tender.category');
      Route::post('/store/tender-category', 'store')->name('admin.store.tender.category');
      Route::post('/update/tender-category', 'update')->name('admin.update.tender.category');
   });

   Route::controller(StoresController::class)->prefix('admin')->group(function () {
      Route::get('/stores', 'index')->name('admin.stores.index');  
      Route::get('/stores-images', 'images')->name('admin.stores.images');
      Route::get('/stores-banners', 'storeBanners')->name('admin.stores.banners'); 
      Route::post('/change-status', 'storeChangeStatus')->name('admin.stores.change_status');  
      //
      // Route::get('/delete/{id}/tender-category', 'DeleteCategory')->name('admin.delete.tender.category');
      // Route::get('/edit/{id}/tender-category', 'edit')->name('admin.edit.tender.category');
      // Route::post('/tender-category/status', 'changeStatus')->name('admin.status.tender.category');
      // Route::post('/store/tender-category', 'store')->name('admin.store.tender.category');
      // Route::post('/update/tender-category', 'update')->name('admin.update.tender.category');
   });
   Route::controller(ProductVideoShowController::class)->prefix('admin')->group(function () {
      Route::get('/videos', 'index')->name('admin.videos.index');  
      // Route::get('/delete/{id}/tender-category', 'DeleteCategory')->name('admin.delete.tender.category');
      // Route::get('/edit/{id}/tender-category', 'edit')->name('admin.edit.tender.category');
      // Route::post('/tender-category/status', 'changeStatus')->name('admin.status.tender.category');
      // Route::post('/store/tender-category', 'store')->name('admin.store.tender.category');
      // Route::post('/update/tender-category', 'update')->name('admin.update.tender.category');
   });
   Route::controller(TenderSubcategoryController::class)->prefix('admin')->group(function () {
      Route::get('/tenders-subcategory/{id}', 'index')->name('admin.tenders.subcategory');
      Route::get('/delete/{id}/tender-subcategory', 'DeleteCategory')->name('admin.delete.tender.subcategory');
      Route::get('/edit/{id}/tender-subcategory', 'edit')->name('admin.edit.tender.subcategory');
      Route::post('/tender-subcategory/status', 'changeStatus')->name('admin.status.tender.subcategory');
      Route::post('/store/tender-subcategory', 'store')->name('admin.store.tender.subcategory');
      Route::post('/update/tender-subcategory', 'update')->name('admin.update.tender.subcategory');
   });

   Route::controller(QuotationController::class)->prefix('admin')->group(function () {
      Route::get('/quotations-category', 'index')->name('admin.quotations.category');
      Route::get('/delete/{id}/quotation-category', 'DeleteCategory')->name('admin.delete.quotation.category');
      Route::get('/edit/{id}/quotation-category', 'edit')->name('admin.edit.quotation.category');
      Route::post('/quotation-category/status', 'changeStatus')->name('admin.status.quotation.category');
      Route::post('/store/quotation-category', 'store')->name('admin.store.quotation.category');
      Route::post('/update/quotation-category', 'update')->name('admin.update.quotation.category');

      Route::get('/quotation-images','allQuotations')->name('admin.quotation.images');
      Route::get('/quotations','allListedQuotations')->name('admin.quotations');
      Route::get('/quotations/{id}','showQuotations')->name('admin.quotations.show');
   
   });
   Route::controller(QuotationsSubcategoryController::class)->prefix('admin')->group(function () {
      Route::get('/quotations-subcategory/{id}', 'index')->name('admin.quotations.subcategory');
      Route::get('/delete/{id}/quotation-subcategory', 'DeleteCategory')->name('admin.delete.quotation.subcategory');
      Route::get('/edit/{id}/quotation-subcategory', 'edit')->name('admin.edit.quotation.subcategory');
      Route::post('/quotation-subcategory/status', 'changeStatus')->name('admin.status.quotation.subcategory');
      Route::post('/store/quotation-subcategory', 'store')->name('admin.store.quotation.subcategory');
      Route::post('/update/quotation-subcategory', 'update')->name('admin.update.quotation.subcategory');
   });
   Route::controller(GeneralSettingController::class)->prefix('admin')->group(function () {
      Route::get('/general-setting', 'index')->name('admin.general.setting');
      Route::post('/website-detail-update', 'updateWebsiteDetail')->name('admin.website.detail.update');
      Route::post('/payment-method-update', 'updatePayPal')->name('admin.payment.method.update');
      Route::post('/social-links-update', 'socialLinkSetting')->name('admin.social.links.update');
      Route::post('/smtp-update', 'smtpSetting')->name('admin.smtp.setting.update');
      Route::post('/google-setting-update', 'googleSetting')->name('admin.google.setting.update');
      Route::post('/website-status-update', 'webstatus')->name('admin.web.status.update');
      Route::post('/emailconfimation-status-update', 'emailConfimation')->name('admin.email.confirm.status.update');
      Route::post('/website-logo-update', 'websiteLogo')->name('admin.website.logo.update');
   });
   Route::controller(HomePageController::class)->prefix('admin')->group(function () {
      Route::get('/home-setting', 'index')->name('admin.home.setting');
      Route::post('/change-banner', 'uploadBanners')->name('admin.update.home.banner');
      Route::post('/change-home-category-data', 'updateHomeTopInfo')->name('admin.update.home.category.banner');
      Route::get('/edit-home-info/{id}/show', 'editHomeInfo')->name('admin.edit.home.info');
      Route::post('/update-home-info', 'updateHomeInfo')->name('admin.update.home.info');
   });
   Route::controller(MemberPackageController::class)->prefix('admin')->group(function () {
      Route::get('/member-packages', 'index')->name('admin.member.package');
      Route::get('/member-package/{id}/edit', 'editPackage')->name('admin.member.edit.package');
      Route::get('/member-package-service/{id}/delete', 'DeletePackageService')->name('admin.member.delete.package');
      Route::get('/member-package-service/{id}/edit', 'editPackageService')->name('admin.edit.package.service');
      Route::post('/member-package-service/update', 'updatePackage')->name('admin.member.update.package');
      Route::post('/member-package-service/status', 'updateStatusPackageService')->name('admin.member.status.package');
      Route::get('/member-packages-service/add', 'addNewPackageService')->name('admin.add.package.service');
      Route::post('/member-packages-service/store', 'storeNewPackageService')->name('admin.store.package.service');
      Route::post('/member-packages-service/update', 'updatePackageService')->name('admin.update.package.service');
   });
   Route::controller(BuyerController::class)->prefix('admin')->group(function () {
      Route::get('/show-buyers', 'showAllBuyers')->name('admin.show.buyers');
      Route::get('/delete-user/{id}', 'deleteUser')->name('admin.delete.user');
      Route::get('/edit-user/{id}', 'editBuyer')->name('admin.edit.user');
      Route::post('/change-status', 'updateStatus')->name('admin.update.status.user');
      Route::post('/update-buyer', 'updateBuyer')->name('admin.update.buyer');
   });
   Route::controller(StaticPageController::class)->prefix('admin')->group(function () {
      Route::get('/add-static-page', 'addStaticPage')->name('admin.add.static.page');
      Route::get('/all-static-page', 'allStaticPage')->name('admin.all.static.page');
      Route::get('/cms-static-page', 'allCMSPage')->name('admin.cms.static.page');
   });
   Route::controller(NewsBlogController::class)->prefix('admin')->group(function () {
      Route::get('/all-news', 'allNews')->name('admin.all.news');
      Route::get('/all-news-images', 'allNewsImages')->name('admin.all.newsImages');
      Route::get('/add-news', 'addNews')->name('admin.add.news');
      Route::get('/delete-news/{id}', 'deleteNews')->name('admin.delete.news');
      Route::get('/edit-news/{id}', 'editNews')->name('admin.edit.news');
      Route::post('/store-news', 'storeNews')->name('admin.store.news');
      Route::post('/update-news', 'updateNews')->name('admin.update.news');
      Route::post('/update-status-news', 'updateStatus')->name('admin.update.status.news');
   });
   Route::controller(CustomeCategoryController::class)->prefix('admin')->group(function () {
      Route::get('/all-category', 'allCategory')->name('admin.all.custome.category');
      Route::get('/all-child-category/{id?}', 'showChildCategory')->name('admin.show.all.child-category');
      Route::get('/edit-category/{id?}', 'editCategory')->name('admin.edit.custome-category');
      Route::get('/delete-category/{id?}', 'deleteCategory')->name('admin.delete.custome-category');
      Route::post('/add-category', 'addCategory')->name('admin.add.custome-category');
      Route::post('/status-update-category', 'statusCategory')->name('admin.status.custome-category');
      Route::post('/update-category', 'updateCategory')->name('admin.update.custome-category');
   });
   Route::controller(AttributesController::class)->prefix('admin')->group(function () {
      Route::get('/attribute', 'index')->name('admin.all.attribute');
      Route::get('/delete-attribute/{id}', 'deleteAttribute')->name('admin.delete.attribute');
      Route::get('/edit-attribute/{id}', 'edit')->name('admin.edit.attribute');
      Route::post('/add-attribute', 'create')->name('admin.add.attribute');
   });
   Route::controller(CouponController::class)->prefix('admin')->group(function () {
      Route::get('/coupon', 'index')->name('admin.all.coupon');
      Route::get('/create/coupon', 'create')->name('admin.create.coupon');
      Route::post('/coupon', 'save')->name('admin.save.coupon');
      Route::get('/coupon/{coupon_id}', 'edit')->name('admin.edit.coupon');
      Route::put('/coupon/{coupon_id}', 'updateCoupon')->name('admin.update.coupon');
      Route::post('/coupon/status', 'updateStatus')->name('admin.update.status.coupon');
      Route::delete('/coupon/{coupon_id}', 'deleteCoupon')->name('admin.delete.coupon');
   });
   Route::controller(BulkMailController::class)->prefix('admin')->group(function () {
      Route::get('/bulk-mail', 'bulkMail')->name('admin.send.bulk.mail');
      Route::post('/send/bulk-mail', 'sendbulkMail')->name('bulk-mail.send');
   });
});
Route::middleware(['role:buyer'])->group(function () {
   Route::controller(BuyerController::class)->prefix('buyer')->group(function () {
      Route::get('/dashboard', 'buyerDashboard')->name('buyer.dashboard');
      Route::get('/profile-picture', 'profileImageGallery')->name('buyer.profile.picture');
      Route::post('/profile-picture', 'updateProfilePicture')->name('buyer.update.profile.picture');
      Route::get('/delete-profile-picture', 'deleteMyProfile')->name('buyer.delete.profile.picture');
      Route::get('/{ref_no}/upgrade-to-seller', 'upgradeToSeller')->name('buyer.upgrade.to.seller');
      Route::get('/{package_id}/{ref_no}/upgrade-seller', 'upgradePackageSeller')->name('buyer.upgrade.seller');
      Route::post('/upgrade-to-seller/store', 'upgradeToSellerSave')->name('buyer-upgrade.complete.profile.save');
      Route::get('/upgrade-to-seller/pay', 'upgradePaymentPackage')->name('buyer-upgrade.seller.pay');
      Route::get('/buyer/upgrade-to-seller/status', 'payPalStatus')->name('buyer-upgrade.seller.pay.status');
      Route::get('/dashboard/new-state/tenders', 'newStateTender')->name('buyer.newstate.tender');
      Route::get('/dashboard/new-state/quotation', 'newStateQuotation')->name('buyer.newstate.quotation');
   });

   Route::controller(QuotationController::class)->prefix('buyer')->group(function () {
      Route::get('/my-posted-quotations', 'myquotations')->name('buyer.myquotations.show');
      Route::post('/delete-quotation', 'myDeleteQuotation')->name('buyer.delete.quotation');
      Route::get('/my-posted-quotations-expired', 'myExpiredQuotations')->name('buyer.myexpired.quotations.show');
      Route::get('/{quotation_id}/edit-quotation', 'editQuotation')->name('buyer.edit.quotation');
      Route::post('/update-quotation', 'updateQuotation')->name('buyer.update.quotation');
      Route::get('/my-submitted-quotes', 'mySubmittedQuotes')->name('buyer.mysubmitted.quotes.show');
      Route::post('/delete-quote', 'myDeleteQuote')->name('buyer.delete.quote');
   });
   Route::controller(ProductsController::class)->prefix('buyer')->group(function () {
      Route::get('/my-purchased-products', 'myBuyProducts')->name('buyer.purchased.product');
      Route::get('/my-purchased/{order_item_id}/product-detail', 'myBuyProductDetail')->name('buyer.purchased.product.detail');
   });
   Route::controller(OfferTenderController::class)->prefix('buyer')->group(function () {
      Route::get('/offered-tender', 'offeredTender')->name('buyer.offered.tender');
      Route::get('/offer/deals/tender', 'dealOfferTender')->name('buyer.deal.offer.tender');
      Route::get('/offer/my-deals/tender', 'dealMyOfferTender')->name('buyer.my-deals.offer.tender');
      Route::get('/offer/supplier-deals/tender', 'dealSupplierOfferTender')->name('buyer.supplier-deals.offer.tender');
      Route::get('/delete-tender-offer/{offer_id}', 'deleteTenderOffer')->name('buyer.delete.tender-offer');
      Route::get('/success/offer/{slug}/tender', 'successTenderOfferPage')->name('buyer.success.offer.tender');
      Route::get('/success/message', 'successTenderOfferPage')->name('buyer.success');
      Route::get('/offer/tender', 'counterOffersTender')->name('buyer.counter.offer.tender');
      Route::get('/deal-tender/{slug}/{offer_id}/detail', 'dealTenderDetail')->name('buyer.deal-detail.tender');
      Route::post('/counter/offers/tender', 'acceptCounterOfferTender')->name('buyer.accept-counter.tender.offer');
      Route::post('/delete/counter/offer/tender', 'deleteReceiveCounterOfferTender')->name('buyer.delete-received-counter.offer.tender');
     
   });

   Route::controller(UserQuotationController::class)->prefix('buyer')->group(function () {
      Route::get('/my-received-quotes', 'myReceivedQuotes')->name('buyer.myreceived.quotes.show');
      Route::post('/delete-received-quotation', 'myDeleteReceivedQuotation')->name('buyer.delete.quote.offer');
      Route::post('/accept-quote-offer', 'acceptQuoteOffer')->name('buyer.accept.quote.offer');
      Route::post('/send/quote/counter-offer', 'sendQuoteCounterOffer')->name('buyer.send.quote-counter.offer');
      Route::post('/delete/counter-quote', 'myDeleteCounterQuote')->name('buyer.delete.counter-quote.offer');
      Route::get('/received/counter-quotes', 'counterOffers')->name('buyer.quote-counter.offer');
      Route::get('/counters/quotes', 'myCounterQuotes')->name('buyer.counter.quotes.show');
      Route::get('/deals/quotes', 'dealQuotes')->name('buyer.quote-deal');
      Route::get('/my-deals/quotes', 'dealMyQuotes')->name('buyer.my-quote-deal');
      Route::get('/supplier-deals/quotes', 'dealSupplierQuotes')->name('buyer.supplier-quote-deal');
      
      Route::get('/deal/quotes/{slug}/{offer_id}/details', 'dealQuotesDetails')->name('buyer.offer.quote-deal');
      Route::post('/accept/counter-quote-offer', 'acceptCounterQuoteOffer')->name('buyer.sender.accept-counter-quote');
      Route::post('/deal/update-quotation', 'updateQuotationDealStatus')->name('buyer.status.deal-quotation');
   });
});



// Route::controller(MemberPackageController::class)->prefix('user')->group(function () {
//    Route::get('/member-packages', 'indexClient')->name('user.member.package');
// });
Route::controller(MemberPackageController::class)->group(function () {
   Route::get('/member-packages', 'indexClient')->name('user.member.package');
}); 

Route::controller(SourceProController::class)->group(function () {
   Route::get('/source-pro', 'sourcePro')->name('user.source-pro');
   Route::get('/source-pro/{slug}', 'sourceProDetail')->name('user.source-pro.detail');
   Route::post('/make-offer/quotation', 'sendOffer')->name('offer.quotation');
   Route::post('/accept-offer/quotation', 'directOrder')->name('accept.offer.quotation');
});

Route::view('/user/benefits-for-buyers', 'external-user.benefits_for_buyers')->name('benefits.buyers');
Route::view('/user/help-support', 'external-user.help-and-community')->name('help.community');
Route::controller(UserQuotationController::class)->prefix('user')->group(function () {
   Route::get('/get-quotes', 'getQuotePage')->name('user.get.quotes');
   Route::post('/get-quotes', 'sendGetQuotes')->name('user.send.get.quotes');
});

Route::controller(CustomeCategoryController::class)->group(function () {
   Route::get('/all-category', 'index')->name('user.all.category');
});
Route::get('/refereshcapcha', [FrontUIController::class, 'refreshCaptcha'])->name('refreshCaptcha');
Route::get('/places', [PlacesController::class, 'index'])->name('get.all.cities');

Route::controller(UITendersController::class)->prefix('main')->group(function () {
   
   Route::get('/all-tenders/{slug?}', 'index')->name('filter.all.tenders');
 
});
Route::controller(OfferTenderController::class)->prefix('main')->group(function () {
   Route::post('/make-offer/tender', 'sendOffer')->name('offer.tender');
   Route::post('/accept-offer/tender', 'directOrder')->name('accept.offer.tender');
});
Route::controller(UISellerController::class)->group(function () {
   Route::get('/business-profile/{code?}', 'profilePreview')->name('seller.profile.view');
});

Route::controller(InboxController::class)->prefix('main')->group(function () {
   Route::post('/send-contact-message', 'sendMessageToContact')->name('send.contact.form');
   Route::post('/send-message', 'sendMessageToContactAjax')->name('send.contact.form2');
   Route::post('/send-seller-message/product', 'sendMessageToProductAjax')->name('send.contact.product.form');
   Route::get('/my-inbox', 'myinbox')->name('inbox.show');
   Route::get('/reply/{mail_id}/message', 'replyMessage')->name('reply.message');
   Route::get('/delete/{mail_id}/message', 'deleteMessage')->name('delete.message');
   Route::get('/get/message', 'fetchMessages')->name('fetch.chat.messages');
   Route::post('/sent/message', 'sendMessage')->name('send.chat.message');
});




// for seller authentications


Route::controller(SellerAuthController::class)->prefix('seller')->group(function () {
   Route::get('/{code}/seller-registration', 'quickRegistration')->name('seller.registration');
   Route::get('/{code}/seller-complete-registration', 'completeRegistration')->name('seller.complete.registration');
   Route::post('/copon-verify', 'verifyCode')->name('apply.coupon');
   Route::post('/seller-send-otp', 'sendOtp')->name('seller.send.otp');
    Route::post('/seller-send-reg-otp', 'sendRegOtp')->name('seller.sendreg.otp');
   Route::post('/seller/verifyreg/otp', 'verifyRegOtp')->name('seller.verify.regotp');
   
   //verifyRegOtp
   Route::post('/seller/verify/otp', 'verifyOtp')->name('seller.verify.otp');
   Route::post('/seller-complete/profile/store', 'completeMyProfile')->name('seller.complete.profile.save');
});
Route::controller(RatingController::class)->prefix('buyer')->group(function () {
   Route::post('/buyer-set-rating', 'setBuyerRate')->name('buyer.set.rate');
});
Route::middleware(['role:seller'])->group(function () {
   Route::controller(SellerAuthController::class)->prefix('seller')->group(function () {
      Route::get('/dashboard', 'sellerDashboard')->name('seller.dashboard');
      Route::get('/dashboard/new-state/store', 'newStateStore')->name('seller.newstate.store');
      Route::get('/dashboard/new-state/product', 'newStateProduct')->name('seller.newstate.product');
      Route::get('/dashboard/new-state/tenders', 'newStateTender')->name('seller.newstate.tender');
      Route::get('/dashboard/new-state/quotation', 'newStateQuotation')->name('seller.newstate.quotation');
      Route::get('/{code}/seller-edit-profile', 'editRegistration')->name('seller.edit.registration');
      Route::get('/{code}/seller-profile-edit', 'editSellerProfile')->name('seller.edit.profile');
      Route::get('/{code}/profile-preview', 'profilePreview')->name('seller.profile.preview');
      Route::get('/my-business-profile', 'companyProfile')->name('seller.company.profile');
      Route::get('/my-shipment-methods', 'shipmentMethods')->name('seller.shipment.methods');
      Route::get('/my-search-key', 'searchKeys')->name('seller.search.keys');
      Route::post('/my-search-key', 'updateSearchKeys')->name('seller.update.search.keys');
      Route::post('/seller-edit/profile/store', 'editMyProfile')->name('seller.edit.profile.save');
      Route::post('/seller-update/profile/store', 'editSellerStore')->name('seller.edit.profile.store');
      Route::post('/seller-edit/profile/export-regions', 'editMyExports')->name('seller.edit.export-regions');
      Route::post('/seller-edit/profile/shipping-options', 'editDeliveryOption')->name('seller.edit.shipping-options');
      Route::post('/seller-send-otp/update-business-profile', 'sendOtpAfterLogin')->name('seller.send.otp.business');
      Route::post('/seller-validate-otp/update-business-profile', 'verifyOtpAfterLogin')->name('seller.validate.otp.business');
      Route::get('/create-spotlight-store', 'createWebsite')->name('create.spotlight.store')->middleware('checkService:Subdomain Spotlight Store');
      Route::get('/check-spotlight-availability', 'checkDomainAvailability')->name('seller.checkdomain.availability');
      Route::post('/spotlight/domain/update', 'updateDomain')->name('seller.update.domain');
      Route::get('/add-meta-data', 'addMetaData')->name('seller.add.meta-data')->middleware('checkService:Subdomain Spotlight Store');
      Route::post('/add-meta-data', 'updateMetaData')->name('seller.update.meta-data');
      Route::get('/profile/meta-data', 'addProfileMetaData')->name('seller.profile.meta-data')->middleware('checkService:Company + Store SEO');
      Route::post('/profile/meta-data', 'updateProfileMetaData')->name('seller.update.profile-meta-data');
      Route::get('/store/search-key', 'storeSearchKeys')->name('seller.spotlight.search.key')->middleware('checkService:Subdomain Spotlight Store');
      Route::post('/store/search-key', 'updateStoreSearchKeys')->name('seller.update.store-search.keys');
   });
   Route::controller(MemberPackageController::class)->prefix('seller')->group(function () {
      Route::get('/upgrade-member-packages', 'upgradeMembership')->name('seller.upgrade.member.package');
      Route::post('/upgrade-member-packages', 'upgradeMembershipPay')->name('seller.upgrade.membership.pay');
      Route::get('/upgrade-payment-status', 'payPalStatus')->name('seller.upgrade.pay.status');
   });
   Route::controller(sellerGalleryController::class)->prefix('seller')->group(function () {
      Route::get('/business/gallery', 'vendorGallery')->name('seller.vendor.gallery');
      Route::get('/spotlight/gallery', 'spotlightGallery')->name('seller.spotlight.gallery')->middleware('checkService:Subdomain Spotlight Store');
      Route::get('/business/gallery/{col}/delete', 'deleteVendorGallery')->name('delete.vendor.gallery');
      Route::delete('/business/vendor/delete', 'deleteVendorProfile')->name('vendor.delete.profile.picture');
      Route::post('/business/vendor/update', 'updateVendorProfile')->name('vendor.upload.profile.picture');
      Route::post('/spotlight/gallery/update', 'updateSpotlightGallery')->name('vendor.upload.spotlight.picture');
      Route::delete('/business/logo/delete', 'deleteCompanylogo')->name('company-logo.delete.picture');
      Route::delete('/business/banner/delete', 'deleteCompanyBanner')->name('business-banner.delete.picture');
      Route::post('/business/logo/update', 'updateBusinessLogo')->name('business.upload.logo');
      Route::post('/business/profile-banner/update', 'updateBusinessProfileBanner')->name('business.upload.profile-banner');
      Route::post('/business/profile-gallery/update', 'updateBusinessGallery')->name('business.upload.gallery');
      Route::get('/success/gallery', 'successPage')->name('seller.success.gallery');
   });

   Route::controller(CompanyCertificateController::class)->prefix('seller')->group(function () {
      Route::get('/certificates', 'allCertificates')->name('seller.certificates');
      Route::get('/certificate/{certificate_id}/delete', 'deleteCertificate')->name('company.delete.certificate');
      Route::post('/certificate/store', 'updateCompanyCertificate')->name('company.upload.certificate');
   });

   Route::controller(SocialMediaController::class)->prefix('seller')->group(function () {
      Route::get('/my-social-media', 'allSocialMedia')->name('seller.social-media');
      Route::post('/my-social-media', 'addSocialMedia')->name('company.add.social');
   });

   Route::controller(BusinessProfileSymbolController::class)->prefix('seller')->group(function () {
      Route::get('/business-profile-symbols', 'allBusinessSymbol')->name('seller.business.symbols');
      Route::post('/business-profile-symbols', 'addBusinessSymbol')->name('business.add.symbols');
   });
   Route::controller(BankDetailsController::class)->prefix('seller')->group(function () {
      Route::get('/bank-detail', 'bankDetail')->name('seller.bank.detail');
      Route::post('/bank-detail', 'addBandDetail')->name('seller.add.bank.detail');
   });
   Route::controller(BankDetailsController::class)->prefix('seller')->group(function () {
      Route::get('/bank-detail', 'bankDetail')->name('seller.bank.detail');
      Route::post('/bank-detail', 'addBandDetail')->name('seller.add.bank.detail');
   });

   Route::controller(SellerProductController::class)->prefix('seller')->group(function () {
      Route::get('/single-listing', 'addProduct')->name('seller.add.product');
      Route::get('/need-to-upgrade/membership/package', 'upgradeLimitPackage')->name('seller.upgrade.limit');
      Route::get('/multiple-listing', 'addMultipleProduct')->name('seller.multiple-listing');
      Route::get('/get-category', 'searchCategories')->name('seller.get.category');
      Route::post('/get-subcategories', 'getSubCategories')->name('seller.get.subcategory');
      Route::post('/get-sub-subcategories', 'getSubSubCategories')->name('seller.get.subsubcategory');
      Route::post('/get-child-categories', 'getChildCategories')->name('seller.get.childcategory');
      Route::post('/get-category-attributes', 'getCategoryAttributes')->name('seller.get.category.attributes');
      Route::post('/store-product', 'storeProduct')->name('seller.store.product');
      Route::post('/store-multiple-product', 'storeMultipleProduct')->name('seller.store.multiple-product');
      Route::post('/update-product-addons', 'updateProductAddon')->name('seller.update.product.addons');
      Route::post('/delete-product', 'deleteProduct')->name('seller.delete.product');
      Route::get('/my-product', 'myProduct')->name('seller.get.products');
      Route::get('/my-inactive-product', 'myInactiveProduct')->name('seller.get.inactive.products');
      Route::get('/my-multiply-products', 'myMultiplyProduct')->name('seller.get.multiply.products');
      Route::get('/edit/{product_id}/product', 'editProduct')->name('seller.edit.product');
      Route::get('/edit/{product_id}/multiply-listing', 'editMultiplyListing')->name('seller.edit.multiply-list');
      Route::get('/delete/product/gallery/{image_id?}', 'deleteGalleryImage')->name('seller.delete.product.image');
      Route::post('/update-product', 'updateProduct')->name('seller.update.product');
      Route::post('/update-order-status', 'updatePaymentStatus')->name('seller.update.order.status');
      Route::post('/update-order-item-status', 'updateOrderItemStatus')->name('seller.update.order-item.status');
      Route::post('/update-multiply-listing', 'updateProductMultiply')->name('seller.update.product.multiply');
      Route::get('/my-sold-products', 'mySoldProducts')->name('seller.get.sold.products');
      Route::get('/my-sold-multiple-products', 'mySoldProductMultiply')->name('seller.get.msold.products');
      Route::get('/my-purchased-products', 'myBuyProducts')->name('seller.purchased.product');
      Route::get('/my-purchased/{order_item_id}/product-detail', 'myBuyProductDetail')->name('seller.purchased.product.detail');
      Route::get('/my-sold/{order_item_id}/product-detail', 'mySoldProductDetail')->name('seller.sold.product.detail');
      Route::get('/success/{slug}/product/{what?}', 'successPage')->name('seller.success.list.product');
   });
   Route::controller(SellerNewsController::class)->prefix('seller')->group(function () {
      Route::get('/add-news', 'addNews')->name('seller.add.news');
      Route::get('/my-news', 'mynews')->name('seller.my.news');
      Route::get('/edit-news/{slug}', 'editNews')->name('seller.edit.news');
      Route::post('/save-news', 'saveNews')->name('seller.save.news');
      Route::post('/status-change-news', 'statusChange')->name('seller.status.news');
      Route::post('/delete-news', 'deleteNews')->name('seller.delete.news');
      Route::get('/success/{slug}/news/{what?}', 'successPage')->name('seller.success.news');
   });
   Route::controller(SellerTenderController::class)->prefix('seller')->group(function () {
      Route::get('/add-tender', 'index')->name('seller.add.tender');
      Route::get('/my-tenders', 'mytender')->name('seller.get.tender');
      Route::get('/my-expired-tenders', 'myExpiredTender')->name('seller.get.expired-tender');
      Route::get('/edit-tender/{slug}', 'editTender')->name('seller.edit.tender');
      Route::post('/save-tender', 'saveTender')->name('seller.store.tender');
      Route::post('/update-tender', 'updateTender')->name('seller.update.tender');
      Route::post('/status-change-tender', 'statusChange')->name('seller.status.tender');
      Route::post('/delete-tender', 'deleteTender')->name('seller.delete.tender');
      Route::post('/image/delete-tender', 'deleteTenderImg')->name('delete.tender-img');
      Route::get('/offered-tender', 'offeredTender')->name('seller.offered.tender');
      Route::get('/delete-tender-offer/{offer_id}', 'deleteTenderOffer')->name('seller.delete.tender-offer');
      Route::get('/success/{slug}/tender/{what?}', 'successPage')->name('seller.success.tender');
      Route::get('/deal-tender/{slug}/{offer_id}/detail', 'dealTenderDetail')->name('seller.deal-detail.tender');
      Route::post('/deal/status-change-tender', 'statusDealChange')->name('seller.status.deal-tender');
   });
   Route::controller(OfferTenderController::class)->prefix('seller')->group(function () {
      Route::get('/success/offer/{slug}/tender', 'successTenderOfferPage')->name('seller.success.offer.tender');
      Route::get('/received/offer/tender', 'receivedOfferTender')->name('seller.received.offer.tender');
      
      Route::get('/offer/deals/tender', 'dealOfferTender')->name('seller.deal.offer.tender');
      Route::get('/offer/my-deals/tender', 'dealMyOfferTender')->name('seller.my-deal.offer.tender');
      Route::get('/offer/supplier-deals/tender', 'dealSupplierOfferTender')->name('seller.supplier-deal.offer.tender');
      
      Route::post('/delete/offer/tender', 'deleteOfferTenderBySeller')->name('seller.delete-received.offer.tender');
      Route::post('/accept/offer/tender', 'acceptOfferTenderBySeller')->name('seller.accept.tender.offer');
      Route::post('/reject/offer/tender', 'rejectOfferTenderBySeller')->name('seller.reject.tender.offer');
      Route::post('/counter/offer/tender', 'sendCounterOfferTender')->name('seller.send.offer-counter.offer');
      Route::get('/receive/counter-offers/tender', 'counterOffersTender')->name('seller.receive.offer-counter.tender');
      Route::get('/my-counter-offers/tender', 'myCountersOffersTender')->name('seller.offer-counter.tender');
      Route::post('/delete/counter-offer/tender', 'deleteCounterOfferTender')->name('seller.delete-counter.offer.tender');
      Route::post('/delete/receive/counter-offer/tender', 'deleteReceiveCounterOfferTender')->name('seller.delete-received-counter.offer.tender');
      Route::post('/accept/counter/offer/tender', 'acceptCounterOfferTender')->name('seller.accept-counter.tender.offer');
      Route::post('/reject/counter/offer/tender', 'rejectCounterOfferTender')->name('seller.reject-counter.tender.offer');
   });

   Route::controller(UserQuotationController::class)->prefix('seller')->group(function () {
      Route::get('/my-posted-quotations', 'myquotations')->name('myquotations.show');
      Route::post('/delete-quotation', 'myDeleteQuotation')->name('seller.delete.quotation');
      Route::post('/img/delete-quotation', 'myDeleteQuotationImg')->name('delete.quotation-img');
      Route::get('/my-posted-quotations-expired', 'myExpiredQuotations')->name('myexpired.quotations.show');
      Route::get('/my-submitted-quotes', 'mySubmittedQuotes')->name('mysubmitted.quotes.show');
      Route::post('/delete-quote', 'myDeleteQuote')->name('seller.delete.quote');
      Route::get('/my-received-quotes', 'myReceivedQuotes')->name('myreceived.quotes.show');
      Route::post('/delete-received-quotation', 'myDeleteReceivedQuotation')->name('seller.delete.quote.offer');
      Route::post('/accept-quote-offer', 'acceptQuoteOffer')->name('seller.accept.quote.offer');
      Route::post('/send/quote/counter-offer', 'sendQuoteCounterOffer')->name('seller.send.quote-counter.offer');
      Route::post('/delete/counter-quote', 'myDeleteCounterQuote')->name('seller.delete.counter-quote.offer');
      Route::get('/counters/quotes', 'myCounterQuotes')->name('my.counter.quotes.show');
      Route::get('/received/counter-quotes', 'counterOffers')->name('seller.quote-counter.offer');
      Route::get('/deals/quotes', 'dealQuotes')->name('seller.quote-deal');
      Route::get('/my-deals/quotes', 'dealMyQuotes')->name('seller.my-quote-deal');
      Route::get('/supplier-deals/quotes', 'dealSupplierQuotes')->name('seller.supplier-quote-deal');
      Route::get('/deal/quotes/{slug}/{offer_id}/details', 'dealQuotesDetails')->name('seller.offer.quote-deal');
      Route::post('/accept/counter-quote-offer', 'acceptCounterQuoteOffer')->name('seller.sender.accept-counter-quote');


      Route::get('/{quotation_id}/edit-quotation', 'editQuotation')->name('seller.edit.quotation');
      Route::post('/update-quotation', 'updateQuotation')->name('seller.update.quotation');
      Route::post('/deal/update-quotation', 'updateQuotationDealStatus')->name('seller.status.deal-quotation');
   });
});

Route::get('paypal/pay', [PayPalController::class, 'payWithPayPal'])->name('paypal.pay');
Route::get('paypal/status', [PayPalController::class, 'payPalStatus'])->name('paypal.status');
