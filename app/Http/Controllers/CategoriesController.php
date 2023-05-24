<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoriesServices;

class CategoriesController extends Controller
{
    public function show(Request $request, CategoriesServices $service)
    {
        $search = $request->get('search');

        $categories = $service->getListWithSearch($search);
        
        return $categories;
    }
    public function delete(Request $request, CategoriesServices $service)
    {
        $itemId = $request->get('itemId');
        
        return $service->deleteCategory($itemId);
    }

    public function edit(Request $request, CategoriesServices $service)
    {
        $itemId = $request->get('itemId');
        $newValue = $request->get('value');
        
        return $service->editCategory($itemId, $newValue);
    }
}
