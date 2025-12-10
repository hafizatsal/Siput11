<?php

namespace App\Exceptions;
use App\Exceptions\CustomException;
use Exception;
use DB;
use Auth;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException'
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof CustomException){
          $error_log = array(
            'time_error' => DB::raw('NOW()'),
            'executed_by' => Auth::User()->id,
            'type' => $exception,
          );
          DB::table('error_log')->insert($error_log);
          session()->flash('delete', 'Aksi gagal dijalankan.');
          return back();
        }

        if($this->isHttpException($exception)){
            switch ($exception->getStatusCode()) {
              case 400:
                  $exception->msg = "Bad request";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 401:
                  $exception->msg = "Authorization required";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 403:
                  $exception->msg = "Forbidden request";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 404:
                    $exception->msg = "Not found";
                    return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;
              case 405:
                  $exception->msg = "Method not allowed";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 406:
                  $exception->msg = "Not acceptable";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 407:
                  $exception->msg = "Authorization required";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 408:
                  $exception->msg = "Request timeout";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 409:
                  $exception->msg = "Conflict";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 410:
                  $exception->msg = "Gone";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 411:
                  $exception->msg = "Length required";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 412:
                  $exception->msg = "Precondition failed";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 413:
                  $exception->msg = "Request entity too large";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 414:
                  $exception->msg = "Request URI too large";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 415:
                  $exception->msg = "Unsupported media type";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 416:
                  $exception->msg = "Request range not satisfiable";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 417:
                  $exception->msg = "Expectation failed";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 422:
                  $exception->msg = "Unprocessable entity";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 423:
                  $exception->msg = "Locked";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 424:
                  $exception->msg = "Failed dependency";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 500:
                  $exception->msg = "Internal server error";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 501:
                  $exception->msg = "Not implemented";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 502:
                  $exception->msg = "Bad gateway";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 503:
                  $exception->msg = "Service unavailable";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 504:
                  $exception->msg = "Gateway timeout";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 505:
                  $exception->msg = "Http version not supported";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 506:
                  $exception->msg = "Variant also negotiates";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 507:
                  $exception->msg = "Insufficient storage";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              case 510:
                  $exception->msg = "Not extended";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => $exception->getStatusCode(),'msg' => $exception->msg], $exception->getStatusCode());
              break;

              deafult:
                  $exception->msg = "Unknown error";
                  return response()->view('error.msg', ['title' => "Error" ,'header' => '999','msg' => $exception->msg], 404);
              break;
            }
        }
        return parent::render($request, $exception);
    }
}
