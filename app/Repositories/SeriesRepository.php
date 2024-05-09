<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormsRequest;
use App\Models\Series;

interface SeriesRepository
{
    public function add(SeriesFormsRequest $request): Series;

}