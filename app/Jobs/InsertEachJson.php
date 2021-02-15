<?php


namespace App\Jobs;


use App\Models\ImportErrors;
use App\Models\LogFile;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

/**
 * Class InsertEachJson
 * @package App\Jobs
 */
class InsertEachJson extends Job
{

    /**
     * Max asynchronous jobs
     *
     * @var int
     */
    public int $max = 5;

    /**
     * Number of
     *
     * @var int
     */
    public int $inProcess;


    private LogFile $logFile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->inProcess = LogFile::where('status', 1)
            ->get()
            ->count();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (! $this->inProcess < $this->max) {
            $this->proceed();
        }
    }

    private function proceed(): void
    {
        $this->setLogFile();

        try {
            $fileContent = Storage::disk('local')->exists($this->logFile['filename']);
            $this->parseFile($fileContent);
        } catch (FileNotFoundException $e) {
            $this->setError([
                'message' => $e->getMessage()
            ], 2);
        }
    }

    public function parseFile(string $content): void
    {

    }

    private function setLogFile(): void
    {
        $this->logFile = LogFile::where('status', 0)
            ->orderBy('created_at', 'ASC')
            ->first();
    }

    private function setError(array $error, string $type): void
    {
        ImportErrors::create([
            'error' => serialize($error),
            'type' => $type,
            'log_file_id' => $this->logFile->id
        ]);
    }
}
