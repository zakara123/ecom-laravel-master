<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\HomePageComponentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\BillController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\QuotesController;
use App\Http\Controllers\BankingController;
use App\Http\Controllers\NewSaleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PatientController;

use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PettyCashController;
use App\Http\Controllers\HeaderMenuController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\AutoCompleteController;
use App\Http\Controllers\BillsPaymentController;
//use App\Http\Controllers\HomeCarouselController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\stockHistoryController;
use App\Http\Controllers\SalesPaymentsController;
use App\Http\Controllers\RentalsPaymentsController;
use App\Http\Controllers\AppointmentsPaymentsController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\OnlineStockApiController;
use App\Http\Controllers\ProductSettingsController;
use App\Http\Controllers\ProductVariationController;
use App\Http\Controllers\PayementMethodSalesController;
use App\Http\Controllers\HomepageCollectionImageController;
use App\Http\Controllers\MRAController;
use App\Http\Controllers\DetailAppointmentController;
use App\Http\Controllers\PeachPaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('peach-payment.php', [PeachPaymentController::class, 'processPayment']);
Route::post('save-peach-payment/{id}', [PeachPaymentController::class, 'returnPeachPayment'])->name('save-peach-payment');



// Home page routes
Route::get('/', [WebController::class, 'index'])->name('online_shop');
Route::get('/shop', [WebController::class, 'shop'])->name('shop');
Route::post('/', [WebController::class, 'filter'])->name('online_shop_filter');

// Cart routes
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/add-cart', [CartController::class, 'addCart'])->name('add-cart');
Route::get('/delete-cart/{id}', [CartController::class, 'delete_cart'])->name('delete-cart');
Route::get('/delete-cart-ajax/{id}', [CartController::class, 'delete_cart_ajax'])->name('delete-cart-ajax');
Route::get('/empty-cart', [CartController::class, 'empty_cart'])->name('empty-cart');

Route::get('/product/{id}', [ProductController::class, 'getProductBySlug'])->name('product');

Route::get('/product-details/{productId}/{storeId}', [ProductController::class, 'getProductDetails'])->name('product-details');

Route::get('/category/{id}', [CategoryController::class, 'category'])->name('category-product');
Route::get('/attributes/{main}/{sub}', [AttributeValueController::class, 'attribute'])->name('attributes-product');
Route::post('/product-attributes', [ProductAttributeController::class, 'store'])->name('product_attributes.store');

Route::post('/order-confirmation', [SalesController::class, 'saveFrontSale'])->name('order-confirmation');
Route::get('/save-mcb-payment/{id}', [SalesController::class, 'mcb_payment'])->name('save-mcb-payment');
Route::get('/save-mcb-payement-view/{id}', [SalesController::class, 'mcb_payement_view'])->name('save-mcb-payement-view');
Route::get('/detail-sale/{id}', [SalesController::class, 'details'])->name('detail-sale');
Route::get('/detail-quote/{id}', [QuotesController::class, 'details'])->name('detail-quote');
Route::get('/resend-email/{id}', [SalesController::class, 'resend_email'])->name('resend-email');
Route::get('/detail-bill/{id}', [BillController::class, 'details'])->name('detail-bill');
Route::get('/product-variation/{id}', [ProductVariationController::class, 'index'])->name('product-variation');
Route::get('/product-stock/{id}', [StockController::class, 'index'])->name('product-stock');
Route::get('/get_product_variations/{id}', [StockController::class, 'get_product_variations'])->name('get_product_variations');
Route::get('/stock-sheets', [StockController::class, 'stock_sheet'])->name('stock-sheets');
Route::get('/rental-submissions', [SubmissionController::class, 'index'])->name('rental-submissions');
Route::get('/export-rental/{id}', [PdfController::class, 'pdf_rental'])->middleware(['auth', 'verified'])->name('export-rental');
Route::get('/export-rental-proforma/{id}', [PdfController::class, 'pdf_rental_proforma'])->middleware(['auth', 'verified'])->name('export-rental-proforma');
Route::get('/export-appointment/{id}', [PdfController::class, 'pdf_appointment'])->middleware(['auth', 'verified'])->name('export-appointment');
Route::get('/export-appointment-proforma/{id}', [PdfController::class, 'pdf_appointment_proforma'])->middleware(['auth', 'verified'])->name('export-appointment-proforma');

//Route::get('/rental-pending-amount-pdf/{id}', [PdfController::class, 'update_item_submission_amount'])->middleware(['auth', 'verified'])->name('rental-pending-amount-pdf');

Route::get('/rental-pending-amount-pdf/{id}', [SubmissionController::class, 'pdf_rental_pending_amount'])->middleware(['auth', 'verified'])->name('rental-pending-amount-pdf');

Route::post('/product/{id}/update-variable-status', [ProductsController::class, 'updateVariableStatus']);

Route::put('/submissions/update_customer/{id}', [SubmissionController::class, 'updateCustomer'])->name('submissions.update_customer');


Route::get('/submission-sales', [SubmissionController::class, 'search'])->name('submission-sales');

Route::put('/submissions_update_order_reference/{id}', [SubmissionController::class, 'update_order_reference'])->middleware(['auth', 'verified'])->name('submissions_update_order_reference');
//Route::put('update_bill_reference/{id}', [BillController::class, 'update_bill_reference'])->middleware(['auth', 'verified'])->name('bills.update_bill_reference');
Route::put('/submissions/update_payment_method/{id}', [SubmissionController::class, 'update_payment_method'])->middleware(['auth', 'verified'])->name('submissions.update_payment_method');


Route::get('/detail-rental/{id}', [SubmissionController::class, 'details'])->name('detail-rental');
Route::post('/add-rental-submission', [SubmissionController::class, 'add_product_rental'])->name('add-rental-submission');

// Appointment Routes
Route::post('/add-appointment-request', [AppointmentController::class, 'createAppointmentRequest'])->name('create-appointment-request');
Route::post('/send-contact-us', [AppointmentController::class, 'sendContactUs'])->name('send-contact-us');

Route::get('/appointment-request', [DashboardController::class, 'appointmentRequest'])->name('appointment-request');

//Protected routes
Route::middleware(['auth', 'verified'])->group(function () {

    //Appointments
    Route::put('/appointment_update_order_reference/{id}', [AppointmentController::class, 'update_order_reference'])->name('appointment_update_order_reference');

    Route::get('/appointment-lists', [AppointmentController::class, 'index'])->name('appointment-lists');
    Route::get('/appointment-search', [AppointmentController::class, 'search'])->name('appointment-search');

    Route::get('/detail-appointment/{id}', [AppointmentController::class, 'details'])->name('detail-appointment');

    Route::post('/appointment-update/{id}', [AppointmentController::class, 'appointment_update'])->name('appointment-update');
    Route::put('/appointment-doctor-assign/{id}', [AppointmentController::class, 'appointment_doctor_assign'])->name('appointment-doctor-assign');
    Route::put('/update-appointment-comment/{id}', [AppointmentController::class, 'update_appointment_comment'])->name('update-appointment-comment');
    Route::post('/appointment-add-sale-files', [AppointmentController::class, 'add_sale_files'])->name('appointment-add-sale-files');
    Route::put('/appointments/update_customer/{id}', [AppointmentController::class, 'updateCustomer'])->name('appointments.update_customer');

    //Route::PUT('/appointment-update/{id}', [AppointmentController::class, 'appointment_update'])->name('appointment-update');

    Route::delete('destroy-appointment/{id}', [AppointmentController::class, 'destroy_appointment'])->name('destroy_appointment');

    Route::post('/add-new-item-appointment/{id}', [AppointmentController::class, 'add_item_appointment'])->name('add-new-item-appointment');
    Route::post('/update-item-appointment/{id}', [AppointmentController::class, 'update_item_appointment'])->name('update-item-appointment');
    Route::delete('/destroy_appointment_item/{id}', [AppointmentController::class, 'destroy_appointment_item'])->name('destroy_appointment_item');

    Route::get('/appointment-pending-amount-pdf/{id}', [AppointmentController::class, 'pdf_appointment_pending_amount'])->name('appointment-pending-amount-pdf');
    Route::prefix('detail-appointment')->group(function () {
        Route::get('/presenting-complaints/{appointmentId}', [DetailAppointmentController::class, 'presentingComplaints'])->name('detail-appointment.presenting-complaints');
        Route::post('/presenting-complaints/{appointmentId}', [DetailAppointmentController::class, 'storePresentingComplaints'])->name('presenting-complaints.store');

        Route::get('/vitals/{appointmentId}', [DetailAppointmentController::class, 'vitals'])->name('detail-appointment.vitals');
        Route::post('/vitals/{appointmentId}', [DetailAppointmentController::class, 'storeVitals'])->name('vitals.store');

        Route::get('/physical-examination/{appointmentId}', [DetailAppointmentController::class, 'physicalExamination'])->name('detail-appointment.physical-examination');
        Route::post('/physical-examination/{appointmentId}', [DetailAppointmentController::class, 'storePhysicalExamination'])->name('physical-examination.store');

        Route::get('/medical-advice/{appointmentId}', [DetailAppointmentController::class, 'medicalAdvice'])->name('detail-appointment.medical-advice');
        Route::post('/medical-advice/{appointmentId}', [DetailAppointmentController::class, 'storeMedicalAdvice'])->name('medical-advice.store');

        Route::get('/medvigilance/{appointmentId}', [DetailAppointmentController::class, 'medVigilance'])->name('detail-appointment.medvigilance');
        Route::post('/med-vigilance/{appointmentId}', [DetailAppointmentController::class, 'storeMedVigilance'])->name('med-vigilance.store');

        Route::get('/diagnosis/{appointmentId}', [DetailAppointmentController::class, 'diagnosis'])->name('detail-appointment.diagnosis');
        Route::post('/diagnosis/{appointmentId}', [DetailAppointmentController::class, 'storeDiagnosis'])->name('diagnosis.store');

        Route::post('/end-consultation', [DetailAppointmentController::class, 'endConsultation'])->name('appointment.end-consultation');
    });

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles.permissions', RolePermissionController::class);

    Route::get('/file-manager/all-files', [FileManagerController::class, 'getFiles'])->name('file-manager.all-files');
    Route::resource('file-manager', FileManagerController::class);
});
Route::get('/appointment/{id}/generate-pdf', [AppointmentController::class, 'generateAppointmentPDF'])->name('appointment.generate-pdf');
Route::get('/patient-details/{id}', [PatientController::class, 'patient_details'])->middleware(['auth', 'verified'])->name('patient-details');
Route::get('/medical-record/{id}', [PatientController::class, 'patient_edit'])->middleware(['auth', 'verified'])->name('medical-record');
Route::PUT('/patient-update/{id}', [PatientController::class, 'update'])->middleware(['auth', 'verified'])->name('patient-update');

Route::get('/patient-past-medication/{id}', [PatientController::class, 'patient_past_medication'])->middleware(['auth', 'verified'])->name('patient-past-medication');
Route::get('/add-patient-past-medication/{id}', [PatientController::class, 'add_patient_past_medication'])->middleware(['auth', 'verified'])->name('add-patient-past-medication');
Route::PUT('/save-patient-past-medician/{id}', [PatientController::class, 'save_patient_past_medication'])->middleware(['auth', 'verified'])->name('save-patient-past-medician');

Route::get('/edit-patient-past-medication/{id}/{recordId}', [PatientController::class, 'edit_patient_past_medication'])->middleware(['auth', 'verified'])->name('edit-patient-past-medication');
Route::get('/view-patient-past-medication/{id}/{recordId}', [PatientController::class, 'view_patient_past_medication'])->middleware(['auth', 'verified'])->name('view-patient-past-medication');

Route::get('/patient-current-medication/{id}', [PatientController::class, 'patient_current_medication'])->middleware(['auth', 'verified'])->name('patient-current-medication');
Route::get('/edit-patient-current-medication/{id}/{recordId}', [PatientController::class, 'edit_patient_current_medication'])->middleware(['auth', 'verified'])->name('edit-patient-current-medication');
Route::get('/view-patient-current-medication/{id}/{recordId}', [PatientController::class, 'view_patient_current_medication'])->middleware(['auth', 'verified'])->name('view-patient-current-medication');

Route::get('/add-patient-current-medication/{id}', [PatientController::class, 'add_patient_current_medication'])->middleware(['auth', 'verified'])->name('add-patient-current-medication');
Route::PUT('/save-patient-current-medician/{id}', [PatientController::class, 'save_patient_current_medication'])->middleware(['auth', 'verified'])->name('save-patient-current-medician');


Route::get('/patient-immunization/{id}', [PatientController::class, 'patient_immunization'])->middleware(['auth', 'verified'])->name('patient-immunization');
Route::get('/edit-patient-immunization/{id}/{recordId}', [PatientController::class, 'edit_patient_immunization'])->middleware(['auth', 'verified'])->name('edit-patient-immunization');
Route::get('/view-patient-immunization/{id}/{recordId}', [PatientController::class, 'view_patient_immunization'])->middleware(['auth', 'verified'])->name('view-patient-immunization');

Route::get('/add-patient-immunization/{id}', [PatientController::class, 'add_patient_immunization'])->middleware(['auth', 'verified'])->name('add-patient-immunization');
Route::PUT('/save-patient-immunization/{id}', [PatientController::class, 'save_patient_immunization'])->middleware(['auth', 'verified'])->name('save-patient-immunization');
Route::PUT('/edit-save-patient-immunization/{id}/{recordId}', [PatientController::class, 'edit_save_patient_immunization'])->middleware(['auth', 'verified'])->name('edit-save-patient-immunization');




Route::get('/patient-current-dietary-supplements/{id}', [PatientController::class, 'patient_current_dietary_supplement'])->middleware(['auth', 'verified'])->name('patient-current-dietary-supplements');
Route::get('/edit-patient-current-dietary-supplements/{id}/{recordId}', [PatientController::class, 'edit_patient_current_dietary_supplement'])->middleware(['auth', 'verified'])->name('edit-patient-current-dietary-supplements');
Route::get('/view-patient-current-dietary-supplements/{id}/{recordId}', [PatientController::class, 'view_patient_current_dietary_supplement'])->middleware(['auth', 'verified'])->name('view-patient-current-dietary-supplements');
Route::get('/add-patient-current-dietary-supplements/{id}', [PatientController::class, 'add_patient_current_dietary_supplement'])->middleware(['auth', 'verified'])->name('add-patient-current-dietary-supplements');
Route::PUT('/save-patient-current-dietary-supplements/{id}', [PatientController::class, 'save_patient_current_dietary_supplement'])->middleware(['auth', 'verified'])->name('save-patient-current-dietary-supplements');
Route::PUT('/edit-save-patient-dietary-supplements/{id}/{recordId}', [PatientController::class, 'edit_save_patient_current_dietary_supplement'])->middleware(['auth', 'verified'])->name('edit-save-patient-dietary-supplements');




Route::get('/patient-home-medical-equipment/{id}', [PatientController::class, 'patient_home_medical_equipment'])->middleware(['auth', 'verified'])->name('patient-home-medical-equipment');
Route::get('/edit-patient-home-medical-equipment/{id}/{recordId}', [PatientController::class, 'edit_patient_home_medical_equipment'])->middleware(['auth', 'verified'])->name('edit-patient-home-medical-equipment');
Route::get('/view-patient-home-medical-equipment/{id}/{recordId}', [PatientController::class, 'view_patient_home_medical_equipment'])->middleware(['auth', 'verified'])->name('view-patient-home-medical-equipment');
Route::get('/add-patient-home-medical-equipment/{id}', [PatientController::class, 'add_patient_home_medical_equipment'])->middleware(['auth', 'verified'])->name('add-patient-home-medical-equipment');
Route::PUT('/save-patient-home-medical-equipment/{id}', [PatientController::class, 'save_patient_home_medical_equipment'])->middleware(['auth', 'verified'])->name('save-patient-home-medical-equipment');
Route::PUT('/edit-save-patient-home-medical-equipment/{id}/{recordId}', [PatientController::class, 'edit_save_patient_home_medical_equipment'])->middleware(['auth', 'verified'])->name('edit-save-patient-home-medical-equipment');





Route::get('/patient-emergency-contact/{id}', [PatientController::class, 'patient_emergency_contact'])->middleware(['auth', 'verified'])->name('patient-emergency-contact');
Route::get('/edit-patient-emergency-contact/{id}/{recordId}', [PatientController::class, 'edit_patient_emergency_contact'])->middleware(['auth', 'verified'])->name('edit-patient-emergency-contact');
Route::get('/add-patient-emergency-contact/{id}', [PatientController::class, 'add_patient_emergency_contact'])->middleware(['auth', 'verified'])->name('add-patient-emergency-contact');
Route::PUT('/save-patient-emergency-contact/{id}', [PatientController::class, 'save_patient_emergency_contact'])->middleware(['auth', 'verified'])->name('save-patient-emergency-contact');
Route::PUT('/edit-save-patient-emergency-contact/{id}/{recordId}', [PatientController::class, 'edit_save_patient_emergency_contact'])->middleware(['auth', 'verified'])->name('edit-save-patient-emergency-contact');
Route::get('/view-patient-emergency-contact/{id}/{recordId}', [PatientController::class, 'view_patient_emergency_contact'])->middleware(['auth', 'verified'])->name('view-patient-emergency-contact');


Route::get('/patient-hospitalization/{id}', [PatientController::class, 'patient_hospitalization'])->middleware(['auth', 'verified'])->name('patient-hospitalization');
Route::get('/edit-patient-hospitalization/{id}/{recordId}', [PatientController::class, 'edit_patient_hospitalization'])->middleware(['auth', 'verified'])->name('edit-patient-hospitalization');
Route::get('/view-patient-hospitalization/{id}/{recordId}', [PatientController::class, 'view_patient_hospitalization'])->middleware(['auth', 'verified'])->name('view-patient-hospitalization');
Route::get('/add-patient-hospitalization/{id}', [PatientController::class, 'add_patient_hospitalization'])->middleware(['auth', 'verified'])->name('add-patient-hospitalization');
Route::PUT('/save-patient-hospitalization/{id}', [PatientController::class, 'save_patient_hospitalization'])->middleware(['auth', 'verified'])->name('save-patient-hospitalization');
Route::PUT('/edit-save-patient-hospitalization/{id}/{recordId}', [PatientController::class, 'edit_save_patient_hospitalization'])->middleware(['auth', 'verified'])->name('edit-save-patient-hospitalization');



Route::get('/patient-insurance/{id}', [PatientController::class, 'patient_insurance'])->middleware(['auth', 'verified'])->name('patient-insurance');
Route::get('/edit-patient-insurance/{id}/{recordId}', [PatientController::class, 'edit_patient_insurance'])->middleware(['auth', 'verified'])->name('edit-patient-insurance');
Route::get('/view-patient-insurance/{id}/{recordId}', [PatientController::class, 'view_patient_insurance'])->middleware(['auth', 'verified'])->name('view-patient-insurance');
Route::get('/add-patient-insurance/{id}', [PatientController::class, 'add_patient_insurance'])->middleware(['auth', 'verified'])->name('add-patient-insurance');
Route::PUT('/save-patient-insurance/{id}', [PatientController::class, 'save_patient_insurance'])->middleware(['auth', 'verified'])->name('save-patient-insurance');
Route::PUT('/edit-save-patient-insurance/{id}/{recordId}', [PatientController::class, 'edit_save_patient_insurance'])->middleware(['auth', 'verified'])->name('edit-save-patient-insurance');


Route::get('/patient-implanted-devices/{id}', [PatientController::class, 'patient_implanted_devices'])->middleware(['auth', 'verified'])->name('patient-implanted-devices');
Route::get('/edit-patient-implanted-devices/{id}/{recordId}', [PatientController::class, 'edit_patient_implanted_devices'])->middleware(['auth', 'verified'])->name('edit-patient-implanted-devices');
Route::get('/view-patient-implanted-devices/{id}/{recordId}', [PatientController::class, 'view_patient_implanted_devices'])->middleware(['auth', 'verified'])->name('view-patient-implanted-devices');
Route::get('/add-patient-implanted-devices/{id}', [PatientController::class, 'add_patient_implanted_devices'])->middleware(['auth', 'verified'])->name('add-patient-implanted-devices');
Route::PUT('/save-patient-implanted-devices/{id}', [PatientController::class, 'save_patient_implanted_devices'])->middleware(['auth', 'verified'])->name('save-patient-implanted-devices');
Route::PUT('/edit-save-patient-implanted-devices/{id}/{recordId}', [PatientController::class, 'edit_save_patient_implanted_devices'])->middleware(['auth', 'verified'])->name('edit-save-patient-implanted-devices');

Route::get('/patient-medical-aids/{id}', [PatientController::class, 'patient_medical_aids'])->middleware(['auth', 'verified'])->name('patient-medical-aids');
Route::get('/edit-patient-medical-aids/{id}/{recordId}', [PatientController::class, 'edit_patient_medical_aids'])->middleware(['auth', 'verified'])->name('edit-patient-medical-aids');
Route::get('/view-patient-medical-aids/{id}/{recordId}', [PatientController::class, 'view_patient_medical_aids'])->middleware(['auth', 'verified'])->name('view-patient-medical-aids');

Route::get('/add-patient-medical-aids/{id}', [PatientController::class, 'add_patient_medical_aids'])->middleware(['auth', 'verified'])->name('add-patient-medical-aids');
Route::PUT('/save-patient-medical-aids/{id}', [PatientController::class, 'save_patient_medical_aids'])->middleware(['auth', 'verified'])->name('save-patient-medical-aids');
Route::PUT('/edit-save-patient-medical-aids/{id}/{recordId}', [PatientController::class, 'edit_save_patient_medical_aids'])->middleware(['auth', 'verified'])->name('edit-save-patient-medical-aids');



Route::get('/patient-family-history/{id}', [PatientController::class, 'patient_family_history'])->middleware(['auth', 'verified'])->name('patient-family-history');
Route::get('/edit-patient-family-history/{id}/{recordId}', [PatientController::class, 'edit_patient_family_history'])->middleware(['auth', 'verified'])->name('edit-patient-family-history');
Route::get('/add-patient-family-history/{id}', [PatientController::class, 'add_patient_family_history'])->middleware(['auth', 'verified'])->name('add-patient-family-history');
Route::PUT('/save-patient-family-history/{id}', [PatientController::class, 'save_patient_family_history'])->middleware(['auth', 'verified'])->name('save-patient-family-history');
Route::PUT('/edit-save-patient-family-history/{id}/{recordId}', [PatientController::class, 'edit_save_patient_family_history'])->middleware(['auth', 'verified'])->name('edit-save-patient-family-history');
Route::get('/view-patient-family-history/{id}/{recordId}', [PatientController::class, 'edit_patient_family_history'])->middleware(['auth', 'verified'])->name('view-patient-family-history');


Route::get('/patient-alter-therapy/{id}', [PatientController::class, 'patient_alter_therapy'])->middleware(['auth', 'verified'])->name('patient-alter-therapy');
Route::get('/edit-patient-alter-therapy/{id}/{recordId}', [PatientController::class, 'edit_patient_alter_therapy'])->middleware(['auth', 'verified'])->name('edit-patient-alter-therapy');
Route::get('/add-patient-alter-therapy/{id}', [PatientController::class, 'add_patient_alter_therapy'])->middleware(['auth', 'verified'])->name('add-patient-alter-therapy');
Route::PUT('/save-patient-alter-therapy/{id}', [PatientController::class, 'save_patient_alter_therapy'])->middleware(['auth', 'verified'])->name('save-patient-alter-therapy');
Route::PUT('/edit-save-patient-alter-therapy/{id}/{recordId}', [PatientController::class, 'edit_save_patient_alter_therapy'])->middleware(['auth', 'verified'])->name('edit-save-patient-alter-therapy');
Route::get('/view-patient-alter-therapy/{id}/{recordId}', [PatientController::class, 'view_patient_alter_therapy'])->middleware(['auth', 'verified'])->name('view-patient-alter-therapy');


Route::get('/patient-physio-rehab/{id}', [PatientController::class, 'patient_physio_rehab'])->middleware(['auth', 'verified'])->name('patient-physio-rehab');
Route::get('/edit-patient-physio-rehab/{id}/{recordId}', [PatientController::class, 'edit_patient_physio_rehab'])->middleware(['auth', 'verified'])->name('edit-patient-physio-rehab');
Route::get('/view-patient-physio-rehab/{id}/{recordId}', [PatientController::class, 'view_patient_physio_rehab'])->middleware(['auth', 'verified'])->name('view-patient-physio-rehab');
Route::get('/add-patient-physio-rehab/{id}', [PatientController::class, 'add_patient_physio_rehab'])->middleware(['auth', 'verified'])->name('add-patient-physio-rehab');
Route::PUT('/save-patient-physio-rehab/{id}', [PatientController::class, 'save_patient_physio_rehab'])->middleware(['auth', 'verified'])->name('save-patient-physio-rehab');
Route::PUT('/edit-save-patient-physio-rehab/{id}/{recordId}', [PatientController::class, 'edit_save_patient_physio_rehab'])->middleware(['auth', 'verified'])->name('edit-save-patient-physio-rehab');


Route::get('/patient-opd-visits/{id}', [PatientController::class, 'patient_opd_visits'])->middleware(['auth', 'verified'])->name('patient-opd-visits');
Route::get('/edit-patient-opd-visits/{id}/{recordId}', [PatientController::class, 'edit_patient_opd_visits'])->middleware(['auth', 'verified'])->name('edit-patient-opd-visits');
Route::get('/view-patient-opd-visits/{id}/{recordId}', [PatientController::class, 'view_patient_opd_visits'])->middleware(['auth', 'verified'])->name('view-patient-opd-visits');
Route::get('/add-patient-opd-visits/{id}', [PatientController::class, 'add_patient_opd_visits'])->middleware(['auth', 'verified'])->name('add-patient-opd-visits');
Route::PUT('/save-patient-opd-visits/{id}', [PatientController::class, 'save_patient_opd_visits'])->middleware(['auth', 'verified'])->name('save-patient-opd-visits');
Route::PUT('/edit-save-patient-opd-visits/{id}/{recordId}', [PatientController::class, 'edit_save_patient_opd_visits'])->middleware(['auth', 'verified'])->name('edit-save-patient-opd-visits');


Route::get('/patient-physicians/{id}', [PatientController::class, 'patient_physicians'])->middleware(['auth', 'verified'])->name('patient-physicians');
Route::get('/edit-patient-physicians/{id}/{recordId}', [PatientController::class, 'edit_patient_physicians'])->middleware(['auth', 'verified'])->name('edit-patient-physicians');
Route::get('/view-patient-physicians/{id}/{recordId}', [PatientController::class, 'view_patient_physicians'])->middleware(['auth', 'verified'])->name('view-patient-physicians');
Route::get('/add-patient-physicians/{id}', [PatientController::class, 'add_patient_physicians'])->middleware(['auth', 'verified'])->name('add-patient-physicians');
Route::PUT('/save-patient-physicians/{id}', [PatientController::class, 'save_patient_physicians'])->middleware(['auth', 'verified'])->name('save-patient-physicians');
Route::PUT('/edit-save-patient-physicians/{id}/{recordId}', [PatientController::class, 'edit_save_patient_physicians'])->middleware(['auth', 'verified'])->name('edit-save-patient-physicians');


////////////////new
Route::get('/patient-confidential-note/{id}', [PatientController::class, 'patient_confidential_note'])->middleware(['auth', 'verified'])->name('patient-confidential-note');
Route::get('/edit-patient-confidential-note/{id}/{recordId}', [PatientController::class, 'edit_patient_confidential_note'])->middleware(['auth', 'verified'])->name('edit-patient-confidential-note');
Route::get('/add-patient-confidential-note/{id}', [PatientController::class, 'add_patient_confidential_note'])->middleware(['auth', 'verified'])->name('add-patient-confidential-note');
Route::PUT('/save-patient-confidential-note/{id}', [PatientController::class, 'save_patient_confidential_note'])->middleware(['auth', 'verified'])->name('save-patient-confidential-note');
Route::PUT('/edit-save-patient-confidential-note/{id}/{recordId}', [PatientController::class, 'edit_save_patient_confidential_note'])->middleware(['auth', 'verified'])->name('edit-save-patient-confidential-note');
Route::get('/view-patient-confidential-note/{id}/{recordId}', [PatientController::class, 'view_patient_confidential_note'])->middleware(['auth', 'verified'])->name('view-patient-confidential-note');


Route::get('/patient-allergies/{id}', [PatientController::class, 'patient_allergies'])->middleware(['auth', 'verified'])->name('patient-allergies');
Route::get('/edit-patient-allergies/{id}/{recordId}', [PatientController::class, 'edit_patient_allergies'])->middleware(['auth', 'verified'])->name('edit-patient-allergies');
Route::get('/add-patient-allergies/{id}', [PatientController::class, 'add_patient_allergies'])->middleware(['auth', 'verified'])->name('add-patient-allergies');
Route::PUT('/save-patient-allergies/{id}', [PatientController::class, 'save_patient_allergies'])->middleware(['auth', 'verified'])->name('save-patient-allergies');
Route::PUT('/edit-save-patient-allergies/{id}/{recordId}', [PatientController::class, 'edit_save_patient_allergies'])->middleware(['auth', 'verified'])->name('edit-save-patient-allergies');
Route::get('/view-patient-allergies/{id}/{recordId}', [PatientController::class, 'view_patient_allergies'])->middleware(['auth', 'verified'])->name('view-patient-allergies');



Route::get('/patient-surgery/{id}', [PatientController::class, 'patient_surgery'])->middleware(['auth', 'verified'])->name('patient-surgery');
Route::get('/edit-patient-surgery/{id}/{recordId}', [PatientController::class, 'edit_patient_surgery'])->middleware(['auth', 'verified'])->name('edit-patient-surgery');
Route::get('/view-patient-surgery/{id}/{recordId}', [PatientController::class, 'view_patient_surgery'])->middleware(['auth', 'verified'])->name('view-patient-surgery');
Route::get('/add-patient-surgery/{id}', [PatientController::class, 'add_patient_surgery'])->middleware(['auth', 'verified'])->name('add-patient-surgery');
Route::PUT('/save-patient-surgery/{id}', [PatientController::class, 'save_patient_surgery'])->middleware(['auth', 'verified'])->name('save-patient-surgery');
Route::PUT('/edit-save-patient-surgery/{id}/{recordId}', [PatientController::class, 'edit_save_patient_surgery'])->middleware(['auth', 'verified'])->name('edit-save-patient-surgery');



Route::get('/patient-diagnosis/{id}', [PatientController::class, 'patient_diagnosis'])->middleware(['auth', 'verified'])->name('patient-diagnosis');
Route::get('/edit-patient-diagnosis/{id}/{recordId}', [PatientController::class, 'edit_patient_diagnosis'])->middleware(['auth', 'verified'])->name('edit-patient-diagnosis');
Route::get('/add-patient-diagnosis/{id}', [PatientController::class, 'add_patient_diagnosis'])->middleware(['auth', 'verified'])->name('add-patient-diagnosis');
Route::PUT('/save-patient-diagnosis/{id}', [PatientController::class, 'save_patient_diagnosis'])->middleware(['auth', 'verified'])->name('save-patient-diagnosis');
Route::PUT('/edit-save-patient-diagnosis/{id}/{recordId}', [PatientController::class, 'edit_save_patient_diagnosis'])->middleware(['auth', 'verified'])->name('edit-save-patient-diagnosis');
Route::get('/view-patient-diagnosis/{id}/{recordId}', [PatientController::class, 'view_patient_diagnosis'])->middleware(['auth', 'verified'])->name('view-patient-diagnosis');


Route::get('/patient-episodes-injuries/{id}', [PatientController::class, 'patient_episodes_injuries'])->middleware(['auth', 'verified'])->name('patient-episodes-injuries');
Route::get('/edit-patient-episodes-injuries/{id}/{recordId}', [PatientController::class, 'edit_patient_episodes_injuries'])->middleware(['auth', 'verified'])->name('edit-patient-episodes-injuries');
Route::get('/add-patient-episodes-injuries/{id}', [PatientController::class, 'add_patient_episodes_injuries'])->middleware(['auth', 'verified'])->name('add-patient-episodes-injuries');
Route::PUT('/save-patient-episodes-injuries/{id}', [PatientController::class, 'save_patient_episodes_injuries'])->middleware(['auth', 'verified'])->name('save-patient-episodes-injuries');
Route::PUT('/edit-save-patient-episodes-injuries/{id}/{recordId}', [PatientController::class, 'edit_save_patient_episodes_injuries'])->middleware(['auth', 'verified'])->name('edit-save-patient-episodes-injuries');
Route::get('/view-patient-episodes-injuries/{id}/{recordId}', [PatientController::class, 'edit_patient_episodes_injuries'])->middleware(['auth', 'verified'])->name('view-patient-episodes-injuries');



Route::get('/patient-advanced-directives/{id}', [PatientController::class, 'patient_advanced_directives'])->middleware(['auth', 'verified'])->name('patient-advanced-directives');
Route::get('/edit-patient-advanced-directives/{id}/{recordId}', [PatientController::class, 'edit_patient_advanced_directives'])->middleware(['auth', 'verified'])->name('edit-patient-advanced-directives');
Route::get('/add-patient-advanced-directives/{id}', [PatientController::class, 'add_patient_advanced_directives'])->middleware(['auth', 'verified'])->name('add-patient-advanced-directives');
Route::PUT('/save-patient-advanced-directives/{id}', [PatientController::class, 'save_patient_advanced_directives'])->middleware(['auth', 'verified'])->name('save-patient-advanced-directives');
Route::PUT('/edit-save-patient-advanced-directives/{id}/{recordId}', [PatientController::class, 'edit_save_patient_advanced_directives'])->middleware(['auth', 'verified'])->name('edit-save-patient-advanced-directives');




Route::PUT('/edit-save-patient-current-medician/{id}/{recordId}', [PatientController::class, 'edit_save_patient_current_medication'])->middleware(['auth', 'verified'])->name('edit-save-patient-current-medician');
Route::PUT('/edit-save-patient-past-medician/{id}/{recordId}', [PatientController::class, 'edit_save_patient_past_medication'])->middleware(['auth', 'verified'])->name('edit-save-patient-past-medician');


Route::delete('destroy-submission/{id}', [SubmissionController::class, 'destroy_submission'])->middleware(['auth', 'verified'])->name('destroy_submission');


// Route::get('/product-stock/{id}', [StockController::class, 'index'])->name('product-stock');
Route::get('/export-sale/{id}', [PdfController::class, 'pdf_sale'])->middleware(['auth', 'verified'])->name('export-sale');
Route::get('/export-invoice/{id}', [PdfController::class, 'pdf_invoice'])->name('export-invoice');
Route::get('/export-invoice-proforma/{id}', [PdfController::class, 'pdf_invoice_proforma'])->name('export-invoice-proforma');

Route::get('/export-delivery-note/{id}', [PdfController::class, 'pdf_delivery_note'])->middleware(['auth', 'verified'])->name('export-delivery-note');
Route::get('/export-purchase/{id}', [PdfController::class, 'pdf_purchase'])->middleware(['auth', 'verified'])->name('export-purchase');
Route::get('/export-quote/{id}', [PdfController::class, 'pdf_quote'])->middleware(['auth', 'verified'])->name('export-quote');

Route::get('failed/{id}', [SalesController::class, 'failed'])->name('failed');
Route::get('create-category', [CategoryController::class, 'create'])->name('create-category');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/privacy-policy', [DashboardController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/contact-us', [DashboardController::class, 'contactUs'])->name('contact-us');
Route::get('/terms-and-conditions', [DashboardController::class, 'termsConditions'])->name('terms-and-conditions');
Route::get('/return-policy', [DashboardController::class, 'returnPolicy'])->name('return-policy');


Route::resource('item', ProductsController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::get('/update-product-image/{id}', [ProductsController::class, 'updateImage'])->name('update-product-image');



Route::get('/position-item-default', [ProductsController::class, 'positionItemDefault'])->name('position-item-default');
Route::get('/file-item-import', [ProductsController::class, 'importItemView'])->name('import-item-view');
Route::get('/file-customer-import', [CustomerController::class, 'importCustomerView'])->name('import-customer-view');
Route::get('/file-sales-import', [SalesController::class, 'importSalesView'])->name('import-sales-view');

Route::get('/image-item-import', [ProductsController::class, 'importItemImageView'])->name('import-item-image-view');
Route::post('/import-item', [ProductsController::class, 'importItem'])->name('import-item');
Route::post('/import-customer', [CustomerController::class, 'importCustomer'])->name('import-customer');
Route::post('/import-sales', [SalesController::class, 'importSales'])->name('import-sales');


Route::get('/import-sku', [StockController::class, 'importSku'])->name('import-sku');
Route::get('/import-sku-update', [StockController::class, 'updateImportSku'])->name('import-sku-update');
Route::post('/import-item-image', [ProductsController::class, 'importItemImage'])->name('import-item-image');
Route::get('/export-item', [ProductsController::class, 'exportItems'])->name('export-item');
Route::get('/export-item-type-image', [ProductsController::class, 'exportItemsParamsImage'])->name('export-item-param-image');
Route::post('/item-image', [ProductsController::class, 'itemUploadImage'])->name('item-image');
Route::get('/item-images/{id}', [ProductsController::class, 'itemsImage'])->name('item-images');
Route::get('/delete-attribute-value/{id}', [AttributeValueController::class, 'destroy'])->middleware(['auth', 'verified'])->name('delete-attribute-value');
Route::get('item-filter', [ProductsController::class, 'index'])->name('items.search');
Route::get('customer-sales/{id}', [SalesController::class, 'customer_orders'])->middleware(['auth', 'verified'])->name('customer_orders');
Route::get('thankyou/{id}', [SalesController::class, 'customer_orders'])->name('thankyou');
Route::get('order-confirmation', [SalesController::class, 'after_sale'])->name('order-confirmation-view');
Route::get('attachment/{id}', [SalesController::class, 'attachment'])->middleware(['auth', 'verified'])->name('attachment');
Route::get('new-sale', [SalesController::class, 'new_sale'])->middleware(['auth', 'verified'])->name('new-sale');
Route::get('new-bill', [BillController::class, 'new'])->middleware(['auth', 'verified'])->name('new-bill');
Route::get('new-quote', [QuotesController::class, 'new'])->middleware(['auth', 'verified'])->name('new-quote');
Route::get('product_variations/{id1}/{id2}', [NewSaleController::class, 'ajax_get_items_variations'])->name('product_variations');
Route::get('stock_history_per_id_stock/{id}', [stockHistoryController::class, 'stock_history_per_id_stock'])->name('stock_history_per_id_stock');
Route::get('store-settings', [SettingController::class, 'onlineSettings'])->middleware(['auth', 'verified'])->name('online_stock');

// Delete this after 30-09-2024
//Route::resource('homecarousel', HomeCarouselControllerDelete::class)->middleware(['auth', 'verified'])->name('get','name');
Route::post('/homecarousels/interval', [HomePageComponentController::class, 'interval'])->middleware(['auth', 'verified'])->name('homecarousels-interval');

Route::get('homepage-components', [HomePageComponentController::class, 'homepage_component'])->middleware(['auth', 'verified'])->name('homepage_components');
Route::post('store-slider', [HomePageComponentController::class, 'store_slider'])->middleware(['auth', 'verified'])->name('store-slider');
Route::get('edit-slider/{id}', [HomePageComponentController::class, 'edit_slider'])->middleware(['auth', 'verified'])->name('edit_slider');
Route::delete('destroy-slides/{id}', [HomePageComponentController::class, 'destroy_slides'])->middleware(['auth', 'verified'])->name('destroy_slides');
Route::delete('destroy-component/{id}', [HomePageComponentController::class, 'destroy_component'])->middleware(['auth', 'verified'])->name('destroy_component');
Route::get('createslider/{id}', [HomePageComponentController::class, 'create_slider'])->middleware(['auth', 'verified'])->name('createslider');

Route::get('slider-list/{id}', [HomePageComponentController::class, 'slider_list'])->middleware(['auth', 'verified'])->name('slider_list');

Route::PUT('update-slider/{id}', [HomePageComponentController::class, 'update_slider'])->middleware(['auth', 'verified'])->name('update_slider');
Route::post('homecomponent-slider', [HomePageComponentController::class, 'store_slider_main'])->middleware(['auth', 'verified'])->name('homecomponent-slider');
Route::post('update-main-slider/{id}', [HomePageComponentController::class, 'update_slider_main'])->middleware(['auth', 'verified'])->name('update-main-slider');


Route::post('upload-image', [HomePageComponentController::class, 'upload_image'])->middleware(['auth', 'verified'])->name('upload-image');


Route::get('collection-list/{id}', [HomePageComponentController::class, 'collection_list'])->middleware(['auth', 'verified'])->name('collection_list');


Route::get('createcollection/{id}', [HomePageComponentController::class, 'create_collection'])->middleware(['auth', 'verified'])->name('createcollection');
Route::get('edit-collection/{id}', [HomePageComponentController::class, 'edit_collection'])->middleware(['auth', 'verified'])->name('edit_collection');
Route::delete('destroy-collection/{id}', [HomePageComponentController::class, 'destroy_collection'])->middleware(['auth', 'verified'])->name('destroy_collection');
Route::delete('destroy-slider/{id}', [HomePageComponentController::class, 'destroy_slider'])->middleware(['auth', 'verified'])->name('destroy_slider');

Route::post('store-collection', [HomePageComponentController::class, 'store_collection'])->middleware(['auth', 'verified'])->name('store-collection');
Route::PUT('update-collection/{id}', [HomePageComponentController::class, 'update_collection'])->middleware(['auth', 'verified'])->name('update_collection');



Route::get('get_stock_api', [OnlineStockApiController::class, 'get_stock_api'])->middleware(['auth', 'verified'])->name('get_stock_api');
Route::get('increase/{id}', [NewSaleController::class, 'increase'])->name('increase');
Route::get('decrease/{id}', [NewSaleController::class, 'decrease'])->name('decrease');
Route::get('cart_update_qty/{id}/{qty}', [NewSaleController::class, 'cart_update_qty'])->name('cart_update_qty');

Route::resource('category', CategoryController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('customer', CustomerController::class)->middleware(['auth', 'verified'])->name('get', 'name');

Route::resource('patients', PatientController::class)->middleware(['auth', 'verified'])->name('get', 'name');

Route::get('/search-patient', [PatientController::class, 'search'])->name('search-patients');
Route::resource('user', UserController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('doctor', DoctorController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::get('doctor-public-page/{id}', [DashboardController::class, 'doctorPublicPage'])->name('doctor.public.page');

Route::get('doctors-directory', [DashboardController::class, 'doctorsDirectory'])->name('doctors.directory');



Route::get('/sales', [SalesController::class, 'index'])->name('sales');

Route::resource('attribute', AttributeController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('sales', SalesController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('sales-payments', SalesPaymentsController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('rentals-payments', RentalsPaymentsController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('appointment-payments', AppointmentsPaymentsController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('delivery', DeliveryController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('onlinestockapi', OnlineStockApiController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('supplier', SupplierController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('bills-payments', BillsPaymentController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::post('update_post', [SalesPaymentsController::class, 'update_post'])->middleware(['auth', 'verified'])->name('sales-payments.update_post');
Route::put('update_order_reference/{id}', [SalesController::class, 'update_order_reference'])->middleware(['auth', 'verified'])->name('sales.update_order_reference');
Route::put('update_bill_reference/{id}', [BillController::class, 'update_bill_reference'])->middleware(['auth', 'verified'])->name('bills.update_bill_reference');
Route::put('update_payment_method/{id}', [SalesController::class, 'update_payment_method'])->middleware(['auth', 'verified'])->name('sales.update_payment_method');
Route::put('update_rental_date/{id}', [SalesController::class, 'update_rental_date'])->middleware(['auth', 'verified'])->name('submissions.update_rental_date');
Route::delete('/destroy_sale_item/{id}', [SalesController::class, 'destroy_sale_item'])->middleware(['auth', 'verified'])->name('destroy_sale_item');
Route::post('/add-new-item-sales/{id}', [SalesController::class, 'add_item_sales'])->middleware(['auth', 'verified'])->name('add-new-item-sales');


Route::put('update-customer-sale/{id}', [SalesController::class, 'update_customer'])->middleware(['auth', 'verified'])->name('sales.update_customer');
Route::put('update-customer-quote/{id}', [QuotesController::class, 'update_customer'])->middleware(['auth', 'verified'])->name('quotes.update_customer');
Route::put('update-product-quote/{id}', [QuotesController::class, 'update_quote_product'])->middleware(['auth', 'verified'])->name('quotes.update_quote_product');
Route::put('stock-take/{id}', [StockController::class, 'stock_take'])->middleware(['auth', 'verified'])->name('stock.stock_take');
Route::put('update-sku/{id}', [StockController::class, 'update_sku'])->middleware(['auth', 'verified'])->name('stock.update_sku');

Route::resource('stores', StoreController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('settings', SettingController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::post('/settings/company/create', [SettingController::class, 'addCompany'])->middleware(['auth', 'verified'])->name('create-company');
Route::post('/settings/paymentMethodSales/create', [SettingController::class, 'addPaymentMethodSales'])->middleware(['auth', 'verified'])->name('create-payment-method-sales');
Route::put('/settings/company/update/{id}', [SettingController::class, 'updateCompany'])->middleware(['auth', 'verified'])->name('update-company');
Route::put('/settings/paymentMethodSales/update/{id}', [SettingController::class, 'updatePaymentMethodSales'])->middleware(['auth', 'verified'])->name('update-payment-method-sales');
Route::post('/settings/emailSmtp/update', [SettingController::class, 'addUpdateEmailSmtp'])->middleware(['auth', 'verified'])->name('add-update-email-smtp');
Route::post('/settings/mcb-config/update', [SettingController::class, 'addUpdateMCBConfiguration'])->middleware(['auth', 'verified'])->name('add-update-mcb-configuration');
Route::post('/settings/vat-rate/update', [SettingController::class, 'addUpdateVATRate'])->middleware(['auth', 'verified'])->name('add-update-mra-vat-rat');
Route::resource('variation', ProductVariationController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::get('/variation/image/delete/{id}', [ProductVariationController::class, 'destroy_variation_image'])->middleware(['auth', 'verified'])->name('delete-variation-image');
Route::get('/update-variation-image/{id}', [ProductVariationController::class, 'updateImage'])->name('update-variation-image');



Route::resource('stock', StockController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('stockhistory', stockHistoryController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::post('/updateDisplayLogoPdf', [SettingController::class, 'updateDisplayLogoPdf'])->middleware(['auth', 'verified'])->name('updateDisplayLogoPdf');
Route::post('/updateShopMeta', [SettingController::class, 'updateShopMeta'])->middleware(['auth', 'verified'])->name('updateShopMeta');
Route::post('/updateImageRequiredOnlineShop', [SettingController::class, 'updateImageRequiredOnlineShop'])->middleware(['auth', 'verified'])->name('updateImageRequiredOnlineShop');
Route::post('/updateEnableFilteringOnlineShop', [SettingController::class, 'updateEnableFilteringOnlineShop'])->middleware(['auth', 'verified'])->name('updateEnableFilteringOnlineShop');
Route::post('/updatePrivacyPolicy', [SettingController::class, 'updatePrivacyPolicy'])->middleware(['auth', 'verified'])->name('updatePrivacyPolicy');
Route::post('/updateTermsConditions', [SettingController::class, 'updateTermsConditions'])->middleware(['auth', 'verified'])->name('updateTermsConditions');
Route::post('/updateReturnPolicy', [SettingController::class, 'updateReturnPolicy'])->middleware(['auth', 'verified'])->name('updateReturnPolicy');
Route::post('/updateCodeAddedHeader', [SettingController::class, 'updateCodeAddedHeader'])->middleware(['auth', 'verified'])->name('updateCodeAddedHeader');
Route::post('/updateCodeStickyHeader', [SettingController::class, 'updateCodeStickyHeader'])->middleware(['auth', 'verified'])->name('updateCodeStickyHeader');
Route::post('/updateActiveDelivery', [DeliveryController::class, 'updateActiveDelivery'])->middleware(['auth', 'verified'])->name('updateActiveDelivery');
Route::post('/email-cc-admin', [SettingController::class, 'updateEmailCcAdmin'])->name('email-cc-admin');

Route::post('/mra-esb-setting', [SettingController::class, 'updateMRAEbsSetting'])->name('mra-esb-setting');

Route::resource('paymentsMethodSales', PayementMethodSalesController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('headermenu', HeaderMenuController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::post('/update-menu-order', [HeaderMenuController::class, 'updateOrder'])->name('headermenu.updateOrder');


Route::resource('attributeValue', AttributeValueController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::post('/header/color', [HeaderMenuController::class, 'createHeaderColor'])->middleware(['auth', 'verified'])->name('header-color-create');
Route::put('/header/color/update/{id}', [HeaderMenuController::class, 'updateHeaderColor'])->middleware(['auth', 'verified'])->name('header-color-update');
Route::put('/header/position/update', [HeaderMenuController::class, 'updatePosition'])->middleware(['auth', 'verified'])->name('headermenu-position-update');

Route::resource('home-collection-image', HomepageCollectionImageController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('newsale', NewSaleController::class)->middleware(['auth', 'verified']);
Route::post('update-total-discount', [NewSaleController::class, 'updateTotalDiscount'])->middleware(['auth', 'verified'])->name('newsale.update-total-discount');


Route::resource('ledger', LedgerController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('journal', JournalEntryController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('petty_cash', PettyCashController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('banking', BankingController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('bill', BillController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::resource('quote', QuotesController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::get('pettycash/money_in', [PettyCashController::class, 'createMoneyIn'])->middleware(['auth', 'verified'])->name('petty-cash-create-money-in');
Route::get('pettycash/money_out', [PettyCashController::class, 'createMoneyOut'])->middleware(['auth', 'verified'])->name('petty-cash-create-money-out');
Route::post('/journal/sale', [SalesController::class, 'add_journal_sale'])->middleware(['auth', 'verified'])->name('add-journal-sale');
Route::post('/journal/sales', [SalesController::class, 'update_journal_sale'])->middleware(['auth', 'verified'])->name('update-journal-sale');
Route::post('/qunaity/sales', [SalesController::class, 'update_item_qunaity_sale'])->middleware(['auth', 'verified'])->name('update-item-qunaity-sale');
Route::post('/journal/item/sale/{id}', [SalesController::class, 'update_item_sale'])->middleware(['auth', 'verified'])->name('update-item-sale');
Route::post('/update-item-submission/{id}', [SubmissionController::class, 'update_item_submission'])->middleware(['auth', 'verified'])->name('update-item-submission');
Route::post('/add-new-item-submission/{id}', [SubmissionController::class, 'add_item_submission'])->middleware(['auth', 'verified'])->name('add-new-item-submission');
Route::put('/submission-status-update/{id}', [SubmissionController::class, 'submission_status_update'])->middleware(['auth', 'verified'])->name('submission-status-update');


Route::delete('/destroy_rental_item/{id}', [SubmissionController::class, 'destroy_rental_item'])->middleware(['auth', 'verified'])->name('destroy_rental_item');





Route::post('/banking/update', [BankingController::class, 'update_banking'])->middleware(['auth', 'verified'])->name('update-banking');
Route::post('/banking/import', [BankingController::class, 'import_banking'])->middleware(['auth', 'verified'])->name('import-banking');
Route::post('/banking/matching/petty_cash/{id}', [BankingController::class, 'matching_pettycash'])->middleware(['auth', 'verified'])->name('banking-petty-cash');
Route::post('/banking/matchings/petty_cash/delete', [BankingController::class, 'matching_pettycash_delete'])->middleware(['auth', 'verified'])->name('delete-matching-petty-cash');
Route::post('/bankings/matchings', [BankingController::class, 'matching_banking'])->middleware(['auth', 'verified'])->name('matching-banking');
Route::get('/bankings/matching', [BankingController::class, 'matching_view'])->middleware(['auth', 'verified'])->name('banking-view');
Route::get('/bankings/export', [BankingController::class, 'export_banking'])->middleware(['auth', 'verified'])->name('export-banking');
Route::get('/bankings/delete-all', [BankingController::class, 'delete_all_banking'])->middleware(['auth', 'verified'])->name('delete-all-banking');


Route::put('/settings/update_bo_sales/{id}', [SettingController::class, 'updatePaymentMethodSalesBOSales'])->middleware(['auth', 'verified'])->name('update-payment-method-sales-bo-sales');
Route::put('/settings/update_oonline_shop/{id}', [SettingController::class, 'updatePaymentMethodSalesOnlineShop'])->middleware(['auth', 'verified'])->name('update-payment-method-sales-online-shop');
Route::put('/settings/update_pickup_location/{id}', [SettingController::class, 'updatePickupLocation'])->middleware(['auth', 'verified'])->name('update-pickup-location');
Route::put('/settings/update_is_on_newsale_page/{id}', [SettingController::class, 'updateIsOnNewSalePage'])->middleware(['auth', 'verified'])->name('is-on-newsale-page');
Route::put('/settings/update_is_online_in_store/{id}', [SettingController::class, 'updateIsOnlineInStore'])->middleware(['auth', 'verified'])->name('is-online-in-store');
Route::post('/settings/update_enable_online_shop', [SettingController::class, 'updateEnableOnlineShop'])->middleware(['auth', 'verified'])->name('update-enable-online-shop');
Route::post('/settings/update_enable_stock_online_product', [SettingController::class, 'updateEnableStockRequiredDisplayOnlineProduct'])->middleware(['auth', 'verified'])->name('update-stock-online-product');
Route::post('/settings/update_enable_product_stock_from_api', [SettingController::class, 'updateEnableProductStockFromApi'])->middleware(['auth', 'verified'])->name('update-enable-stock-api');
Route::post('/settings/update_send_onlineshop_order_mail', [SettingController::class, 'updateOnlineshopOrderMail'])->middleware(['auth', 'verified'])->name('updateOnlineshopOrderMail');
Route::post('/settings/update_send_backoffice_order_mail', [SettingController::class, 'updateSendBackofficeOrderMail'])->middleware(['auth', 'verified'])->name('updateSendBackofficeOrderMail');
Route::post('/settings/update_send_onlineshop_order_mail_admin', [SettingController::class, 'updateOnlineshopOrderMailAdmin'])->middleware(['auth', 'verified'])->name('updateOnlineshopOrderMailAdmin');
Route::post('/settings/update_send_order_status_change_to_admin', [SettingController::class, 'updateOrderStatusChangeToAdmin'])->middleware(['auth', 'verified'])->name('updateOrderStatusChangeToAdmin');
Route::post('/settings/update_send_backoffice_order_mail_admin', [SettingController::class, 'updateSendBackofficeOrderMailAdmin'])->middleware(['auth', 'verified'])->name('updateSendBackofficeOrderMailAdmin');
Route::post('/settings/updateTrainingMode', [SettingController::class, 'updateTrainingMode'])->middleware(['auth', 'verified'])->name('updateTrainingMode');
Route::post('/stock_sheet_add', [StockController::class, 'add_stock_sheet'])->middleware(['auth', 'verified'])->name('stock.add_stock_sheet');
Route::post('/add-bill-files', [BillController::class, 'add_bill_files'])->middleware(['auth', 'verified'])->name('bill.add_bill_files');
Route::post('/add-sale-files', [SalesController::class, 'add_sale_files'])->middleware(['auth', 'verified'])->name('sales.add_sale_files');
Route::post('/add-credit-note', [SalesController::class, 'add_credit_note'])->middleware(['auth', 'verified'])->name('sales.add_credit_note');
Route::post('/add-debit-note-sales', [SalesController::class, 'add_debit_note'])->middleware(['auth', 'verified'])->name('sales.add_debit_note');
Route::post('/add-debit-note', [BillController::class, 'add_debit_note'])->middleware(['auth', 'verified'])->name('bill.add_debit_note');

Route::get('/search-item', [ProductsController::class, 'search'])->name('search-products');
Route::get('/search-stock', [StockController::class, 'search'])->name('search-stocks');
Route::get('/search-customer', [CustomerController::class, 'search'])->name('search-customers');
Route::get('/search-supplier', [CustomerController::class, 'search'])->name('search-supplier');
Route::get('/search-sales', [SalesController::class, 'search'])->name('search-sales');
Route::get('/search-bills', [BillController::class, 'search'])->name('search-bills');
Route::get('/search-bankings', [BankingController::class, 'search'])->name('search-bankings');
Route::get('/search-journals', [JournalEntryController::class, 'search'])->name('search-journals');
Route::get('/search-pettycash', [PettyCashController::class, 'search'])->name('search-pettycash');


Route::get('/product-settings', [ProductSettingsController::class, 'index'])->middleware(['auth', 'verified'])->name('product-settings');
Route::post('/product-settings', [ProductSettingsController::class, 'add_update'])->middleware(['auth', 'verified'])->name('product-setting-add-update');
Route::get('/export-stats', [DashboardController::class, 'exportStat'])->name('export-stat');


Route::get('/customer-details/{id}', [CustomerController::class, 'customer_details'])->middleware(['auth', 'verified'])->name('customer-details');
Route::get('/customer-full-statement/{id}', [CustomerController::class, 'list_order_customer_pdf'])->middleware(['auth', 'verified'])->name('customer-full-statement');
Route::get('/customer-export-items/{id}', [CustomerController::class, 'customer_export_items'])->middleware(['auth', 'verified'])->name('customer-export-item');
Route::get('/customer-statement/{id}', [CustomerController::class, 'list_order_customer_between_pdf'])->middleware(['auth', 'verified'])->name('customer-part-statement');
Route::get('/customer-products/{id}', [CustomerController::class, 'productCustomerView'])->middleware(['auth', 'verified'])->name('customer-products');
Route::get('/customer-mra-request/{id}', [CustomerController::class, 'customerMRARequest'])->middleware(['auth', 'verified'])->name('customer-mra-request');

Route::get('/filter-sales/{customer_id}/{payment_mode}', [CustomerController::class, 'filterSales'])->name('filter.sales');


Route::resource('ledger', LedgerController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::get('/ledger/{id}', [LedgerController::class, 'details_ledger'])->name('ledger-details');
Route::get('ws_stock/{id}', [ProductsController::class, 'stock'])->name('ws_stock');


Route::delete('empty_item', [ProductsController::class, 'delete_all'])->name('empty_item');
Route::delete('delete-sales-file/{id}', [SalesController::class, 'destroy_salesfile'])->name('sales.destroy_salesfile');
Route::delete('delete-bill-file/{id}', [BillController::class, 'destroy_billfile'])->name('bill.destroy_billfile');

Route::get('/sales-customer-ajax', [BankingController::class, 'get_sales_customer_ajax'])->middleware(['auth', 'verified'])->name('get-sales-customer-ajax');
Route::get('/bills-supplier-ajax', [BankingController::class, 'get_bills_supplier_ajax'])->middleware(['auth', 'verified'])->name('get-bills-supplier-ajax');
Route::post('/sales-matching-banking/delete', [BankingController::class, 'delete_matching_banking_sales'])->middleware(['auth', 'verified'])->name('delete-matching-banking-sales');
Route::post('/bill-matching-banking/delete', [BankingController::class, 'delete_matching_banking_bill'])->middleware(['auth', 'verified'])->name('delete-matching-banking-bill');
Route::get('/autocomplete/customer', [AutoCompleteController::class, 'autocompleteCustomer'])->middleware(['auth', 'verified'])->name('autocomplete-customer');
Route::get('/autocomplete/supplier', [AutoCompleteController::class, 'autocompleteSupplier'])->middleware(['auth', 'verified'])->name('autocomplete-supplier');

Route::get('/product/image/delete/{id}', [ProductImageController::class, 'delete_product_image'])->middleware(['auth', 'verified'])->name('delete-product-image');
Route::get('/favicon/site', [SettingController::class, 'get_favicon_store'])->middleware(['auth', 'verified'])->name('get-favicon-store');
Route::get('/favicon/site/fo', [SettingController::class, 'get_favicon_store_fo'])->middleware(['auth', 'verified'])->name('get-favicon-store-fo');
Route::get('/search-ledgers', [LedgerController::class, 'search'])->name('search-ledgers');
Route::get('/pettycash-ledger-ajax', [PettyCashController::class, 'petty_cash_ledger_ajax'])->middleware(['auth', 'verified'])->name('petty-cash-ledger-ajax');

Route::resource('statistics', StatisticsController::class)->middleware(['auth', 'verified'])->name('get', 'name');
Route::get('/sales-exports/detailed', [SalesController::class, 'sales_export_all_detailed'])->name('sales-export-all-detailed');
Route::get('/sales-exports/simple', [SalesController::class, 'sales_export_all_simple'])->name('sales-export-all-simple');
Route::get('/stocks-exports', [StockController::class, 'stock_export'])->name('stock-export-report');
Route::get('/sku-exports', [StockController::class, 'product_sku_export'])->name('product-sku-export');

Route::post('/import-ledger', [LedgerController::class, 'importLedger'])->name('import-ledger');
Route::get('/file-ledger-import', [LedgerController::class, 'importLedgerView'])->name('import-ledger-view');

// pages
Route::get('/pages', [PageController::class, 'index'])->name('page.index');
Route::get('/pages/create', [PageController::class, 'createPage'])->name('page.create');
Route::post('/pages/store', [PageController::class, 'storePage'])->name('page.store');
Route::get('/pages/edit/{id}', [PageController::class, 'editPage'])->name('page.edit');
Route::post('/pages/update/{id}', [PageController::class, 'updatePage'])->name('page.update');
Route::delete('/pages/destroy/{id}', [PageController::class, 'destroyPage'])->name('page.destroy');
Route::get('/pages/{slug}', [PageController::class, 'viewPage'])->name('page.view');
Route::post('/upload/image', [PageController::class, 'imageUpload'])->name('upload.image');
Route::post('ck-image', [PageController::class, 'ckImageUpload'])->name('ck.upload');

Route::get('/mra/unsubmitted/invoices', [MRAController::class, 'index'])->name('mra.unsubmitted_invoices');
Route::get('/mra/unsubmitted/invoices/send', [MRAController::class, 'send_unsumbitted_invoices'])->name('mra.send_unsumbitted_invoices');

require __DIR__ . '/auth.php';
