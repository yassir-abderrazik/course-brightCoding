<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LastestScope implements Scope {

    public function apply(Builder $builder, Model $model)
    {
        $builder->orderBy('updated_at', 'desc');
    }
}