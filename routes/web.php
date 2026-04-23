<?php

use App\Http\Controllers\ActuacionController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContratosController;
use App\Http\Controllers\InventoryExportController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\ListasUsersController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TipoActuacionController;
use App\Http\Controllers\UsersController;
use App\Jobs\SendDailyCommentsNotification;
use App\Livewire\Comments\CommentCreate;
use App\Livewire\Comments\CommentEdit;
use App\Livewire\Comments\CommentIndex;
use App\Livewire\Configuration\ConfigurationCreate;
use App\Livewire\Configuration\ConfigurationEdit;
use App\Livewire\Configuration\ConfigurationIndex;
use App\Livewire\Contratos\ListadoContratos;
use App\Livewire\Instrument\InstrumentClass;
use App\Livewire\Inventory\InventoryCreate;
use App\Livewire\Inventory\InventoryEdit;
use App\Livewire\Inventory\InventoryIndex;
use App\Livewire\Inventory\InventoryShow;
use App\Livewire\Payment\PaymentCreate;
use App\Livewire\Payment\PaymentEdit;
use App\Livewire\Payment\PaymentIndex;
use App\Livewire\Paymentresume\PaymentresumeCreate;
use App\Livewire\Paymentresume\PaymentresumeEdit;
use App\Livewire\Paymentresume\PaymentresumeIndex;
use App\Livewire\Suggestions\SuggestionCreate;
use App\Livewire\Suggestions\SuggestionEdit;
use App\Livewire\Suggestions\SuggestionIndex;
use App\Models\User;
use App\Services\ManifestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Ruta pública para la página de bienvenida
Route::get('/', function () {

    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    // Si enable_features_page no está activo, redirigir a login
    if (! config('app.enable_features_page')) {
        return redirect()->route('login');
    }

    return view('welcome');
})->name('welcome');

// Ruta pública para el formulario de contacto
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'can:admin'])->group(function () {
    Route::resource('contratos', ListadoContratos::class);
    Route::get('/contratos/year/{year}', [ListadoContratos::class, 'contratosPorAnyo'])->name('contratos.anyo');
    // Nueva ruta para duplicar contrato
    Route::get('/contratos/duplicate/{contrato}', [ContratosController::class, 'duplicate'])->name('contratos.duplicate');

    Route::resource('instrument', InstrumentClass::class);
    Route::post('/update-order', [InstrumentClass::class, 'updateOrder'])->name('instrument.updateOrder');

    Route::resource('users', UsersController::class);

    Route::resource('tipoactuacion', TipoActuacionController::class);

    Route::livewire('/configurations', ConfigurationIndex::class)->name('configurations.index');
    Route::livewire('/configurations/create', ConfigurationCreate::class)->name('configurations.create');
    Route::livewire('/configurations/{configuration}', ConfigurationEdit::class)->name('configurations.edit');

    Route::livewire('/paymentresumes', PaymentresumeIndex::class)->name('paymentresumes.index');
    Route::livewire('/paymentresumes/create', PaymentresumeCreate::class)->name('paymentresumes.create');
    Route::livewire('/paymentresumes/{paymetresume}', PaymentresumeEdit::class)->name('paymentresumes.edit');

    Route::livewire('/comments', CommentIndex::class)->name('comments.index');
    Route::livewire('/comments/create', CommentCreate::class)->name('comments.create');
    Route::livewire('/comments/{comment}', CommentEdit::class)->name('comments.edit');

    Route::get('/run-job', function () {
        dispatch(new SendDailyCommentsNotification);
        session()->flash('success', 'El Job se ha ejecutado correctamente.');

        return redirect()->route('comments.index'); // Redirige a la página de comentarios o cualquier otra
    })->name('run.job');

    // Inventory Routes (admin)
    Route::livewire('/inventory/create', InventoryCreate::class)->name('inventory.create');
    Route::livewire('/inventory/{item}/edit', InventoryEdit::class)->name('inventory.edit');
    Route::get('/inventory/export/excel', [InventoryExportController::class, 'excel'])->name('inventory.export.excel');
    Route::get('/inventory/export/pdf', [InventoryExportController::class, 'pdf'])->name('inventory.export.pdf');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(
    function () {

        // Suggestions - available for all authenticated users
        Route::livewire('/suggestions', SuggestionIndex::class)->name('suggestions.index');
        Route::livewire('/suggestions/create', SuggestionCreate::class)->name('suggestions.create');
        Route::livewire('/suggestions/{suggestion}', SuggestionEdit::class)->name('suggestions.edit');

        // Notificaciones
        Route::middleware('auth')->get('/notificaciones', function () {
            /** @var User $user */
            $user = Auth::user();

            return view('notifications.index', [
                'notifications' => $user->notifications()->latest()->paginate(20),
            ]);
        })->name('notifications.index');

        Route::post('/notificaciones/{id}/leer', function ($id) {
            /** @var User $user */
            $user = Auth::user();

            $notification = $user->notifications()->findOrFail($id);
            $notification->markAsRead();

            return back();
        })->name('notifications.read');

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::resource('tasks', TasksController::class);
        // Route::resource('users', \App\Http\Controllers\UsersController::class);

        // Route::resource('tipoactuacion',TipoActuacionController::class);

        // Route::resource('instrument',InstrumentClass::class);
        // Route::post('/update-order', [InstrumentClass::class, 'updateOrder'])->name('instrument.updateOrder');

        Route::resource('calendar', CalendarController::class);

        Route::livewire('/inventory', InventoryIndex::class)->name('inventory.index');
        Route::livewire('/inventory/{item}', InventoryShow::class)->name('inventory.show');

        Route::get('/actuacion/createtocontract/{contratos}', [ActuacionController::class, 'createtocontract'])->name('actuacion.createtocontract');

        Route::get('/actuaciones/{user}/{year}', [ActuacionController::class, 'getListadoActuacionesUsuarioAnyo'])
            ->middleware('usuario.activo')
            ->name('actuaciones.usuario.anyo');

        Route::get('/actuaciones/{user}/{year}/{type}', [ActuacionController::class, 'getListadoActuacionesUsuarioAndTipo'])->name('actuaciones.usuario.listatipo');
        Route::get('/actuaciones/{user}/{year}/p/{poblacion}', [ActuacionController::class, 'getActuacionesUsuarioPorPoblacionAnyo'])->name('actuaciones.usuario.poblacion');

        Route::get('/actuaciones/{user}/{year}/e/{poblacion}', [ActuacionController::class, 'getListadoActuacionesUsuarioAnyoTipo'])->name('actuaciones.usuario.estadisticas.tipo');

        Route::get('/descargarCalendario/{actuacionId}', [ActuacionController::class, 'descargarCalendario']);

        Route::get('/actuaciones-tipo/{tipoactuacion}', [ActuacionController::class, 'getActuacionesPorTipo'])->name('actuaciones-tipo');
        Route::get('/actuaciones-fecha', [ActuacionController::class, 'getActuacionesPorFecha'])->name('actuaciones-fecha');
        Route::get('/actuaciones-poblacion/{poblacion}', [ActuacionController::class, 'getActuacionesPorPoblacion'])->name('actuaciones-poblacion');

        Route::post('/notificaractuacionlista', [ActuacionController::class, 'notificarActuacionLista']);
        Route::post('/notificaractuacion', [ActuacionController::class, 'notificarActuacion']);

        Route::get('/api/user-stats', [ActuacionController::class, 'getUserStats'])->name('user.stats');
        Route::get('/api/tipoactuacions', [TipoActuacionController::class, 'getTipos'])->name('tipoactuacions.list');

        Route::resource('actuacion', ActuacionController::class);
        Route::get('/api/ubicaciones-contratos', [ActuacionController::class, 'ubicacionesContratos']);

        // Route::resource('contratos',ListadoContratos::class);
        // Route::get('/contratos/year/{year}',[ListadoContratos::class,'contratosPorAnyo'])->name('contratos.anyo');

        Route::resource('listas', ListaController::class);

        Route::get('/listas/actuacion/{actuacion_id}', [ListaController::class, 'actuacion'])->name('listas.actuacion');

        Route::post('/listauser', [ListasUsersController::class, 'store']);
        Route::post('/listausercar', [ListasUsersController::class, 'storecar']);
        Route::post('/listauserdisp', [ListasUsersController::class, 'setdisponible']);
        Route::delete('/listauserclean/{listaId}', [ListasUsersController::class, 'clean']);
        Route::delete('/listauser/{listaId}/{usuarioId}', [ListasUsersController::class, 'destroy']);

        Route::get('/usersuuid/{user}', [UsersController::class, 'getuuid']);

        Route::get('/generate-pdf/{listaId}', [PDFController::class, 'generatePDF']);

        Route::livewire('/payments', PaymentIndex::class)->name('payments.index');
        Route::livewire('/payments/user/{user}', PaymentIndex::class)->name('payments.user');

        Route::livewire('/payments/create', PaymentCreate::class)->name('payments.create');
        Route::livewire('/payments/{payment}', PaymentEdit::class)->name('payments.edit');

        Route::get('/pdf/paymentresume/{paymentresume}', [PDFController::class, 'generatePaymentResumePDF'])->name('pdf.paymentresume');

        Route::post('/comments/add', [CommentCreate::class, 'store'])->name('comments.add');

        // Route::get('/paymentresumes', PaymentresumeIndex::class)->name('paymentresumes.index');
        // Route::get('/paymentresumes/create',PaymentresumeCreate::class)->name('paymentresumes.create');
        // Route::get('/paymentresumes/{paymetresume}',PaymentresumeEdit::class)->name('paymentresumes.edit');

        Route::post('/checkout', function (Request $request) {
            $price = config('cashier.prices.suscription');

            return $request->user()
                ->newSubscription('default', $price)
                ->checkout([
                    'success_url' => route('stripe.success'),
                    'cancel_url' => route('stripe.cancel'),
                ]);
        })->name('checkout');

        Route::post('/donation', function (Request $request) {
            $donationPrice = config('cashier.prices.donation') ?? config('cashier.price'); // fallback si no hay precio específico

            return $request->user()->checkout(
                [['price' => $donationPrice, 'quantity' => 1]],
                [
                    'mode' => 'payment',
                    'success_url' => route('stripe.success'),
                    'cancel_url' => route('stripe.cancel'),
                ]
            );
        })->name('donation');

        Route::view('/stripe/success', 'stripe.success')->name('stripe.success');
        Route::view('/stripe/cancel', 'stripe.cancel')->name('stripe.cancel');

        Route::get('/billing-portal', function (Request $request) {
            return $request->user()->redirectToBillingPortal(route('dashboard'));
        });

        Route::get('/calculadora', function () {
            return redirect('/testmont_v2_mobile.php');
        })->name('calculadora');
    }
);

/*
Route::group(['middleware' => 'auth'],
    function () {
    Route::resource('tasks', \App\Http\Controllers\TasksController::class);
    Route::resource('users', \App\Http\Controllers\UsersController::class);

    Route::resource('instrument',InstrumentClass::class);
    Route::resource('calendar',CalendarController::class);

    Route::get('/actuacion/createtocontract/{contratos}', [ActuacionController::class, 'createtocontract'])->name('actuacion.createtocontract');
    Route::resource('actuacion',ActuacionController::class);

    Route::resource('contratos',ListadoContratos::class);

    Route::resource('listas',ListaController::class);

    Route::get('/listas/actuacion/{actuacion_id}', [ListaController::class, 'actuacion'])->name('listas.actuacion');

    Route::post('/listauser', [ListasUsersController::class, 'store']);
    Route::delete('/listauser/{listaId}/{usuarioId}', [ListasUsersController::class, 'destroy']);


});
*/

/*Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['ca_VL', 'es'])) {
        abort(400);
    }

    App::setLocale($locale);
    return view('dashboard');
});*/

Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['ca_VL', 'es'])) {
        abort(400);
    }

    // Establecer la cookie de preferencia de idioma
    $response = redirect()->route('dashboard')->withCookie(cookie('locale', $locale, 30 * 24 * 60));

    return $response;
});

// Route::get('/search-contratos', ContratosClass::class);

Route::get('/manifest.json', function () {
    $manifestService = app(ManifestService::class);
    $manifest = $manifestService->generate();

    return response($manifest, 200)
        ->header('Content-Type', 'application/json');
});
