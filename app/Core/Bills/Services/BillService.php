<?php

namespace App\Core\Bills\Services;

use App\Http\Bills\Validators\BillValidator;
use App\Http\Controller;
use App\Models\Bill;
use App\Models\PurchasedProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BillService extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Bill::all();
        return $data;
    }

    /**
     * Método para crear o actualizar facturas
     * @param \App\Models\Bill  $bill factura a crear o actualizar
     * @param \Illuminate\Support\Collection  $data información sobre la factura a añadir
     * @return \App\Models\Bill
     */
    public function createOrUpdate(Bill $bill, Collection $data)
    {
        try {
            DB::beginTransaction();
            // Asignación de datos básicos de la factura al modelo
            $bill->number = $data->get('number');
            $bill->emisor_name = $data->get('emisor_name');
            $bill->emisor_nit = $data->get('emisor_nit');
            $bill->buyer_name = $data->get('buyer_name');
            $bill->buyer_nit = $data->get('buyer_nit');
            // Calculo del valor de la factura
            $productsAdded = $data->get('productsList');
            $productsRegistered = $data->get('product_purchases');
            $totalValue = 0;
            $purchasedProductsData = [];
            foreach($productsAdded as $productValue){
                $totalValue += $productValue["quantity"] * $productValue["unit_price"];
                // Por optimización se prepara el arreglo para guardar la compra de productos
                $productPurchased = PurchasedProduct::where('bill_id', $bill->id)->where('product_id', $productValue['id'])->first();
                // Si el usuario no pide el producto (quantity = 0) no se realiza la compra, también si la compra de ese producto no esta registrada 
                // en la base de datos
                if((intval($productValue["quantity"]) !== 0)){
                    if(is_null($productPurchased)){
                        array_push($purchasedProductsData, new PurchasedProduct([
                            'quantity' => $productValue["quantity"],
                            'product_id' => $productValue["id"],
                            'bill_id' => $data->get('id'),
                        ]));
                    }else{
                        $productPurchased->quantity = $productPurchased->quantity + $productValue["quantity"];
                        array_push($purchasedProductsData, $productPurchased);
                    }
                }
            }
            if(!empty($productsRegistered)){
                foreach($productsRegistered as $registeredProduct){
                    $totalValue += $registeredProduct["quantity"] * $registeredProduct["product"]["unit_price"];
                }
            }
            $bill->net_amount = $totalValue;
            $bill->iva = $data->get('iva');
            $bill->bill_purchase_date = Carbon::now();
            $bill->total_net_amount = $totalValue + ($totalValue * (intval($data->get('iva'))/100));
            $bill->save();
            // Asignación de datos de los productos comprados a la factura
            Bill::find($bill->id)->productPurchases()->saveMany($purchasedProductsData);
            DB::commit();
            return $bill;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = collect($request->all());
        // Validar datos de la factura
        $userValidator = new BillValidator();
        $validatedData = $userValidator->createValidatorBill($data);
        if ($validatedData->fails()) {
            return response()->json($validatedData->messages(), 400);
        }

        $this->createOrUpdate(new Bill(), $data);

        return response()->json("success", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function show($id)
    {
        $bill = Bill::with(
            [
                'productPurchases',
                'productPurchases.product'
            ]
        )->findOrFail($id);

        return $bill;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function edit($id)
    {
        $bill = Bill::with('productPurchases', 'productPurchases.product')->findOrFail($id);
        return $bill;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $bill = Bill::find($id);
        $data = collect($request->all());
        //Realizar validación
        $billValidator = new BillValidator();
        $validatedData = $billValidator->updateBillDataValidator($data);
        if ($validatedData->fails()) {
            return response()->json($validatedData->messages(), 400);
        }
        $this->createOrUpdate($bill, $data);

        return response()->json("success", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill $bill
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Bill $bill)
    {
        // - Eliminar Productos comprados de la factura
        $bill->productPurchases()->delete();
        // - Eliminar factura
        $bill->delete();
        return Redirect::to('/back-office/users');
    }
}
