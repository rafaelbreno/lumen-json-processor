<?php


namespace App\Jobs;


use App\Models\ImportErrors;
use App\Models\LogFile;
use App\Repositories\LogRepository;
use Exception;
use Illuminate\Http\JsonResponse;

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

    private bool $have_error = false;

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
        if ( !$this->setLogFile() ) {
            return;
        }
        $this->readFile();
    }

    private function readFile(): void
    {
        try {
            $this->file = fopen(storage_path("app/" . $this->logFile['filename']), 'r');
        } catch (Exception $e) {
            $this->setError([
                'message' => $e->getMessage()
            ], LogFile::FOUND_ERRORS);
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

        $this->logFileUpdate(
            ($this->have_error)
                ? LogFile::FOUND_ERRORS // Finished with Errors
                : LogFile::FINISHED // Finished without errors
        );
    }

    private function parseLine($line): void
    {
        $logData = (json_decode($line, true));

        $errors = (new LogRepository($logData))->createAndGetError();

        if ($errors != []) {
            $this->setError($errors, 0);
        }
    }

    private function setLogFile(): bool
    {
        $logFile = LogFile::where('status', 0)
            ->orderBy('created_at', 'ASC')
            ->first();

        if (is_null($logFile)) {
            return false;
        }

        $this->logFile = $logFile;

        if (is_null($this->logFile)) {
            return false;
        }
        // Updating to Processing
        $this->logFileUpdate(LogFile::PROCESSING);
        return true;
    }

    private function setError(array $error, int $type): void
    {
        if (!$this->have_error) {
            $this->have_error = true;
        }

        ImportErrors::create([
            'error' => serialize($error),
            'type' => $type,
            'log_file_id' => $this->logFile->id
        ]);
    }

    private function logFileUpdate(int $status): void
    {
        $this->logFile->update([
            'status' => $status
        ]);
    }
}
