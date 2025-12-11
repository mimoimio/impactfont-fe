<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        $items = [
            [
                'name' => 'Name',
                'price' => "Mior Muhammad Adib Bin Ahmad Zaha",
            ],
            [
                'name' => 'Matric No',
                'price' => 2319909
            ],
            [
                'name' => 'Aik Cheong Chocolate',
                'price' => 1000
            ],
            [
                'name' => 'Zus Coffee',
                'price' => 2000
            ],
            [
                'name' => 'Kopi Ais Ikat Tepi',
                'price' => 4000
            ],
        ];
        return view('products', ['items' => $items]);
    }
}
