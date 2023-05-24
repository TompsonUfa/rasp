<?php

namespace App\Services;

use App\Models\Category;

class CategoriesServices
{
    public function getListWithSearch($search)
    {
        if (empty($search)){
            $Categories = Category::get(); 
        } else {
            $Categories = Category::where('title', 'LIKE', '%' . $search . '%')->get(); 
        }
        return $Categories;
    }

    public function deleteCategory($id)
    {
        $Category = Category::find($id);

        $Category->delete();
    }

    public function editCategory($id, $value)
    {
        $Category = Category::find($id);
        $Category->title = $value;

        $Category->save();
    }
}
