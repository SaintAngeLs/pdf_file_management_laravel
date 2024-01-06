<?php

namespace App\Http\Controllers;
use App\Models\Documents;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $userData = User::all();
        return view('admin.index', [
            'userData' => $userData
        ]);
    }

    public function userDocuments($id)
    {
        $count = Documents::where('user_id', $id)->count();
        $documentData = Documents::where('user_id', $id)->get();
        return view('admin.userdocument', [
            'documentCount' => $count,
            'documentData' => $documentData
        ]);
    }

    public function userCategory($id)
    {
        $role = Auth::user()->role;

        $count = Categories::where('user_id', $id)->count();

        $userCategoryData = Categories::where('user_id', $id)->get();

        return view('admin.usercategory', [
            'categoryCount' => $count,
            'role' => $role,
            'userCategoryData' => $userCategoryData
        ]);
    }


    public function userSpecifyCategory($user_id, $category)
    {
        $categoryid = Categories::where('name', $category)
        ->where('user_id', $user_id)
        ->pluck('id')
        ->first();

        $count = Documents::where('user_id', $user_id)->count();
        $userCategoryData = Documents::where('user_id', $user_id)
        //->where('category_id', $categoryid)
        ->get();
        return view('welcome', [
            'documentCount' => $count,
            'documentData' => $userCategoryData
        ]);
    }




}
