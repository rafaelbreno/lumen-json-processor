<?php


namespace App\Http\Controllers;


use App\Interfaces\ImportFileRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImportFileController extends Controller
{
    /**
     * @var ImportFileRepositoryInterface
     */
    private ImportFileRepositoryInterface $repository;

    public function __construct(ImportFileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function import(Request $request): JsonResponse
    {
        return $this->repository->import($request);
    }
}
