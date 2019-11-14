<?php

namespace Pipeliner;

/**
 * Trait BenchmarkTrait
 *
 * @package Pipeliner
 */
trait BenchmarkTrait
{
    /**
     * @var float
     */
    protected $start;

    /**
     * Records the time when benchmark started
     */
    public function start(): void {
        $this->start = microtime(true);
    }

    /**
     * Records the time when benchmark finished
     */
    public function finish(): string {
        return microtime(true) - $this->start;
    }

    /**
     * Generates pipeliner report
     *
     * @param array $array
     * @param null|string $filename
     */
    public function generateReport($array, $filename = null)
    {
        if(defined('PIPELINER_REPORTING')) {
            if ($filename == null) {
                $filename = 'pipeliner_report_' . time().'.txt';
            }

            $filedata = "";

            foreach($array as $k => $v) {
                if(!empty($filedata)) {
                    $filedata .= "\n";
                }

                $filedata .= "$k: $v s";
            }

            file_put_contents($filename, $filedata);
            copy($filename, __DIR__ . '/../' . $filename);
        }
    }
}