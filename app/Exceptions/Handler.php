<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /* tambah fungsi render untuk menampilkan pesan error ketika percobaan login melebihi 5x,
        fungsi render ini diperlukan karena defaultnya throtle akan me redirect ke halaman error 409
    */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ThrottleRequestsException) {
            return $this->response409($e);
        }

        return parent::render($request, $e);
    }
    public function response409(Throwable $e)
    {
        $errors = new MessageBag();
        $errors->add("message", "Too many requests");
        return response()->json([
            'success' => false,
            'message' => $errors
         ],
            429
        );
    }
}
