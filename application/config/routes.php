<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'index';
//$route['404_override'] = 'login/four_zero_four';
$route['translate_uri_dashes'] = FALSE;

$route['payment_pdf/(:any)']='feepayment/collection/Payment_pdf/payment_pdf/$1';
$route['payment_pdf']='feepayment/collection/Payment_pdf/payment_pdf';
$route['Get_vehicle']='admission/Student/Get_vehicle';
$route['Bonafied_certificate']='certificate/Certificate/Bonafied_certificate';
$route['Bonafied_certificate1']='certificate/Certificate/Bonafied_certificate1';
$route['School_leaving_certificate']='certificate/Certificate/School_leaving_certificate';

$route['certificate_pdf']='certificate/Certificate/certificate_pdf';
$route['certificate_pdf/(:any)']='certificate/Certificate/certificate_pdf/$1';

$route['fee_certificate_pdf']='certificate/Certificate/fee_certificate_pdf';
$route['fee_certificate_pdf/(:any)']='certificate/Certificate/fee_certificate_pdf/$1';

$route['tc_certificate_pdf']='certificate/Certificate/tc_certificate_pdf';
$route['tc_certificate_pdf/(:any)']='certificate/Certificate/tc_certificate_pdf/$1';

$route['admission/student_report']='admission/student/student_report';
//contacts/edit/id 	$route['edit/:id'] 
//$route['book/add_book/edit_book/:id']='library/book/add_book/edit_book/';
//$route['transport/locations']='masters/locations';
//$route['transport/locations/paged_data']='masters/locations/paged_data';
//$route['transport/locations/getrec/(:any)']='masters/locations/getrec/$l';
//$route['transport/locations/add']='masters/locations/add';
//$route['transport/locations/update/(:any)']='masters/locations/update/$l';
//$route['transport/locations/delete/(:any)']='masters/locations/delete/$l';
//$route['transport/locations/duplication_check']='masters/locations/duplication_check';


/*----- Account  ------*/
$route['account/voucherEntry/payment']='account/payment';
$route['account/voucherEntry/receipt']='account/receipt';
$route['account/voucherEntry/journal']='account/journal';
$route['account/voucherEntry/contra']='account/contra';
$route['account/voucherEntry/debit_note']='account/debit_note';
$route['account/voucherEntry/credit_note']='account/credit_note';
$route['account/report/acc_ledger']='account/acc_ledger';
$route['account/report/group_ledger']='account/group_ledger';
$route['account/report/trail_balance']='account/trail_balance';
$route['account/report/profitloss_account']='account/profitloss_account';
$route['account/report/balance_sheet']='account/balance_sheet';

/*--------------------- Payment GAteway ----------*/
$route['CCAvenueResponse']='ServerNotify/CCAvenueResponse';


/*-----  Academics  ------*/
$route['academics/settings/class_teachers']='academics/class_teachers';
$route['academics/settings/class_teachers/add']='academics/class_teachers/add';
$route['academics/settings/class_teachers/paged_data']='academics/class_teachers/paged_data';
$route['academics/settings/class_teachers/exportcsv']='academics/class_teachers/exportcsv';
$route['academics/settings/class_teachers/getrec/(:any)']='academics/class_teachers/getrec/$1';
$route['academics/settings/class_teachers/update/(:any)']='academics/class_teachers/update/$1';

$route['academics/settings/subjects']='academics/subjects';
$route['academics/settings/subjects/add']='academics/subjects/add';
$route['academics/settings/subjects/paged_data']='academics/subjects/paged_data';
$route['academics/settings/subjects/exportcsv']='academics/subjects/exportcsv';
$route['academics/settings/subjects/getrec/(:any)']='academics/subjects/getrec/$1';
$route['academics/settings/subjects/update/(:any)']='academics/subjects/update/$1';

$route['academics/settings/periods']='academics/periods';
$route['academics/routine/class_routines']='academics/class_routines';
$route['academics/routine/class_routines/addRoutine']='academics/class_routines/addClassRoutine';
$route['academics/routine/class_routines/editRoutine/(:any)/(:any)']='academics/class_routines/editClassRoutine/$1/$2';
$route['academics/routine/teacher_routines']='academics/teacher_routines';


$route['academics/examinations/grades']='academics/grades';
$route['academics/examinations/grades/add']='academics/grades/add';
$route['academics/examinations/grades/getrec/(:any)']='academics/grades/getrec/$1';
$route['academics/examinations/grades/update/(:any)']='academics/grades/update/$1';
$route['academics/examinations/grades/paged_data']='academics/grades/paged_data';
$route['academics/examinations/grades/exportcsv']='academics/grades/exportcsv';

$route['academics/examinations/exams']='academics/exams';
$route['academics/examinations/exams/paged_data']='academics/exams/paged_data';
$route['academics/examinations/exams/add']='academics/exams/add';
$route['academics/examinations/exams/update/(:num)']='academics/exams/update/$1';
$route['academics/examinations/exams/examSchedule/(:any)']='academics/exams/examSchedule/$1';
$route['academics/examinations/exams/getrec/(:any)']='academics/exams/getrec/$1';



//$route['import-text-book'] = "";

