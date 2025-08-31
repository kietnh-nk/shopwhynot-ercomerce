<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Product;


class UpdateProductRequest extends FormRequest
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
        // Lấy slug từ route
        $slug = $this->route('slug');

        // Tìm product theo slug
        $product = Product::where('slug', $slug)->first();

        $productId = $product ? $product->id : null;

        return [
            'name' => 'required|max:255',
            'slug' => [
                'required',
                'max:255',
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'price' => 'required|numeric|min:0',
            'product_catalogue_id' => 'required|array|min:1',
            'brand_id' => 'required|exists:brands,id',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên sản phẩm.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'slug.required' => 'Đường dẫn slug là bắt buộc.',
            'slug.string' => 'Đường dẫn slug phải là chuỗi ký tự.',
            'slug.max' => 'Đường dẫn slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác.',

            'sku.required' => 'SKU chung cho sản phẩm là bắt buộc.',
            'sku.string' => 'SKU phải là chuỗi ký tự.',
            'sku.max' => 'SKU không được vượt quá 255 ký tự.',
            'sku.unique' => 'SKU này đã tồn tại, vui lòng nhập SKU khác.',

            'product_catalogue_id.required' => 'Vui lòng chọn nhóm sản phẩm.',
            'brand_id.gt' => 'Vui lòng chọn thương hiệu.',

            'price.required' => 'Bạn chưa nhập giá sản phẩm.',
            'price.numeric' => 'Giá tiền phải là số.',
            'price.min' => 'Giá tiền phải lớn hơn 0.',

            'short_desc.max' => 'Mô tả ngắn không được vượt quá 255 ký tự.',
            'info.max' => 'Thông tin không được vượt quá 255 ký tự.',
        ];
    }
}
