<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;
class SpredsheetController extends Controller
{

    public function addsheetdata(Request $request) {
        $rows = [
            [$request->user_name, $request->price]
        ];
        Sheets::spreadsheet('1wANbQyaENBTP3GugOQ4BB4VH5yQZs3aMyPSe-cXzitE')->sheet('Checkout')->append($rows);
       
    }
}
