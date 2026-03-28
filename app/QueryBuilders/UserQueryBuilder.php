<?php

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function exceptMe(): self
    {
        return $this->whereNot('id', auth()->id());
    }
}
