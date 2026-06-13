<?php
namespace App\Services;

class PipCalculatorService
{
    /**
     * Calculate pips/points between two prices for a given pair/direction.
     * For entry ranges, returns the BIGGER value (Wealthora rule).
     */
    public function calculate(
        string $pair,
        string $direction,
        float  $entryMin,
        float  $entryMax = null,
        float  $target = null,
        string $resultType = 'T1'  // T1|T2|T3|SL|BE
    ): float {
        if ($resultType === 'BE') return 0;

        $entryMax = $entryMax ?? $entryMin;

        if ($resultType === 'SL') {
            // SL: negative, use entry_min for worst case
            return -abs($this->rawDiff($pair, $entryMin, $target ?? 0));
        }

        // For TP: calculate from both entries, pick bigger
        $pip1 = $this->rawDiff($pair, $entryMin, $target ?? 0, $direction);
        $pip2 = $this->rawDiff($pair, $entryMax, $target ?? 0, $direction);

        return max($pip1, $pip2);
    }

    private function rawDiff(string $pair, float $entry, float $target, string $direction = 'BUY'): float
    {
        $multiplier = $this->multiplier($pair);
        $diff = $direction === 'BUY'
            ? ($target - $entry)
            : ($entry - $target);
        return round(abs($diff) * $multiplier, 1);
    }

    private function multiplier(string $pair): int
    {
        // JPY pairs
        if (str_contains(strtoupper($pair), 'JPY')) return 100;

        // Metals, indices, crypto — use points (x1)
        $points = ['XAU','XAG','NAS','US30','SPX','BTC','ETH','OIL','WTI'];
        foreach ($points as $p) {
            if (str_contains(strtoupper($pair), $p)) return 1;
        }

        // Standard forex
        return 10000;
    }
}
