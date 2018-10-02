<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Services\FileService;

class FileController extends Controller
{
    private $fileService;

    /**
     * UtilsController constructor.
     * @param FileService $fileService
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function uploadTmp(Request $request)
    {
        $validator = \Validator::make(['file' =>$request->get('file')], ['file' => 'required|between:0,20000']);
        if($validator->fails()){
            return response()->json([
                'success'=> false,
                'message' => $validator->errors()->first()
            ]);
        }
        $file = $this->fileService->uploadFileToTmp($request->get('file'), $request->get('extension', ''));
        $nameFile = explode('/', $file);

        return response()->json([
            'success' => true,
            'message' => 'Arquivo salvo com sucesso',
            'data' => end($nameFile)
        ]);
    }

    /**
     * @param string $arquivo
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeTmp(string $arquivo)
    {
        $this->fileService->removeFromTmp($arquivo);

        return response()->json([
            'success' => true,
            'message' => 'Arquivo removido com sucesso',
            'data' => $arquivo
        ]);
    }
}
