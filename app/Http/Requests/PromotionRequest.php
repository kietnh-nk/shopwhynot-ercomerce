<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép tất cả request (hoặc custom theo role)
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'discount' => $this->discount ? str_replace('.', '', $this->discount) : null,
            'minimum_amount' => $this->minimum_amount ? str_replace('.', '', $this->minimum_amount) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'image'          => 'required',
            'description'    => 'nullable|string', // Cho phép null
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after:start_date',
            'discount'       => 'required|numeric|min:0',
            'minimum_amount' => 'required|numeric|min:0|gt:discount', // 👈 Đơn hàng tối thiểu > discount
            'usage_limit'    => 'required|integer|min:1',
            'apply_for'      => 'required|in:specific_products,freeship,all',
            'status'         => 'required|in:active,inactive',
            'product_id'     => 'nullable|exists:products,id|required_if:apply_for,specific_products',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'           => 'Bạn chưa nhập tên giảm giá.',
            'image.required'          => 'Bạn chưa chọn ảnh cho giảm giá.',
            'start_date.required'     => 'Bạn chưa chọn ngày bắt đầu.',
            'end_date.required'       => 'Bạn chưa chọn ngày kết thúc.',
            'end_date.after'          => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'discount.required'       => 'Bạn chưa nhập giá trị giảm.',
            'minimum_amount.required' => 'Bạn chưa nhập đơn hàng tối thiểu.',
            'minimum_amount.gt'       => 'Đơn hàng tối thiểu phải lớn hơn giá trị chiết khấu.',
            'usage_limit.required'    => 'Bạn chưa nhập số lượng giảm giá.',
            'apply_for.required'      => 'Bạn chưa chọn áp dụng.',
            'product_id.required_if'  => 'Bạn chưa chọn sản phẩm.',
        ];
    }
}
