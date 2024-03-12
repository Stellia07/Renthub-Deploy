<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\PropertyController;
use App\Http\Controllers\Owner\OwnerPropertyController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CompareController;
use App\Http\Controllers\Backend\DistrictController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\ChatController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PaymentLogController;
use App\Http\Controllers\LeaseController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// User Frontend All Route

//agreement
Route::get('/lease', [LeaseController::class, 'create'])->name('lease.form');
Route::post('/lease', [LeaseController::class, 'store'])->name('lease.submit');
Route::get('/view-contract/{tenant_email}', [LeaseController::class, 'viewContract'])->name('view.contract');
Route::get('/my-lease-agreement', [LeaseController::class, 'myLeaseAgreement'])->name('my.lease.agreement')->middleware('auth');
Route::get('/lease-agreement', [LeaseController::class, 'leaseAgreementForm'])->name('lease.agreement.form');


//Test submit 10/03/24 remove test
//Route::get('/submit-test', [TestController::class, 'create'])->name('test.create');
//Route::post('/submit-test', [TestController::class, 'store'])->name('test.store');

Route::post('/submit-tenant', [PropertyController::class, 'store'])->name('submit-tenant');

//payment_log
// Existing routes for creating and storing payment logs
Route::get('/payment-log/create', [PaymentLogController::class, 'create'])->name('payment-log.create');
Route::post('/payment-log/store', [PaymentLogController::class, 'store'])->name('payment-log.store');

// Route for displaying payment logs
Route::get('/payment-logs', [PaymentLogController::class, 'paymentLogs'])->name('payment-logs');
Route::get('/owner/payment-logs', [OwnerPropertyController::class, 'paymentLogs'])->name('owner.payment.logs');
Route::get('/pay', [PaymentLogController::class, 'createPay'])->name('pay');
Route::get('/payment-logs', [PaymentLogController::class, 'viewPaymentLogs'])->name('view-payment-logs');

//billings
Route::get('/electricity-billing', [OwnerPropertyController::class, 'showElectricity'])->name('electricity.billing');
Route::get('/water-billing', [OwnerPropertyController::class, 'showWater'])->name('water.billing');
Route::get('/rent-billing', [OwnerPropertyController::class, 'showRentBilling'])->name('rent.billing');



Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

Route::get('/', [UserController::class, 'Index']);

Route::get('/dashboard', function () {
	return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

	Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');

	// For updating user sa user dashboard
	Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');

	// For user logout
	Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');

	Route::get('/user-logout-owner-login', [UserController::class, 'logoutAndRedirectToOwnerLogin'])->name('user.logout.owner.login');

	// Change pass ng user
	Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');

	// For updating user password 
	Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');

	Route::get('/user/schedule/request', [UserController::class, 'UserScheduleRequest'])->name('user.schedule.request');

	Route::get('/live/chat', [UserController::class, 'LiveChat'])->name('live.chat');


	// User WishlistAll Route 
	Route::controller(WishlistController::class)->group(function () {

		Route::get('/user/wishlist', 'UserWishlist')->name('user.wishlist');
		Route::get('/get-wishlist-property', 'GetWishlistProperty');
		Route::get('/wishlist-remove/{id}', 'WishlistRemove');
	});


	// User Compare All Route 
	Route::controller(CompareController::class)->group(function () {

		Route::get('/user/compare', 'UserCompare')->name('user.compare');
		Route::get('/get-compare-property', 'GetCompareProperty');
		Route::get('/compare-remove/{id}', 'CompareRemove');
	});
});

require __DIR__ . '/auth.php';

// Admin Group Middleware, Need role = admin para ma-authenthicate
Route::middleware(['auth', 'role:admin'])->group(function () {

	Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');

	Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

	Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');

	Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');

	Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');

	Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
}); // Admin Middleware to


// Owner Group Middleware, Need role = owner para ma-authenthicate
Route::middleware(['auth', 'role:owner'])->group(function () {

	Route::get('/owner/dashboard', [OwnerController::class, 'OwnerDashboard'])->name('owner.dashboard');

	Route::get('/owner/logout', [OwnerController::class, 'OwnerLogout'])->name('owner.logout');

	Route::get('/owner/profile', [OwnerController::class, 'OwnerProfile'])->name('owner.profile');

	Route::post('/owner/profile/store', [OwnerController::class, 'OwnerProfileStore'])->name('owner.profile.store');

	Route::get('/owner/change/password', [OwnerController::class, 'OwnerChangePassword'])->name('owner.change.password');

	Route::post('/owner/update/password', [OwnerController::class, 'OwnerUpdatePassword'])->name('owner.update.password');
}); // Owner Middleware to
// Tenant Group Middleware, Need role = tenant to authenticate
Route::middleware(['auth', 'role:tenant'])->group(function () {
	Route::get('/tenant/dashboard', [TenantController::class, 'TenantDashboard'])->name('tenant.dashboard');
	Route::post('/tenant/logout', [TenantController::class, 'TenantLogout'])->name('tenant.logout');
	Route::get('/tenant/profile', [TenantController::class, 'TenantProfile'])->name('tenant.profile');
	Route::post('/tenant/profile/store', [TenantController::class, 'TenantProfileStore'])->name('tenant.profile.store');
	Route::get('/tenant/change/password', [TenantController::class, 'TenantChangePassword'])->name('tenant.change.password');
	Route::post('/tenant/update/password', [TenantController::class, 'TenantUpdatePassword'])->name('tenant.update.password');
	Route::post('/change-user-status/{email}', [TenantController::class, 'changeUserStatus'])->name('changeUserStatus');
}); // Tenant Middleware to
// new form for tenants


//test
// Route::get('/change-status', [UserController::class, 'showChangeStatusPage']);
// Route::post('/change-user-status', [UserController::class, 'changeUserStatus'])->name('changeUserStatus');

//end test


Route::get('/rent-now/{property_id}', [TenantController::class, 'showRentalForm'])->name('rental.form');
//submit button for tenant form
//Route::post('/submit-tenant', [TenantController::class, 'submitTenant'])->name('submit-tenant');
Route::post('/submit-tenant', [TenantController::class, 'storeTenant'])->name('submit-tenant');



//Owner manage Tenants from owner dashboard
Route::middleware(['auth'])->group(function () {
	Route::controller(OwnerPropertyController::class)->group(function () {
		Route::get('/owner/tenant/request', 'OwnerTenantRequest')->name('owner.tenant.request');
		Route::get('/owner/tenant/manager', 'OwnerTenantmanager')->name('owner.tenant.manager');
		Route::get('/owner/tenants', 'showTenants')->name('owner.tenants');
		Route::post('/tenant/accept/{tenant}', [TenantController::class, 'acceptTenant'])->name('tenant.accept');
		Route::post('/tenant/reject/{tenant}', [TenantController::class, 'rejectTenant'])->name('tenant.reject');
		Route::get('/my-tenant-info', [TenantController::class, 'showMyTenantInfo'])->name('tenant.myinfo')->middleware('auth');
		Route::get('/tenant/dashboard', [TenantController::class, 'TenantDashboard'])->name('tenant.dashboard')->middleware('auth');
		Route::post('/update-billing/{id}', [OwnerPropertyController::class, 'updateBilling'])->name('update.billing');
		Route::post('/update-water-billing/{id}', [OwnerPropertyController::class, 'updateWaterBilling'])->name('update.water.billing');
		Route::post('/update-rent-billing/{id}', [TenantController::class, 'updateRentBilling'])->name('update.rent.billing');
		Route::get('/owner/payment-logs', [OwnerPropertyController::class, 'paymentLogs'])->name('owner.payment.logs');
		

	});
});




Route::get('/owner/login', [OwnerController::class, 'OwnerLogin'])->name('owner.login')->middleware(RedirectIfAuthenticated::class);

Route::post('/owner/register', [OwnerController::class, 'OwnerRegister'])->name('owner.register');

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login')->middleware(RedirectIfAuthenticated::class);


// Property Type All property route
Route::middleware(['auth', 'role:admin'])->group(function () {

	Route::controller(PropertyTypeController::class)->group(function () {

		Route::get('/all/type', 'ALLType')->name('all.type');
		Route::get('/add/type', 'ADDType')->name('add.type');
		Route::post('/store/type', 'StoreType')->name('store.type');
		Route::get('/edit/type/{id}', 'EditType')->name('edit.type');
		Route::post('/update/type', 'UpdateType')->name('update.type');
		Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type');
	});

	// Para sa Amenity
	Route::controller(PropertyTypeController::class)->group(function () {

		Route::get('/all/amenity', 'ALLAmenity')->name('all.amenity');
		Route::get('/add/amenity', 'ADDAmenity')->name('add.amenity');
		Route::post('/store/amenities', 'StoreAmenities')->name('store.amenities');
		Route::get('/edit/amenity/{id}', 'EditAmenity')->name('edit.amenity');
		Route::post('/update/amenities', 'UpdateAmenities')->name('update.amenities');
		Route::get('/delete/amenity/{id}', 'DeleteAmenity')->name('delete.amenity');
	});

	// Para sa Property routes
	Route::controller(PropertyController::class)->group(function () {

		Route::get('/all/property', 'AllProperty')->name('all.property');
		Route::get('/add/property', 'AddProperty')->name('add.property');
		Route::post('/store/property', 'StoreProperty')->name('store.property');
		Route::get('/edit/property/{id}', 'EditProperty')->name('edit.property');
		Route::post('/update/property', 'UpdateProperty')->name('update.property');
		Route::post('/update/property/thumbnail', 'UpdatePropertyThumbnail')->name('update.property.thumbnail');

		Route::post('/update/property/multiimage', 'UpdatePropertyMultiimage')->name('update.property.multiimage');

		Route::get('/property/multiimg/delete/{id}', 'PropertyMultiImageDelete')->name('property.multiimg.delete');

		Route::post('/store/new/multiimage', 'StoreNewMultiimage')->name('store.new.multiimage');

		Route::post('/update/property/facilities', 'UpdatePropertyFacilities')->name('update.property.facilities');

		Route::post('/update/property/risks', 'UpdatePropertyRisks')->name('update.property.risks');

		Route::get('/delete/property/{id}', 'DeleteProperty')->name('delete.property');

		Route::get('/details/property/{id}', 'DetailsProperty')->name('details.property');

		Route::post('/inactive/property', 'InactiveProperty')->name('inactive.property');

		Route::post('/active/property', 'ActiveProperty')->name('active.property');

		Route::get('/admin/package/history', 'AdminPackageHistory')->name('admin.package.history');

		Route::get('/package/invoice/{id}', 'PackageInvoice')->name('package.invoice');

		Route::get('/admin/property/message/', 'AdminPropertyMessage')->name('admin.property.message');
	});

	// Owner All Route from admin 
	Route::controller(AdminController::class)->group(function () {

		Route::get('/all/owner', 'AllOwner')->name('all.owner');
		Route::get('/add/owner', 'AddOwner')->name('add.owner');
		Route::post('/store/owner', 'StoreOwner')->name('store.owner');
		Route::get('/edit/owner/{id}', 'EditOwner')->name('edit.owner');
		Route::post('/update/owner', 'UpdateOwner')->name('update.owner');
		Route::get('/delete/owner/{id}', 'DeleteOwner')->name('delete.owner');


		Route::get('/changeStatus', 'changeStatus');
	});

	// District  All Route 
	Route::controller(DistrictController::class)->group(function () {

		Route::get('/all/district', 'AllDistrict')->name('all.district');
		Route::get('/add/district', 'AddDistrict')->name('add.district');
		Route::post('/store/district', 'StoreDistrict')->name('store.district');
		Route::get('/edit/district/{id}', 'EditDistrict')->name('edit.district');
		Route::post('/update/district', 'UpdateDistrict')->name('update.district');
		Route::get('/delete/district/{id}', 'DeleteDistrict')->name('delete.district');
	});

	// Testimonials  All Route 
	Route::controller(TestimonialController::class)->group(function () {

		Route::get('/all/testimonials', 'AllTestimonials')->name('all.testimonials');
		Route::get('/add/testimonials', 'AddTestimonials')->name('add.testimonials');
		Route::post('/store/testimonials', 'StoreTestimonials')->name('store.testimonials');
		Route::get('/edit/testimonials/{id}', 'EditTestimonials')->name('edit.testimonials');
		Route::post('/update/testimonials', 'UpdateTestimonials')->name('update.testimonials');
		Route::get('/delete/testimonials/{id}', 'DeleteTestimonials')->name('delete.testimonials');
	});


	// SMTP Setting  All Route 
	Route::controller(SettingController::class)->group(function () {

		Route::get('/smtp/setting', 'SmtpSetting')->name('smtp.setting');
		Route::post('/update/smpt/setting', 'UpdateSmtpSetting')->name('update.smpt.setting');
	});

	// Site Setting  All Route 
	Route::controller(SettingController::class)->group(function(){

		Route::get('/site/setting', 'SiteSetting')->name('site.setting');
		Route::post('/update/site/setting', 'UpdateSiteSetting')->name('update.site.setting');   

	});

	// Permission all route
	Route::controller(RoleController::class)->group(function () {

		Route::get('/all/permission', 'AllPermission')->name('all.permission'); 
		Route::get('/add/permission', 'AddPermission')->name('add.permission');
		Route::post('/store/permission', 'StorePermission')->name('store.permission'); 
		Route::get('/edit/type/{id}', 'EditType')->name('edit.type');
		Route::post('/update/type', 'UpdateType')->name('update.type');
		Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type');
	});

}); // Admin Middleware to


/// Owner Group Middleware 
Route::middleware(['auth', 'role:owner'])->group(function () {

	// Owner All Property  
	Route::controller(OwnerPropertyController::class)->group(function () {

		Route::get('/owner/all/property', 'OwnerAllProperty')->name('owner.all.property');

		Route::get('/owner/add/property', 'OwnerAddProperty')->name('owner.add.property');

		Route::post('/owner/store/property', 'OwnerStoreProperty')->name('owner.store.property');

		Route::get('/owner/edit/property/{id}', 'OwnerEditProperty')->name('owner.edit.property');

		Route::post('/owner/update/property', 'OwnerUpdateProperty')->name('owner.update.property');

		Route::post('/owner/update/property/thumbnail', 'OwnerUpdatePropertyThumbnail')->name('owner.update.property.thumbnail');

		Route::post('/owner/update/property/multiimage', 'OwnerUpdatePropertyMultiimage')->name('owner.update.property.multiimage');

		Route::get('/owner/property/multiimg/delete/{id}', 'OwnerPropertyMultiimageDelete')->name('owner.property.multiimg.delete');

		Route::post('/owner/store/new/multiimage', 'OwnerStoreNewMultiimage')->name('owner.store.new.multiimage');

		Route::post('/owner/update/property/facility', 'OwnerUpdatePropertyFacility')->name('owner.update.property.facilities');

		Route::post('/owner/update/property/risks', 'OwnerUpdatePropertyRisks')->name('owner.update.property.risks');

		Route::get('/owner/details/property/{id}', 'OwnerDetailsProperty')->name('owner.details.property');

		Route::get('/owner/delete/property/{id}', 'OwnerDeleteProperty')->name('owner.delete.property');

		Route::get('/owner/property/message/', 'OwnerPropertyMessage')->name('owner.property.message');

		Route::get('/owner/message/details/{id}', 'OwnerMessageDetails')->name('owner.message.details');

		Route::get('/owner/schedule/request/', 'OwnerScheduleRequest')->name('owner.schedule.request');

		Route::get('/owner/details/request/{id}', 'OwnerDetailsSchedule')->name('owner.details.schedule');

		Route::post('/owner/update/schedule/', 'OwnerUpdateSchedule')->name('owner.update.schedule');
	});

	// Owner Buy Package Route from admin 
	Route::controller(OwnerPropertyController::class)->group(function () {

		Route::get('/buy/package', 'BuyPackage')->name('buy.package');
		Route::get('/buy/business/plan', 'BuyBusinessPlan')->name('buy.business.plan');
		Route::post('/store/business/plan', 'StoreBusinessPlan')->name('store.business.plan');

		Route::get('/buy/professional/plan', 'BuyProfessionalPlan')->name('buy.professional.plan');
		Route::post('/store/professional/plan', 'StoreProfessionalPlan')->name('store.professional.plan');


		Route::get('/package/history', 'PackageHistory')->name('package.history');
		Route::get('/owner/package/invoice/{id}', 'OwnerPackageInvoice')->name('owner.package.invoice');
	});
}); // End Group Owner Middleware


// Frontend Property Details All User Route 

Route::get('/property/details/{id}/{slug}', [IndexController::class, 'PropertyDetails']);

// Wishlist Add Route 
Route::post('/add-to-wishList/{property_id}', [WishlistController::class, 'AddToWishList']);

// Compare Add Route 
Route::post('/add-to-compare/{property_id}', [CompareController::class, 'AddToCompare']);

// Send Message from Property Details Page 
Route::post('/property/message', [IndexController::class, 'PropertyMessage'])->name('property.message');

// Owner Details Page in Frontend 
Route::get('/owner/details/{id}', [IndexController::class, 'OwnerDetails'])->name('owner.details');

// Send Message from Owner Details Page 
Route::post('/owner/details/message', [IndexController::class, 'OwnerDetailsMessage'])->name('owner.details.message');

// Get All Rent Property 
Route::get('/rent/property', [IndexController::class, 'RentProperty'])->name('rent.property');

// Get All Property Type Data 
Route::get('/property/type/{id}', [IndexController::class, 'PropertyType'])->name('property.type');

// Home Page rent Seach Option
Route::post('/rent/property/search', [IndexController::class, 'RentPropertySeach'])->name('rent.property.search');

// Home Page all Seach Option
Route::post('/all/property/search', [IndexController::class, 'AllPropertySeach'])->name('all.property.search');

// Schedule Message Request Route 
Route::post('/store/schedule', [IndexController::class, 'StoreSchedule'])->name('store.schedule');

// Chat Post Request Route 
Route::post('/send-message', [ChatController::class, 'SendMsg'])->name('send.msg');

Route::get('/user-all', [ChatController::class, 'GetAllUsers']);

Route::get('/user-message/{id}', [ChatController::class, 'UserMsgById']);

Route::get('/owner/live/chat', [ChatController::class, 'OwnerLiveChat'])->name('owner.live.chat');
