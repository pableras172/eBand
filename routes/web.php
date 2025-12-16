<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Livewire\Instrument\InstrumentClass;
use App\Livewire\Contratos\ListadoContratos;
use App\Livewire\Configuration\ConfigurationCreate;
use App\Livewire\Configuration\ConfigurationEdit;
use App\Livewire\Configuration\ConfigurationIndex;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ActuacionController;
use App\Http\Controllers\ContratosController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\ListasUsersController;
use App\Http\Controllers\TipoActuacionController;
use App\Http\Controllers\PDFController;
use App\Livewire\Payment\PaymentIndex;
use App\Livewire\Payment\PaymentCreate;
use App\Livewire\Payment\PaymentEdit;
use App\Livewire\Paymentresume\PaymentresumeIndex;
use App\Livewire\Paymentresume\PaymentresumeCreate;
use App\Livewire\Paymentresume\PaymentresumeEdit;
use App\Livewire\Comments\CommentIndex;
use App\Livewire\Comments\CommentCreate;
use App\Livewire\Comments\CommentEdit;
use App\Livewire\Suggestions\SuggestionIndex;
use App\Livewire\Suggestions\SuggestionCreate;
use App\Livewire\Suggestions\SuggestionEdit;
use App\Jobs\SendDailyCommentsNotification;

use Illuminate\Http\Request;

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

/*Route::get('/', function () {
    return view('welcome');
});*/


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'can:admin'])->group(function () {
    Route::resource('contratos', ListadoContratos::class);
    Route::get('/contratos/year/{year}', [ListadoContratos::class, 'contratosPorAnyo'])->name('contratos.anyo');
    //Nueva ruta para duplicar contrato
    Route::get('/contratos/duplicate/{contrato}', [ContratosController::class, 'duplicate'])->name('contratos.duplicate');

    Route::resource('instrument', InstrumentClass::class);
    Route::post('/update-order', [InstrumentClass::class, 'updateOrder'])->name('instrument.updateOrder');

    Route::resource('users', \App\Http\Controllers\UsersController::class);

    Route::resource('tipoactuacion', TipoActuacionController::class);

    Route::get('/configurations', ConfigurationIndex::class)->name('configurations.index');
    Route::get('/configurations/create', ConfigurationCreate::class)->name('configurations.create');
    Route::get('/configurations/{configuration}', ConfigurationEdit::class)->name('configurations.edit');

    Route::get('/paymentresumes', PaymentresumeIndex::class)->name('paymentresumes.index');
    Route::get('/paymentresumes/create', PaymentresumeCreate::class)->name('paymentresumes.create');
    Route::get('/paymentresumes/{paymetresume}', PaymentresumeEdit::class)->name('paymentresumes.edit');

    Route::get('/comments', CommentIndex::class)->name('comments.index');
    Route::get('/comments/create', CommentCreate::class)->name('comments.create');
    Route::get('/comments/{comment}', CommentEdit::class)->name('comments.edit');

    Route::get('/suggestions', SuggestionIndex::class)->name('suggestions.index');
    Route::get('/suggestions/create', SuggestionCreate::class)->name('suggestions.create');
    Route::get('/suggestions/{suggestion}', SuggestionEdit::class)->name('suggestions.edit');

    Route::get('/run-job', function () {
        dispatch(new SendDailyCommentsNotification());
        session()->flash('success', 'El Job se ha ejecutado correctamente.');
        return redirect()->route('comments.index'); // Redirige a la página de comentarios o cualquier otra
    })->name('run.job');
});


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(
    function () {

        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::resource('tasks', \App\Http\Controllers\TasksController::class);
        //Route::resource('users', \App\Http\Controllers\UsersController::class);

        //Route::resource('tipoactuacion',TipoActuacionController::class);

        //Route::resource('instrument',InstrumentClass::class);
        //Route::post('/update-order', [InstrumentClass::class, 'updateOrder'])->name('instrument.updateOrder');

        Route::resource('calendar', CalendarController::class);

        Route::get('/actuacion/createtocontract/{contratos}', [ActuacionController::class, 'createtocontract'])->name('actuacion.createtocontract');

        Route::get('/actuaciones/{user}/{year}', [ActuacionController::class, 'getListadoActuacionesUsuarioAnyo'])
            ->middleware('usuario.activo')
            ->name('actuaciones.usuario.anyo');

        Route::get('/actuaciones/{user}/{year}/{type}', [ActuacionController::class, 'getListadoActuacionesUsuarioAndTipo'])->name('actuaciones.usuario.listatipo');
        Route::get('/actuaciones/{user}/{year}/p/{poblacion}', [ActuacionController::class, 'getActuacionesUsuarioPorPoblacionAnyo'])->name('actuaciones.usuario.poblacion');

        Route::get('/actuaciones/{user}/{year}/e/{poblacion}', [ActuacionController::class, 'getListadoActuacionesUsuarioAnyoTipo'])->name('actuaciones.usuario.estadisticas.tipo');

        Route::get('/descargarCalendario/{actuacionId}', [ActuacionController::class, 'descargarCalendario']);

        Route::get('/actuaciones-tipo/{tipoactuacion}', [ActuacionController::class, 'getActuacionesPorTipo'])->name('actuaciones-tipo');
        Route::get('/actuaciones-fecha/{fechaactuacion}', [ActuacionController::class, 'getActuacionesPorFecha'])->name('actuaciones-fecha');
        Route::get('/actuaciones-poblacion/{poblacion}', [ActuacionController::class, 'getActuacionesPorPoblacion'])->name('actuaciones-poblacion');

        Route::post('/notificaractuacionlista', [ActuacionController::class, 'notificarActuacionLista']);
        Route::post('/notificaractuacion', [ActuacionController::class, 'notificarActuacion']);

        Route::resource('actuacion', ActuacionController::class);

        //Route::resource('contratos',ListadoContratos::class);        
        //Route::get('/contratos/year/{year}',[ListadoContratos::class,'contratosPorAnyo'])->name('contratos.anyo');        

        Route::resource('listas', ListaController::class);

        Route::get('/listas/actuacion/{actuacion_id}', [ListaController::class, 'actuacion'])->name('listas.actuacion');

        Route::post('/listauser', [ListasUsersController::class, 'store']);
        Route::post('/listausercar', [ListasUsersController::class, 'storecar']);
        Route::post('/listauserdisp', [ListasUsersController::class, 'setdisponible']);
        Route::delete('/listauserclean/{listaId}', [ListasUsersController::class, 'clean']);
        Route::delete('/listauser/{listaId}/{usuarioId}', [ListasUsersController::class, 'destroy']);

        Route::get('/usersuuid/{user}', [\App\Http\Controllers\UsersController::class, 'getuuid']);

        Route::get('/generate-pdf/{listaId}', [PDFController::class, 'generatePDF']);

        Route::get('/payments', PaymentIndex::class)->name('payments.index');
        Route::get('/payments/user/{user}', PaymentIndex::class)->name('payments.user');

        Route::get('/payments/create', PaymentCreate::class)->name('payments.create');
        Route::get('/payments/{payment}', PaymentEdit::class)->name('payments.edit');

        Route::get('/pdf/paymentresume/{paymentresume}', [PDFController::class, 'generatePaymentResumePDF'])->name('pdf.paymentresume');

        Route::post('/comments/add', [CommentCreate::class, 'store'])->name('comments.add');

        //Route::get('/paymentresumes', PaymentresumeIndex::class)->name('paymentresumes.index');
        //Route::get('/paymentresumes/create',PaymentresumeCreate::class)->name('paymentresumes.create');
        //Route::get('/paymentresumes/{paymetresume}',PaymentresumeEdit::class)->name('paymentresumes.edit');

        Route::post('/checkout', function (Request $request) {
            $subscriptionPrice = config('cashier.prices.suscription'); // definido en config/cashier.php ('price' => env('CASHIER_PRICE'))
            return $request->user()->checkout(
                [['price' => $subscriptionPrice, 'quantity' => 1]],
                [
                    'mode' => 'subscription',
                    'success_url' => route('stripe.success'),
                    'cancel_url' => route('stripe.cancel'),
                ]
            );
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

//Route::get('/search-contratos', ContratosClass::class);

Route::get('/manifest.json', function () {
    $manifestService = app(\App\Services\ManifestService::class);
    $manifest = $manifestService->generate();

    return response($manifest, 200)
        ->header('Content-Type', 'application/json');
});
