<?php

namespace App\Http\Requests;

use App\Models\Item;
use App\Models\Sale;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Throwable;

class SaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['required'],
            'total' => ['sometimes', 'numeric'],
            'cart_items' => ['sometimes','string']
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Customer must be decided',
        ];
    }

    /**
     * Let this function handle the transaction, don\'t peek it if you still wanna be sane
     * ___
     * P.S. Only for `addSale()` method, I\'ve warned you
     * 
     * @deprecated Laravel\'s attach() don\'t approve this
     * @return bool true if success false otherwise
     */
    public function doMagic()
    {
        DB::beginTransaction();
        try {
            $data = $this->only(['cart_items', 'total', 'customer_id']);
            $data['cashier_id'] = $this->user()->id;
            $data['cart_items'] = json_decode($data['cart_items']);
            $data['total'] = (float) $data['total'];
            $collection = collect($data);

            $id_qty = array_column($data['cart_items'], 'qty', 'id');
            $ids = array_keys($id_qty);
            $pivot = collect($ids)->mapWithKeys(fn($id) => [$id => ['qty' => $id_qty[$id]]]);

            $sale = Sale::create($collection->only(['cashier_id', 'customer_id'])->toArray());
            $saleDetail = $sale->detail()->create($collection->only(['total'])->toArray());
            $saleDetail->item()->attach($pivot);

            Item::decrementMany('qty', $id_qty);
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollback();
            return response()->json($e->getMessage());
        }
    }
}
