<?php

namespace App\Repositories\Admin;

use App\Models\BlogCategory;

class BlogCategoryRepository
{
    public function all()
    {
        return BlogCategory::orderBy('id', 'asc')->get();
    }

}
