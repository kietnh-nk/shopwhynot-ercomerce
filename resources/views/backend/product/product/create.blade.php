@extends('backend.dashboard.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thêm mới sản phẩm</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Tên sản phẩm: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   name="name" value="{{ old('name') }}" placeholder="Nhập tên sản phẩm">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Slug: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                                   name="slug" value="{{ old('slug') }}" placeholder="Nhập slug">
                                            @error('slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Thông tin ngắn:</label>
                                            <textarea class="form-control @error('info') is-invalid @enderror" 
                                                      name="info" rows="3" placeholder="Thông tin ngắn về sản phẩm">{{ old('info') }}</textarea>
                                            @error('info')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Mô tả chi tiết:</label>
                                            <textarea class="form-control" name="description" rows="5" 
                                                      placeholder="Mô tả chi tiết sản phẩm">{{ old('description') }}</textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Giá sản phẩm: <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                                           name="price" value="{{ old('price') }}" min="0" step="1000" placeholder="0">
                                                    @error('price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Giá khuyến mãi:</label>
                                                    <input type="number" class="form-control" name="del" 
                                                           value="{{ old('del') }}" min="0" step="1000" placeholder="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Số lượng tồn kho: <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control @error('instock') is-invalid @enderror" 
                                                           name="instock" value="{{ old('instock') }}" min="0" placeholder="0">
                                                    @error('instock')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">SKU: <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                                                           name="sku" value="{{ old('sku') }}" placeholder="Nhập SKU">
                                                    @error('sku')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Danh mục sản phẩm: <span class="text-danger">*</span></label>
                                            <select class="form-select @error('product_catalogue_id') is-invalid @enderror" name="product_catalogue_id[]" multiple>
                                                <option value="">Chọn danh mục</option>
                                                @foreach($productCatalogues as $catalogue)
                                                    <option value="{{ $catalogue->id }}" 
                                                            {{ in_array($catalogue->id, old('product_catalogue_id', [])) ? 'selected' : '' }}>
                                                        {{ $catalogue->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('product_catalogue_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Thương hiệu: <span class="text-danger">*</span></label>
                                            <select class="form-select @error('brand_id') is-invalid @enderror" name="brand_id">
                                                <option value="">Chọn thương hiệu</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Trạng thái:</label>
                                            <select class="form-select" name="publish">
                                                <option value="1" {{ old('publish') == '1' ? 'selected' : '' }}>Hiển thị</option>
                                                <option value="0" {{ old('publish') == '0' ? 'selected' : '' }}>Ẩn</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Sản phẩm nổi bật:</label>
                                            <select class="form-select" name="is_hot">
                                                <option value="0" {{ old('is_hot') == '0' ? 'selected' : '' }}>Không</option>
                                                <option value="1" {{ old('is_hot') == '1' ? 'selected' : '' }}>Có</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Hình ảnh chính:</label>
                                            <input type="file" class="form-control" name="image" accept="image/*">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Album hình ảnh:</label>
                                            <input type="file" class="form-control" name="album[]" multiple accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Thuộc tính sản phẩm</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($attributeCatalogue)
                                            @foreach($attributeCatalogue as $catalogue)
                                                <div class="mb-3">
                                                    <label class="form-label">{{ $catalogue->name }}:</label>
                                                    <div class="row">
                                                        @foreach($catalogue->attributes as $attribute)
                                                            <div class="col-md-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" 
                                                                           name="attribute[{{ $catalogue->id }}][]" 
                                                                           value="{{ $attribute->id }}" 
                                                                           id="attr_{{ $attribute->id }}">
                                                                    <label class="form-check-label" for="attr_{{ $attribute->id }}">
                                                                        {{ $attribute->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('product.index') }}" class="btn btn-secondary me-2">Hủy</a>
                                    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
