<?php


namespace App\Repositories;


use App\Interfaces\ImportFileRepositoryInterface;
use App\Models\LogFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Class ImportFileRepository
 * @package App\Repositories
 */
class ImportFileRepository implements ImportFileRepositoryInterface
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var JsonResponse
     */
    private JsonResponse $response;

    /**
     * @var array|UploadedFile|UploadedFile[]|null
     */
    private $file;

    /**
     * @var array
     */
    private array $fileData;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function import(Request $request): JsonResponse
    {
        $this->request = $request;

        $this->file = $request->file('file');

        if ($this->validate()) {
            $this->proceed();
        }

        return $this->response;
    }

    /**
     * Set the response body and status code
     *
     * @param array $data
     * @param int $status
     */
    private function setResponse(array $data, int $status = 200): void
    {
        $this->response = response()->json($data, $status);
    }

    /**
     * Validate request
     *
     * @return bool
     */
    private function validate(): bool
    {
        $valid = Validator::make($this->request->toArray(), LogFile::validationRules());

        if ($valid->fails()) {
            $this->setResponse($valid->errors()->toArray(), 403);
            return false;
        }

        return true;
    }

    /**
     * Continue the import flow
     *
     * @return void
     */
    private function proceed(): void
    {
        if (!$this->saveFile()) {
            $this->setResponse([
                'message' => "Wasn't possible to save file"
            ], 500);
            return;
        }

        $logFile = LogFile::create($this->fileData);

        $this->setResponse($logFile->toArray(), 201);
    }

    /**
     * Save file into local storage and set LogFile data
     *
     * @return bool
     */
    private function saveFile(): bool
    {
        $this->fileData = [
            'filename' => $this->setFileName(),
            'status' => 0
        ];
        return Storage::disk('local')->put($this->fileData['filename'], $this->file->getContent());
    }

    /**
     * Mount filename
     *
     * @return string
     */
    private function setFileName(): string
    {
        // 2021/02/d38c15ad-0dfe-4c7d-87c6-9af20ffb9fc5.txt"
        return date('Y/m')
            . '/'
            . Str::uuid()->toString()
            . $this->getFileExtension();
    }

    /**
     * Get file extension to concatenate into filename
     * @return string
     */
    private function getFileExtension(): string
    {
        return '.' . $this->file->extension();
    }
}
