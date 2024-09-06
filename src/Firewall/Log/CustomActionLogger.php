<?php
declare(strict_types=1);
namespace WPShieldon\Firewall\Log;
use DateInterval;
use DatePeriod;
use DateTime;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use function date;
use function explode;
use function file_exists;
use function file_put_contents;
use function is_dir;
use function is_resource;
use function is_writable;
use function mkdir;
use function rmdir;
use function strtotime;
use function umask;
use function unlink;

final class CustomActionLogger {
    /**
     * The directory that data files stored to.
     */
    protected string $directory = '/tmp/';
    /**
     * The file's extension name.
     */
    protected string $extension = 'log';
    /**
     * The file name.
     */
    protected string $file = '';
    /**
     * The file path.
     */
    protected string $filePath = '';

    public function __construct(string $directory = '', string $Ymd = '') {
        if ($directory !== '') {
            $this->directory = $directory;
        }
        $this->checkDirectory();
        if ($Ymd === '') {
            $Ymd = date('Ymd');
        }
        $this->file = $Ymd . '.' . $this->extension;
        $this->filePath = rtrim($this->directory, '/') . '/' . $this->file;
    }

    protected function checkDirectory(): bool {
        $result = true;
        if (!is_dir($this->directory)) {
            $originalUmask = umask(0);
            $result = mkdir($this->directory, 0777, true);
            umask($originalUmask);
        }
        if (!is_writable($this->directory)) {
            throw new RuntimeException('The directory usded by CustomActionLogger must be writable. (' . $this->directory . ')');
        }
        return $result;
    }

    public function add(array $record) {
        if (!empty($record['session_id'])) {
            $record['session_id'] = substr($record['session_id'], 0, 4);
        }
        $data = [];
        //      $data[0] = $record['ip'] ?? 'null';
        //      $data[1] = $record['session_id'] ?? 'null';
        //      $data[2] = $record['action_code'] ?? 'null';
        //      $data[3] = $record['timestamp'] ?? 'null';
        $data[0] = $record['timestamp'] ?? 'null';
        $data[1] = date('Y-m-d H:i:s', (int)$record['timestamp']);
        $data[2] = $record['ip'] ?? 'null';
        $data[3] = $record['session_id'] ?? 'null';
        $data[4] = $record['action_code'] ?? 'null';
        $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data[5] = $actual_link;
        file_put_contents($this->filePath, implode(',', $data) . "\n", FILE_APPEND | LOCK_EX);
    }

    /**
     * Get data from log file.
     * @param string $fromYmd The string in Ymd Date format.
     * @param string $toYmd The end date.
     * @throws \Exception
     */
    public function get(string $fromYmd = '', string $toYmd = ''): array {
        $results = [];
        if ($toYmd === '') {
            $results = $this->getDataFromSingleDate($fromYmd);
        }
        else {
            $results = $this->getDataFromRange($fromYmd, $toYmd);
        }
        return $results;
    }

    /**
     * Get data from log file.
     * @param string $fromYmd The string in Ymd Date format.
     */
    private function getDataFromSingleDate(string $fromYmd = ''): array {
        $results = [];
        $fromYmd = date('Ymd', strtotime($fromYmd));
        $this->file = $fromYmd . '.' . $this->extension;
        $this->filePath = rtrim($this->directory, '/') . '/' . $this->file;
        if (file_exists($this->filePath)) {
            $logFile = fopen($this->filePath, 'r');
            if (is_resource($logFile)) {
                while (!feof($logFile)) {
                    $line = fgets($logFile);
                    if (!empty($line)) {
                        $data = explode(',', trim($line));
                        $results[] = [
                            'timestamp'   => $data[0], 'datetime' => $data[1], 'ip' => $data[2],
                            'session_id'  => $data[3], 'action_code' => $data[4],
                        ];
                    }
                    unset($line, $data);
                }
                fclose($logFile);
            }
        }
        return $results;
    }

    /**
     * Get data from log files.
     * @param string $fromYmd The string in Ymd Date format.
     * @param string $toYmd The end date.
     * @return array
     * @throws \Exception
     */
    private function getDataFromRange(string $fromYmd = '', string $toYmd = ''): array {
        $results = [];
        // for quering date range.
        $fromYmd = date('Ymd', strtotime($fromYmd));
        $toYmd = date('Ymd', strtotime($toYmd));
        $begin = new DateTime($fromYmd);
        $end = new DateTime($toYmd);
        $end = $end->modify('+1 day');
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);
        foreach ($daterange as $date) {
            $thisDayLogFile = $this->directory . '/' . $date->format('Ymd') . '.' . $this->extension;
            if (file_exists($thisDayLogFile)) {
                $logFile = fopen($thisDayLogFile, 'r');
                if (is_resource($logFile)) {
                    while (!feof($logFile)) {
                        $line = fgets($logFile);
                        if (!empty($line)) {
                            $data = explode(',', trim($line));
                        }
                        if (!empty($data[0])) {
                            $results[] = [
                                'timestamp'  => $data[0], 'datetime' => $data[1], 'ip' => $data[2],
                                'session_id' => $data[3], 'action_code' => $data[4],
                            ];
                        }
                        unset($line, $data);
                    }
                    fclose($logFile);
                }
            }
        }
        return $results;
    }

    public function getDirectory(): string {
        return $this->directory;
    }

    public function purgeLogs() {
        // Remove them recursively.
        if (file_exists($this->directory)) {
            $it = new RecursiveDirectoryIterator($this->directory, FilesystemIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file) {
                if ($file->isDir()) {
                    rmdir($file->getRealPath());
                }
                else {
                    unlink($file->getRealPath());
                }
            }
            unset($it, $files);
            if (is_dir($this->directory)) {
                rmdir($this->directory);
            }
        }
    }

    public function getCurrentLoggerInfo(): array {
        $data = [];
        if (file_exists($this->directory)) {
            $it = new RecursiveDirectoryIterator($this->directory, FilesystemIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file) {
                if ($file->isFile()) {
                    $key = $file->getBasename('.log');
                    $size = $file->getSize();
                    // Data: datetime => file size.
                    $data[$key] = $size;
                }
            }
        }
        return $data;
    }
}