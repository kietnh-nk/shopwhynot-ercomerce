<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:products,slug',
            'info' => 'nullable|max:255',
            'description' => 'nullable|string',
            'product_catalogue_id' => 'required|array|min:1',
            'product_catalogue_id.*' => 'exists:product_catalogues,id',
            'instock' => 'required|integer|min:0',
            'brand_id' => 'required|exists:brands,id',
            'sku'=> 'required|string|max:255|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'del' => 'nullable|numeric|min:0',
            'publish' => 'nullable|in:0,1',
            'is_hot' => 'nullable|in:0,1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'album.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'attribute' => 'nullable|array',
            'variant' => 'nullable|array'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên sản phẩm.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'slug.required' => 'Đường dẫn slug là bắt buộc.',
            'slug.max' => 'Đường dẫn slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Đường dẫn đã tồn tại. Vui lòng chọn đường dẫn khác.',
            'info.max' => 'Thông tin không được vượt quá 255 ký tự.',
            'product_catalogue_id.required' => 'Vui lòng chọn ít nhất một danh mục sản phẩm.',
            'product_catalogue_id.array' => 'Danh mục sản phẩm phải là một mảng.',
            'product_catalogue_id.min' => 'Vui lòng chọn ít nhất một danh mục sản phẩm.',
            'product_catalogue_id.*.exists' => 'Danh mục sản phẩm không tồn tại.',
            'instock.required' => 'Bạn chưa nhập số lượng sản phẩm.',
            'instock.integer' => 'Số lượng phải là số nguyên.',
            'instock.min' => 'Số lượng phải lớn hơn hoặc bằng 0.',
            'brand_id.required' => 'Vui lòng chọn thương hiệu.',
            'brand_id.exists' => 'Thương hiệu không tồn tại.',
            'sku.required' => 'SKU là bắt buộc.',
            'sku.string' => 'SKU phải là chuỗi ký tự.',
            'sku.max' => 'SKU không được vượt quá 255 ký tự.',
            'sku.unique' => 'SKU đã tồn tại. Vui lòng chọn SKU khác.',
            'price.required' => 'Bạn chưa nhập giá sản phẩm.',
            'price.numeric' => 'Giá tiền phải là số.',
            'price.min' => 'Giá tiền phải lớn hơn hoặc bằng 0.',
            'del.numeric' => 'Giá khuyến mãi phải là số.',
            'del.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0.',
            'publish.in' => 'Trạng thái không hợp lệ.',
            'is_hot.in' => 'Trạng thái nổi bật không hợp lệ.',
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'album.*.image' => 'File phải là hình ảnh.',
            'album.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
            'album.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ];
    }
}
