<?php

namespace App\Http\Bills\Controllers;

use App\Core\Bills\Services\BillService;
use App\Models\Bill;
use Illuminate\Http\Request;
use App\Http\Controller;

class BillsController extends Controller
{
    /**
     * Controlador para llamar el servicio de facturas para mostrar todos las facturas
     * @return \Illuminate\Http\Response
     */
    public function index(BillService $billService, Request $request)
    {
        return $billService->index($request);
    }

    /**
     * Controlador para llamar el servicio de facturas para guardar un usuario
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BillService $billService, Request $request)
    {
        return $billService->store($request);
    }

    /**
     * Controlador para llamar el servicio de facturas para mostrar la información de una factura
     * @return \Illuminate\Http\Response
     */
    public function show(BillService $billService, int $id)
    {
        $bill = $billService->show($id);
        // Retornar respuesta con todos los datos asociados a la factura
        return $bill;
    }

    /**
     * Controlador para llamar el servicio de facturas para retornar los datos de la factura en la edición
     * @return \Illuminate\Http\Response
     */
    public function edit(BillService $billService, int $id)
    {
        $bill = $billService->edit($id);
        return $bill;
    }

    /**
     * Controlador para llamar el servicio de facturas para guardar la actualización de una factura
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BillService $billService, int $id, Request $request)
    {
        return $billService->update($request, $id);
    }

    /**
     * Controlador para llamar el servicio de facturas para eliminar una factura
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(BillService $billService, int $id)
    {
        $bill = Bill::find($id);
        return $billService->destroy($bill);
    }
}
