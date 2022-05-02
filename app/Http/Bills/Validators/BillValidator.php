<?php

namespace App\Http\Bills\Validators;

use App\Domain\Core\Backoffice\Users\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class BillValidator
{
    /**
     * Método para validar la información de la factura
     * @param \Illuminate\Support\Collection  $data información sobre la factura a validar
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function createValidatorBill(Collection $data)
    {
        return Validator::make($data->toArray(), [
            'number' => 'required|numeric|unique:bills,number|gt:0',
            'emisor_name' => 'required|string|min:1',
            'emisor_nit' => 'string',
            'buyer_name' => 'required|string|min:1',
            'buyer_nit' => 'string',
            'iva' => 'required|min:1|max:100|numeric|gt:0',
            'productsList.*.quantity' => 'required|numeric',
        ]);
    }

    /**
     * Método para validar la información de la factura a la hora de actualizar
     * @param \Illuminate\Support\Collection  $data información sobre la factura a validar
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function updateBillDataValidator(Collection $data)
    {
        return Validator::make($data->toArray(), [
            'number' => ['required', 'numeric', Rule::unique('bills', 'number')->ignore($data->get('id')), 'gt:0'],
            'emisor_name' => 'required|string|min:1',
            'emisor_nit' => 'string',
            'buyer_name' => 'required|string|min:1',
            'buyer_nit' => 'string',
            'iva' => 'required|min:1|max:100|numeric|gt:0',
            'productsList.*.quantity' => 'required|numeric',           
        ]);
    }
}
