<?php

use App\Exceptions\PharmacyApi;
use \Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Response;

if (!function_exists('responseApi')) {

    function responseApi(
        ?int $code = 200,
        ?string $title = "",
        ?string $message = "",
        mixed  $data = [],
        ?array $otherData = [],
        ?array $filter = [],
        ?int $line = 0,
        ?string $file = "",
        ?string $codeError = "",
        ?string $messageError = ""

    ): array {

        return [
            "status" => $code == 200 || $code == 201,
            "code" => $code ?? 400,
            "data" => $data ?? [],
            "otherData" => $otherData ?? [],
            "filter" => $filter ?? [],
            "title" => $title ?? "",
            "message" => $message ?? "",
            "codeError" => $codeError ?? "",
            "messageError" => $messageError ?? "",
            "line" => $line ?? 0,
            "file" => $file ?? "",
        ];
    }
}

if (!function_exists('responseOfErrors')) {

    function responseOfErrors(\Throwable $e): array
    {

        //dd($e);

        $codeHttpServer = Response::HTTP_INTERNAL_SERVER_ERROR;
        $file = $e->getFile();
        $message = $e->getMessage();
        $code = $e->getCode();
        $line = $e->getLine();
        $trace = $e->getTrace();

        $errors = [];

        $codeCustom = $code;
        $messageCustom = "¡Vaya! Algo salió mal. Estamos trabajando en ello. Por favor, intenta de nuevo más tarde.";

        //$messageCustom = $message;

        if ($e instanceof MethodNotAllowedHttpException) {
            $codeHttpServer = Response::HTTP_METHOD_NOT_ALLOWED;
            $messageCustom = "El método utilizado no es permitido para esta solicitud. Verifica si estás usando el método correcto y vuelve a intentarlo.";
        } elseif ($e instanceof NotFoundHttpException) {
            $codeHttpServer = Response::HTTP_NOT_FOUND;
            $messageCustom = "El recurso que estás buscando no existe. Por favor, verifica la url o contacta con el administrador.";
        } elseif ($e instanceof AuthorizationException) {
            $codeHttpServer = Response::HTTP_FORBIDDEN;
            $messageCustom = "No tienes los permisos necesarios para realizar esta acción. Si crees que esto es un error, por favor contacta al administrador.";
        } elseif ($e instanceof ValidationException) {
            $codeHttpServer = Response::HTTP_UNPROCESSABLE_ENTITY;
            $messageCustom = $message;
        } elseif ($e instanceof ValidationException) {
            $codeHttpServer = Response::HTTP_UNPROCESSABLE_ENTITY;
            $messageCustom = $message;
        }
        // elseif ($e instanceof PharmacyApiException) {
        //     $codeHttpServer = Response::HTTP_NOT_FOUND;
        //     $codeCustom = $e->getCodeOther();
        //     $messageCustom = $e->getMessageOther();
        // }

        return [
            'status' => false,
            'message' => $messageCustom,  // mensaje para usuario final
            'errors' => $errors,
            'codeHttp' => $codeHttpServer,  // codigo de rest full
            'codeError' => $codeCustom, // codigo (personalizado) de errores de exepciones
            'messageError' => $message, // mensaje original de errores
            'line' => $line,
            'file' => $file,
            'trace' => $trace,
        ];
    }
}
