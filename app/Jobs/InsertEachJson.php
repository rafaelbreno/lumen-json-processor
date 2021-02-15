<?php


namespace App\Jobs;


use App\Models\ImportErrors;
use App\Models\LogFile;
use Exception;

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
     * @var false|resource
     */
    private $file;

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

    public function __destruct()
    {
        $this->file = null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->inProcess < $this->max) {
            $this->proceed();
        }
    }

    private function proceed(): void
    {
        $this->setLogFile();

        $this->readFile();
    }

    private function readFile(): void
    {
        try {
            $this->file = fopen(storage_path("app/" . $this->logFile['filename']), 'r');
        } catch (Exception $e) {
            $this->setError([
                'message' => $e->getMessage()
            ], 2);
            return;
        }

        $this->readLines();
    }

    // Todo: implement
    private function readLines(): void
    {
        while (($line = fgets($this->file)) !== false) {
            $this->parseLine($line);
        }

        fclose($this->file);
    }

    private function parseLine($line): void
    {
        $logData = (json_decode($line, true));
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
