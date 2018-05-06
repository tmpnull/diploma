<?php

namespace App\QueryParameters;


use Carbon\Carbon;
use Illuminate\Http\Request;

class TimetableQueryParameters
{
    /** @var string $filterByPeriod */
    private $filterByPeriod;

    /** @var string $filterByDate */
    private $filterByDate;

    /** @var string $sortBy */
    private $sortBy;

    /** @var Carbon $date */
    private $date;


    public function __construct(Request $request = null)
    {
        if (!$request) {
            return;
        }
        $this->filterByPeriod = $request->get('period') ?: 'week';
        $this->filterByDate = $request->get('dividend') ?: null;
        $this->sortBy = $request->get('sortBy') ?: null;
        $this->date = new Carbon($request->get('date'));
    }

    /**
     * @return string | null
     */
    public function getFilterBy(): ?string
    {
        return $this->filterByPeriod;
    }

    /**
     * @param string $filterBy
     */
    public function setFilterBy(string $filterBy): void
    {
        $this->filterByPeriod = $filterBy;
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
    public function getDate(): Carbon
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
    public function getFilterByDate(): ?string
    {
        return $this->filterByDate;
    }

    /**
     * @param string $filterByDate
     */
    public function setFilterByDate(string $filterByDate): void
    {
        $this->filterByDate = $filterByDate;
    }
}