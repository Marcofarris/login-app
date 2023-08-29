<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kart;
use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StoricoExport;
use Revolution\Google\Sheets\Facades\Sheets;

class OrdineController extends Controller
{
    //
    public function GetCasse()
    {
        $casse = DB::table('karts')->select('id', 'totale')->get();
       
        return response($casse, 201);
       

    }

    public function CreateOrder(Request $request)
    {
       
        $ordine = Order::create([
            'quantita' => $request->quantita,
            'user_id' => $request->user_id,
            'cassa_id' => $request->cassa_id,
            'price' => $request->price * $request->quantita
        ]);

        
        //Aggiorna totale cassa
        $totale = DB::table('karts')->select('totale')->where('id',$request->cassa_id)->get()[0];
        Kart::where('id',$request->cassa_id)->update(['totale'=>$totale->totale + $request->quantita]);
      

        return response($ordine, 201);       
    }

    public function GetOrders(){
        $ordini = DB::table('orders')->select('id', 'user_id', 'cassa_id', 'quantita', 'price')->get();

        return response($ordini, 201);
    }

    public function ProcessOrder(Request $request){
        //In entrata id ordine -> prendo tutto il record -> Elimino quantita dalla cassa relativa - elimino record ordine
        $ordine = DB::table('orders')->select('quantita', 'price')->where('id',$request->order_id)->get()[0];
        
        
        // Aggiorno cassa
        $totale = DB::table('karts')->select('totale')->where('id',$request->cassa_id)->get()[0];
        
        $prova = Kart::where('id',$request->cassa_id)->update(['totale'=>$totale->totale - $ordine->quantita]);
        
        //Inserisco negli acquisti effettuati
        $ordine = Purchase::create([
            'order_id' => $request->order_id,
            'cassa_id' => $request->cassa_id,
            'user_id' => $request->user_id,
            'quantita' => $ordine->quantita,
            'price' => $ordine->price
        ]);

        // Inserimento su google sheet
        $user = DB::table('users')->select('name')->where('id',$request->user_id)->get()[0];
        
        $rows = [
            [$user->name, $ordine->price]
        ];
        Sheets::spreadsheet('1wANbQyaENBTP3GugOQ4BB4VH5yQZs3aMyPSe-cXzitE')->sheet('Checkout')->append($rows);
        
        //Elimino ordine in coda
        DB::table('orders')->where('id', $request->order_id)->delete();

        return $ordine;

    }

    // Recupero storico, tabella acquisti. Prezzo in funzione della cassa
    public function GetStorico(){
        
            $storico = DB::table('purchases')->select(DB::raw("cassa_id, SUM(price) as totale"))
                               ->groupBy(DB::raw("cassa_id"))
                               ->get();

        return $storico;
    }


    // Stampa Excell Storico
    public function export($user_id){
           
        $storico = DB::table('users')
        ->join('purchases', 'users.id', '=', 'purchases.user_id')
        ->select('users.name' ,'purchases.price')
        ->where('users.id', $user_id)
        ->get();
      
        //$storico = DB::table('purchases')->select('*')->get();

        return Excel::download(new StoricoExport($storico), 'storico.xlsx');
    
    }

}
