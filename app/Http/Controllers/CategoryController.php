<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function show(Request $request, CategoryService $service)
    {
        $search = $request->get('search');

        $categories = $service->getListWithSearch($search);

        return $categories;
    }
    public function delete(Request $request, CategoryService $service)
    {
        $itemId = $request->get('itemId');

        return $service->deleteCategory($itemId);
    }

    public function edit(Request $request, CategoryService $service)
    {
        $itemId = $request->get('itemId');
        $newValue = $request->get('value');

        return $service->editCategory($itemId, $newValue);
    }
}
