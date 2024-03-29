<?php

namespace App\QueryParameters;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TimetableQueryParameters
{
    /** @var string $period */
    private $semester;

    /** @var string $dividend */
    private $dividend;

    /** @var string $sortBy */
    private $sortBy;

    /** @var Carbon $date */
    private $date;

    /** @var int $day */
    private $day;

    public static $DIVIDEND_NUMERATOR = 'numerator';

    public static $DIVIDEND_DENOMINATOR = 'denominator';

    public static $DIVIDEND_AUTO = 'auto';

    public static $SEMESTER_FIRST = 'first';

    public static $SEMESTER_SECOND = 'second';

    public static $SEMESTER_AUTO = 'auto';

    public function __construct(Request $request = null)
    {
        if (!$request) {
            return;
        }
        $this->dividend = $request->get('dividend') ?: null;
        $this->sortBy = $request->get('sortBy') ?: null;
        $this->day = $request->get('day') ?: null;
        $this->date = $request->get('date') ? new Carbon($request->get('date')) : null;
        $this->semester = $request->get('semester') ?: null;
    }

    /**
     * @return string
     */
    public function getSortBy(): string
    {
        return $this->sortBy;
    }

    /**
     * @param string $sortBy
     */
    public function setSortBy(string $sortBy): void
    {
        $this->sortBy = $sortBy;
    }

    /**
     * @return Carbon
     */
    public function getDate(): ?Carbon
    {
        return $this->date;
    }

    /**
     * @param Carbon $date
     */
    public function setDate(Carbon $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getDividend(): ?string
    {
        return $this->dividend;
    }

    /**
     * @param string $dividend
     */
    public function setDividend(string $dividend): void
    {
        $this->dividend = $dividend;
    }

    /**
     * @return int
     */
    public function getDay(): ?int
    {
        return $this->day;
    }

    /**
     * @param int $day
     */
    public function setDay(int $day): void
    {
        $this->day = $day;
    }

    /**
     * @param string $semester
     */
    public function setSemester(string $semester): void
    {
        $this->semester = $semester;
    }

    public function getSemester(): ?string
    {
        return $this->semester;
    }
}
