<?php

namespace App;

class Process
{
    public string $start_time;
    public string $end_time;

    public function startTimer(): void
    {
        $this->start_time = microtime(true);
    }

    public function stopTimer(): void
    {
        $this->end_time = microtime(true);
    }

    public function getTimeTaken(): float
    {//In seconds
        return ($this->end_time - $this->start_time) * 100;
    }

    public static function paymentTermIntToString(int $term): string
    {
        if ($term === 1) {
            return "p/m";
        } elseif ($term === 2) {
            return "p/qtr";
        } elseif ($term === 3) {
            return "p/hy";
        } elseif ($term === 4) {
            return "p/y";
        } elseif ($term === 5) {
            return "p/2y";
        } elseif ($term === 6) {
            return "p/3y";
        } else {
            return "unknown";
        }
    }
}
