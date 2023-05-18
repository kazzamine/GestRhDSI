<?php

namespace App\Service;

class CommonService
{
    public function calculjourConge($startDate,$endDate,$vacationDays)
    {
        // Initialize the counter
        $days = 0;

        // Loop through each day within the date range
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            // Check if it's a weekend day (Saturday or Sunday)
            if ($currentDate->format('N') >= 6) {
                $currentDate->modify('+1 day');
                continue;
            }

            // Check if it's a vacation day
            if (in_array($currentDate, $vacationDays, true)) {
                $currentDate->modify('+1 day');
                continue;
            }

            // Increment the counter
            $days++;

            // Move to the next day
            $currentDate->modify('+1 day');
        }

        // Return the result
        return $days;
    }


}