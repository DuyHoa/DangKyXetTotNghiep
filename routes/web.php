<?php

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

Route::get('/', function () {
    return view('home');
});
Route::get('/home', function(){
	return view('home');
});

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');


// Sửa đường dẫn trang chủ mặc định
Route::get('/', 'SinhVienController@index');
Route::get('/trang-chu', 'SinhVienController@index');
 
// Đăng ký thành viên
Route::get('register', 'Auth\RegisterController@getRegister');
Route::post('register', 'Auth\RegisterController@postRegister');
 
// Đăng nhập và xử lý đăng nhập
Route::get('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@getLogin']);
Route::post('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@postLogin']);
 
// Đăng xuất
Route::get('logout', [ 'as' => 'logout', 'uses' => 'Auth\LogoutController@getLogout']);
Route::get('/gioi-thieu', function(){
	return view('introduce');
});


//--------------------------------------------------
//-----------------Quản lý bảng điểm----------------
Route::get('bangdiem/importexcel', 'MyCustomController@importBangDiemUI');
Route::post('importbangdiemsv', 'MyCustomController@importBangDiemFuct');
Route::get('bangdiem/list', 'MyCustomController@getBD');
Route::get('bangdiem/{masv}', 'SinhVienController@bangdiemSV');
Route::post('NganhKhoa_dependent', 'SinhVienController@fetch')->name('NganhKhoadependent.fetch');
Route::get('/sinhvien/action', 'SinhVienController@sinhvienlist')->name('sinhvien.action');
Route::get('sinhvien/list', 'SinhVienController@getAllInforSV');


//---------------------------------------------------
//-----------------Quản lý khoa----------------------
Route::get('khoa/list', 'KhoaController@getDataKhoa');
Route::get('khoa/create', 'KhoaController@create');
Route::post('khoa', 'KhoaController@store');
Route::post('khoa/delete', 'KhoaController@delete');
Route::post('khoa/update', 'KhoaController@update');
Route::get('khoa/edit/{maKhoa}',['as'=>'edit/khoa', 'uses'=>'KhoaController@edit']);


//--------------------------------------------------
//-----------------Quản lý môn học------------------
//Route::get('monhoc/list', 'monHocController@getDataMonhoc');
Route::post('monhoc', 'monHocController@insertmonhoc');
Route::get('monhoc/create', function(){
	return view('monhoc.create-subject');
});
Route::get('monhoc/edit/{maMH}',['as'=>'edit/monhoc', 'uses'=>'monHocController@edit']);
Route::post('monhoc/update', 'monHocController@update');
Route::post('monhoc/delete', 'monHocController@delete');
Route::get('monhoc/search/{content}', 'monHocController@search');
Route::get('/monhoc/list', 'LiveSearch@index');
Route::get('/monhoc/action', 'LiveSearch@action')->name('monhoc.action');
Route::get('monhoc/{maMH}', 'monHocController@getMonHoc');


//--------------------------------------------------
//-----------------Quản lý ngành--------------------
Route::get('nganh/list', 'nganhController@getDataNganh');
Route::post('nganh', 'nganhController@store');
Route::get('nganh/create', function(){
	return view('nganh.create-nganh');
});
Route::post('nganh/delete', 'nganhController@delete');
Route::post('nganh/update', 'nganhController@update');
Route::get('nganh/edit/{maKhoa}',['as'=>'edit/nganh', 'uses'=>'nganhController@edit']);
Route::get('nganh/{maKhoa}', 'nganhController@getAjaxN');



//--------------------------------------------------
//-----------------Quản lý đợt xét------------------
Route::get('dotxet/list', 'dotxetController@getDataDotXet');
Route::post('dotxet', 'dotxetController@store');
Route::get('dotxet/create', function(){
	return view('Dotxet.set-dot');
});
Route::post('dotxet/delete', 'dotxetController@delete');
Route::post('dotxet/update', 'dotxetController@update');
Route::post('dotxet/dangky', 'dotxetController@dangky');
Route::get('dotxet/{maDX}','dotxetController@showStudent');
Route::get('dotxet/edit/{maDX}',['as'=>'edit/dot', 'uses'=>'dotxetController@edit']);
Route::get('dotxet-status/{maSV}', 'dotxetController@getStatus');
Route::post('dotxet/fillName','dotxetController@fillName');
Route::post('dotxet/fillData','dotxetController@fillData');



//--------------------------------------------------
//-----------------Quản lý Chương trình học---------
Route::get('/chuongtrinhhoc', 'CTHController@getDataChuongTrinh');
Route::post('cth', 'CTHController@store')->name('cht.post');
Route::post('cth/delete', 'CTHController@delete');
Route::get('/cth/{manganh}/{course_code}', 'CTHController@getCTH');
Route::get('/cthdc/action', 'SearchMonHoc@daicuong')->name('cthdc.action');
Route::get('/cthcn/action', 'SearchMonHoc@chuyennganh')->name('cthcn.action');
Route::get('/cthcntc/action', 'SearchMonHoc@chuyennganhtc')->name('cthcntc.action');
Route::get('/cthdcct/action', 'SearchChuongTrinhHoc@daicuong')->name('cthdcct.action');
Route::get('/cthcnct/action', 'SearchChuongTrinhHoc@chuyennganh')->name('cthcnct.action');
Route::get('/cthcntcct/action', 'SearchChuongTrinhHoc@chuyennganhtc')->name('cthcntcct.action');
Route::get('chuongtrinhhoc/create', function(){
	return view('Chuongtrinh.setctt');
});

//---------------------------------------------------
//-------------Đăng ký xét tốt nghiệp----------------
Route::get('/dangky', 'SinhVienController@getDataDotXet');
Route::post('/dangkytn', 'SinhVienController@store');
Route::post('dynamic_dependent', 'KhoaController@fetch')->name('dynamicdependent.fetch');

//---------------------------------------------------
//-------------danh sách tốt nghiệp----------------
Route::get('/danh-sach', function(){
	return view('Student.danhSach');
});

//---------------------------------------------------
//----------------Quản lý xét duyệt------------------
Route::get('/xetduyet/{maN}/{maSV}', 'SinhVienController@bangXetDuyet');
Route::post('/xetduyet', 'danhSachController@createList');
Route::get('/xetduyet', 'danhSachController@index');
Route::get('/xetduyet/caidat', 'danhSachController@get');
Route::post('/xetduyet/action','danhSachController@xetduyetauto');
Route::post('/trao-bang', 'SinhVienController@traoBang');



//---------------------------------------------------
//-------Danh sách sinh viên xét tốt nghiệp----------
Route::get('/list/dukien', 'danhSachController@danhSachWithMD');
Route::get('/list/chinhthuc', 'danhSachController@danhSachChinhThuc');
Route::get('/list/chinhthuc/{maD}', 'danhSachController@danhSachChinhThucWithMD');
Route::get('/list/huy', 'danhSachController@danhSachBiHuy');
Route::post('/huyinfo', 'MyCustomController@danhSachBiHuyInfo');
Route::get('/list/huy/{maD}', 'danhSachController@danhSachBiHuyWithMD');
Route::get('/list/dukien/{maD}', 'danhSachController@danhSachWithMaDot');
Route::post('/list/dukien/fill', 'danhSachController@fillName');



//---------------------------------------------------
//----------------Quản lý điều kiện------------------
Route::get('/dieukien/{maN}/{course_code}', 'danhSachController@fetch');
Route::post('/dieukien','danhSachController@store');


//---------------------------------------------------
//-------------Quản lý môn ngôn ngữ 2----------------
Route::get('/mh/nn2','monHocController@getMonHocNN');
Route::get('/mhjson/nn2','monHocController@getMonHocNNJS');
Route::post('/mh/nn2','monHocController@postMonHocNN');
Route::get('/mh/nn2/edit/{maMH}','monHocController@findNN');
Route::post('/mh/nn2/update','monHocController@updateNN');
Route::post('/mh/nn2/delete','monHocController@deleteNN');


//---------------------------------------------------
//--------------Quản lý môn thay thế-----------------
Route::get('/mh/thaythe', 'monHocController@danhSachMTT');
Route::get('/mh/tt', 'monHocController@ajaxDanhSachMTT');
Route::get('/mh/tt/edit/{id}', 'monHocController@editDanhSachMTT');
Route::post('/mh/thaythe', 'monHocController@postDanhSachMTT');
Route::post('/mh/thaythe/update', 'monHocController@updateDanhSachMTT');
Route::post('/mh/thaythe/delete', 'monHocController@deleteDanhSachMTT');

Route::get('/thong-ke', 'statisticController@view');
Route::post('/thong-ke', 'statisticController@fillData');
Route::get('/thong-ke/all', 'statisticController@listAll');
Route::get('/thong-ke/khoa/{maKhoa}', 'statisticController@listForKhoa');
Route::get('/thong-ke/year/{year}', 'statisticController@listForYear');
Route::get('/getMaKhoa', 'statisticController@getMaKhoa');

Route::get('/testMTT', 'monHocController@testDSMTT');
Route::get('/test/{maSV}/{maK}', 'monHocController@test');


Route::get('/get/course', 'MyCustomController@getCourse');