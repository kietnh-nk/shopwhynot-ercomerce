@extends('backend.dashboard.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Danh sách sản phẩm</h4>
                    <a href="{{ route('product.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm mới
                    </a>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form action="{{ route('product.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="keyword" 
                                       value="{{ request('keyword') }}" placeholder="Tìm kiếm sản phẩm...">
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="brand_id">
                                    <option value="">Tất cả thương hiệu</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="publish">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="1" {{ request('publish') == '1' ? 'selected' : '' }}>Hiển thị</option>
                                    <option value="0" {{ request('publish') == '0' ? 'selected' : '' }}>Ẩn</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="perpage">
                                    <option value="10" {{ request('perpage') == '10' ? 'selected' : '' }}>10 sản phẩm</option>
                                    <option value="20" {{ request('perpage') == '20' ? 'selected' : '' }}>20 sản phẩm</option>
                                    <option value="50" {{ request('perpage') == '50' ? 'selected' : '' }}>50 sản phẩm</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary me-2">Tìm kiếm</button>
                                <a href="{{ route('product.index') }}" class="btn btn-secondary">Làm mới</a>
                            </div>
                        </div>
                    </form>

                    <!-- Products Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th width="10%">Hình ảnh</th>
                                    <th width="20%">Tên sản phẩm</th>
                                    <th width="10%">SKU</th>
                                    <th width="10%">Giá</th>
                                    <th width="8%">Tồn kho</th>
                                    <th width="10%">Danh mục</th>
                                    <th width="8%">Trạng thái</th>
                                    <th width="15%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($products->count() > 0)
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="product-checkbox" value="{{ $product->id }}">
                                            </td>
                                            <td>
                                                @if($product->image)
                                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                                                         class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 60px; height: 60px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $product->name }}</strong>
                                                    @if($product->is_hot)
                                                        <span class="badge bg-warning ms-1">Nổi bật</span>
                                                    @endif
                                                </div>
                                                <small class="text-muted">{{ $product->slug }}</small>
                                            </td>
                                            <td>{{ $product->sku }}</td>
                                            <td>
                                                <div>
                                                    <strong class="text-danger">{{ number_format($product->price) }}đ</strong>
                                                    @if($product->del > 0)
                                                        <br><del class="text-muted">{{ number_format($product->del) }}đ</del>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge {{ $product->instock > 0 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $product->instock }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($product->productCatalogues->count() > 0)
                                                    @foreach($product->productCatalogues as $catalogue)
                                                        <span class="badge bg-info me-1">{{ $catalogue->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Chưa phân loại</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $product->publish ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $product->publish ? 'Hiển thị' : 'Ẩn' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('product.update', $product->slug) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('product.delete', $product->id) }}" 
                                                       class="btn btn-sm btn-outline-danger" title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-box-open fa-3x mb-3"></i>
                                                <p>Không có sản phẩm nào</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->appends(request()->except('page'))->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Delete Modal -->
<div class="modal fade" id="bulkDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa <span id="selected-count">0</span> sản phẩm đã chọn?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form action="{{ route('product.destroyMultiple') }}" method="POST" id="bulk-delete-form">
                    @csrf
                    <input type="hidden" name="array_id" id="selected-ids">
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox
    const selectAll = document.getElementById('select-all');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    
    selectAll.addEventListener('change', function() {
        productCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedCount();
    });
    
    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
            updateSelectAllState();
        });
    });
    
    function updateSelectedCount() {
        const selectedCount = document.querySelectorAll('.product-checkbox:checked').length;
        document.getElementById('selected-count').textContent = selectedCount;
        
        const selectedIds = Array.from(document.querySelectorAll('.product-checkbox:checked'))
            .map(checkbox => checkbox.value);
        document.getElementById('selected-ids').value = selectedIds.join(',');
    }
    
    function updateSelectAllState() {
        const checkedCount = document.querySelectorAll('.product-checkbox:checked').length;
        const totalCount = productCheckboxes.length;
        
        if (checkedCount === 0) {
            selectAll.indeterminate = false;
            selectAll.checked = false;
        } else if (checkedCount === totalCount) {
            selectAll.indeterminate = false;
            selectAll.checked = true;
        } else {
            selectAll.indeterminate = true;
        }
    }
});
</script>
@endpush
