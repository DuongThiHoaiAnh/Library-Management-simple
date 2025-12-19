<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminAuthController;


Route::get('user/signup-successful-user', fn() => view('user.signup-successful-user'));
Route::get('user/info-user', fn() => view('user.info-user'));
Route::get('user/setting-user', fn() => view('user.setting-user'));
Route::get('user/help-user', fn() => view('user.help-user'));
Route::get('user/search-book-user', fn() => view('user.search-book-user'));
Route::prefix('user')->group(function () {
    Route::view('/trangphat', 'user.trangphat')->name('user.trangphat');
    Route::view('/content-trangphat', 'user.content-trangphat');
    Route::view('/content-trangphat-thanhtoan', 'user.content-trangphat-thanhtoan');
});

Route::get('/login', fn() => redirect()->route('admin.login-admin'))->name('login');

Route::prefix('admin')->group(function () {
    Route::get('/login-admin', [AdminAuthController::class, 'showLoginForm'])
        ->name('admin.login-admin');

    Route::post('/login-admin', [AdminAuthController::class, 'login'])
        ->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->name('admin.logout');

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/homepage-admin', function () {
            return view('admin.homepage-admin');
        })->name('admin.homepage-admin');
    });
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/signup-admin', [AdminAuthController::class, 'signupForm'])->name('admin.signup-admin');
});

use App\Http\Controllers\Admin\DashBoardController;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard-admin', [DashBoardController::class, 'dashboard'])
        ->name('admin.dashboard-admin');
});




use App\Http\Controllers\Admin\SignupController;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/signup-admin', [SignupController::class, 'showForm'])->name('admin.signup-admin');
    Route::post('/signup-admin', [SignupController::class, 'register'])->name('admin.signup.submit');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/signup-successful-admin', 'admin.signup-successful-admin')
        ->name('admin.signup-successful-admin');
});

use App\Http\Controllers\Admin\BookController;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/book-management-admin', [BookController::class, 'index'])->name('admin.books.index');
    Route::post('/book-management-admin', [BookController::class, 'store'])->name('admin.books.store');
    Route::put('/book-management-admin/{id}', [BookController::class, 'update'])->name('admin.books.update');
    Route::delete('/book-management-admin/{id}', [BookController::class, 'destroy'])->name('admin.books.destroy');
});


use App\Http\Controllers\Admin\CategoryController;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/category-management-admin', [CategoryController::class, 'index'])->name('admin.categories');
    Route::post('/category-management-admin', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::put('/category-management-admin/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/category-management-admin/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
});


use App\Http\Controllers\Admin\ReaderController;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/reader-management-admin', [ReaderController::class, 'index'])->name('admin.readers');
    Route::get('/reader-management-admin/export', [ReaderController::class, 'export'])->name('admin.readers.export');
    Route::put('/reader-management-admin/resetpw/{id}', [ReaderController::class, 'resetPassword'])->name('admin.readers.resetpw');

    Route::put('/reader-management-admin/{id}', [ReaderController::class, 'update'])
        ->name('admin.reader.update');

    Route::delete('/reader-management-admin/{id}', [ReaderController::class, 'destroy'])
        ->name('admin.reader.destroy');
});

use App\Http\Controllers\Admin\BorrowReturnController;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/borrow-return-management-admin', [BorrowReturnController::class, 'manageBorrowReturns'])
        ->name('admin.borrow-returns');

    Route::post('/approve-return/{idChiTiet}', [BorrowReturnController::class, 'approveReturn'])
        ->name('admin.approve-return');

    Route::post('/approve-borrow/{idChiTiet}', [BorrowReturnController::class, 'approveBorrow'])
        ->name('admin.approve-borrow');
});


use App\Http\Controllers\Admin\FineMoneyController;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/finemoney-management-admin', [FineMoneyController::class, 'index'])
        ->name('admin.finemoney.index');

    Route::post('/fines/{id}/update-status', [FineMoneyController::class, 'approveFine'])
        ->name('admin.fines.approve');

    Route::post('/fines/{id}/reject', [FineMoneyController::class, 'rejectFine'])
        ->name('admin.fines.reject');
});


use App\Http\Controllers\HomepageLoginController;

Route::get('/', [HomepageLoginController::class, 'index']);
Route::get('/user/homepage-login-user', [HomepageLoginController::class, 'index'])
    ->name('user.homepage.login');

use App\Http\Controllers\UserAuthController;

Route::prefix('user')->group(function () {
    Route::get('/login-user', [UserAuthController::class, 'showLoginForm'])->name('user.login');
    Route::post('/login-user', [UserAuthController::class, 'login'])->name('user.login.submit');

    Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

    Route::get('/homepage-user', [UserAuthController::class, 'homepage'])
        ->middleware(['auth', 'role:reader']);

    Route::get('/signup-user', [UserAuthController::class, 'showSignupForm'])->name('user.signup');

    Route::post('/signup-user', [UserAuthController::class, 'signup'])->name('user.signup.submit');
});


use App\Http\Controllers\User\HomepageUserController;

Route::middleware(['auth', 'role:reader'])->group(function () {
    Route::get('/user/homepage-user', [HomepageUserController::class, 'index'])
        ->name('user.homepage-user');
});


use App\Http\Controllers\User\SearchBookController;

Route::middleware(['auth', 'role:reader'])->prefix('user')->group(function () {
    Route::get('/search-book-user', [SearchBookController::class, 'index'])
        ->name('user.search-book-user');
});


use App\Http\Controllers\User\BorrowController;

Route::middleware(['auth'])->group(function () {
    Route::post('/borrow-book/{id}', [BorrowController::class, 'borrow'])->name('borrow.book');
    Route::post('/reserve-book/{id}', [BorrowController::class, 'reserve'])->name('reserve.book');
});

use App\Http\Controllers\User\NotificationController;

Route::post('/notification/read/{id}', [NotificationController::class, 'markAsRead'])->name('notification.read');



Route::prefix('user')->middleware('auth')->group(function () {

    Route::get('/trangmuontra(sachdangmuon)', [BorrowController::class, 'index'])->name('user.trangmuontra(sachdangmuon)');

    Route::get('/content-mtra-sachdangmuon', [BorrowController::class, 'contentSachdangMuon'])
        ->name('user.content-mtra-sachdangmuon');

    Route::get('/content-mtra-muonsachmoi', [BorrowController::class, 'contentMuonSachMoi'])
        ->name('user.content-mtra-muonsachmoi');

    Route::post('/borrow-book/{id}', [BorrowController::class, 'borrow'])->name('borrow.book');
    Route::post('/reserve-book/{id}', [BorrowController::class, 'reserve'])->name('reserve.book');

    Route::post('/return-book-btn/{idChiTiet}', [BorrowController::class, 'returnBook'])->name('user.return-book');
});


use App\Http\Controllers\User\DatChoController;

Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::get('/datchosach', [DatChoController::class, 'index'])->name('user.datchosach');
    Route::get('/content-datchosach', [DatChoController::class, 'contentDatChoSach']);
    Route::get('/content-sachhot', [DatChoController::class, 'contentSachHot']);

    Route::post('/datchosach/reserve/{idSach}', [DatChoController::class, 'reserve']);
    Route::post('/datchosach/cancel/{idDatCho}', [DatChoController::class, 'cancel']);
});



use App\Http\Controllers\User\TrangLichSuMuonTraController;

Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::get('/tranglichmuontra', [TrangLichSuMuonTraController::class, 'index'])->name('user.tranglichmuontra');

    Route::get('/content-all-lsmn', [TrangLichSuMuonTraController::class, 'contentAll']);
    Route::get('/content-datra-lsmn', [TrangLichSuMuonTraController::class, 'contentDaTra']);
    Route::get('/content-dangmuon-lsmn', [TrangLichSuMuonTraController::class, 'contentDangMuon']);
    Route::get('/content-tratre-lsmn', [TrangLichSuMuonTraController::class, 'contentTraTre']);
    Route::get('/content-datcho', [TrangLichSuMuonTraController::class, 'contentDatCho']);
});


use App\Http\Controllers\User\UserInfoController;

Route::middleware(['auth'])->group(function () {
    Route::get('/user/info-user', [UserInfoController::class, 'show'])
        ->name('user.info-user');
    Route::post('/user/info/update', [UserInfoController::class, 'update'])
        ->name('user.info.update');
});


use App\Http\Controllers\User\UserSettingController;

Route::middleware(['auth'])->group(function () {
    Route::get('/user/setting-user', [UserSettingController::class, 'showChangePasswordForm'])
        ->name('user.setting-user');

    Route::post('/user/setting-user/change-password', [UserSettingController::class, 'changePassword'])
        ->name('user.setting-user.change-password');
});


use App\Http\Controllers\User\ThanhToanController;

Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::get('trangphat', [ThanhToanController::class, 'index'])->name('user.trangphat');
    Route::get('content-trangphat', [ThanhToanController::class, 'contentThanhToan'])->name('user.content-trangphat');

    Route::post('xac-nhan-thanh-toan', [ThanhToanController::class, 'xacNhanThanhToan'])
        ->name('user.xac-nhan-thanh-toan');
});


use App\Http\Controllers\User\HelpController;

Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::get('/help-user', [HelpController::class, 'index'])->name('user.help');
});

//deploy-ing

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

Route::get('/test-cloudinary', function () {
    try {
        $filePath = public_path('favicon.ico');
        $uploaded = Cloudinary::upload($filePath, [
            'folder' => 'books/test',
            'public_id' => 'test-upload-' . time(),
        ]);

        return response()->json([
            'success' => true,
            'url' => $uploaded->getSecurePath(),
        ]);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ]);
    }
});

use Illuminate\Support\Facades\Artisan;

Route::get('/add-migra', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "Migration chạy xong!";
    } catch (\Exception $e) {
        return "Lỗi khi chạy migration: " . $e->getMessage();
    }
});


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Route::get('/seed-admin', function () {
    DB::table('nguoi_dung')->updateOrInsert(
        ['email' => 'admin2@gmail.com'],
        [
            'hoTen' => 'Quản trị viên 2',
            'matKhau' => Hash::make('123456'),
            'soDienThoai' => '0900000000',
            'diaChi' => 'Hà Nội',
            'vaiTro' => 'admin',
            'ngayDangKy' => now()->toDateString(),
            'trangThai' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]
    );

    return 'Seeder chạy xong!';
});

// Route::get('/db-test', function () {
//     return config('database.connections.mysql.host') . ' | ' .
//            config('database.connections.mysql.database') . ' | ' .
//            config('database.connections.mysql.username');
// });

use App\Http\Controllers\ChatController;

Route::get('partials/chat', [ChatController::class, 'index']);
Route::post('partials/chat/send', [ChatController::class, 'send'])->name('chat.send');

use Illuminate\Support\Facades\Http;

Route::get('/test-ai', function () {

    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'x-goog-api-key' => env('GEMINI_API_KEY'),
    ])->post(
        'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent',
        [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => 'Xin chào, bạn là chatbot thư viện. Hãy giới thiệu ngắn gọn.'
                        ]
                    ]
                ]
            ]
        ]
    );

    if (!$response->successful()) {
        return response()->json([
            'error' => 'HTTP error',
            'status' => $response->status(),
            'body' => $response->json()
        ], 500);
    }

    $data = $response->json();

    if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
        return response()->json([
            'error' => 'Gemini không phản hồi',
            'raw' => $data
        ], 500);
    }

    return response()->json([
        'reply' => $data['candidates'][0]['content']['parts'][0]['text']
    ]);
});