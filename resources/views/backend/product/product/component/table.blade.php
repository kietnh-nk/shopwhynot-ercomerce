<div class="table-responsive table-card mt-3 mb-1">
    <table class="table align-middle table-nowrap" id="customerTable">
        <thead class="table-light">
            <tr>
                <th scope="col" style="width: 50px;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check-all">
                    </div>
                </th>
                <th class="sort">Sản phẩm</th>
                <th class="sort text-center">Số lượng còn</th>
                <th class="sort text-center" style="width: 160px">Sku</th>
                <th class="sort text-center" style="width: 160px">Trạng thái</th>
                <th class="sort text-end" style="width: 100px">Thao tác</th>
            </tr>
        </thead>
        <tbody class="list form-check-all">
            @foreach ($products as $key => $item)
                @php
                    $badge = '';
                    if ($item->publish == 1) {
                        $badge .= '<span class="badge bg-success-subtle text-success text-uppercase">Hiển Thị</span>';
                    } else {
                        $badge .= '<span class="badge bg-danger-subtle text-danger text-uppercase">Ẩn</span>';
                    }

                    // Thêm badge cho sản phẩm nổi bật
                    if ($item->is_hot == 1) {
                        $badge .= '<br><span class="badge bg-warning-subtle text-warning mt-1">Nổi bật</span>';
                    }
                @endphp
                <tr>
                    <th scope="row">
                        <div class="form-check">
                            <input class="form-check-input checkbox-item" type="checkbox" name="checkbox-item[]"
                                value="{{ $item->id }}">
                        </div>
                    </th>
                    <td class="customer_single_td" style="">
                        <div class="d-flex align-items-center">
                            <img src="{{ $item->image ? $item->image : '/libaries/upload/images/img-notfound.png' }}"
                                alt="" class="object-fit-contain me-3" width="80px" height="60px">
                            <div class="flex-grow-1">
                                <div class="fw-medium fz-16 mb-1" style="max-width: 400px;">
                                    <a href="{{ route('product.update', ['slug' => $item->slug]) }}" class="text-decoration-none">
                                        {{ $item->name }}
                                    </a>
                                </div>
                            <div>
                                @if ($item->productCatalogues)
                                    <div>
                                        <span>Danh mục:
                                            @foreach ($item->productCatalogues as $catalogue)
                                                <strong><a href="{{ route('product.catalogue.index') }}"
                                                        class="text-danger pe-2">{{ $catalogue->name }}</a></strong>
                                            @endforeach
                                        </span>
                                    </div>
                                @endif
                                <div class="mt-1">
                                    <span class="text-success fw-bold">{{ number_format($item->price, 0, ',', '.') }} VNĐ</span>
                                    @if($item->del > 0)
                                        <span class="text-danger text-decoration-line-through ms-2">{{ number_format($item->del, 0, ',', '.') }} VNĐ</span>
                                    @endif
                                </div>
                                @if($item->brands)
                                    <div class="mt-1">
                                        <small class="text-muted">Thương hiệu: <strong>{{ $item->brands->name }}</strong></small>
                                    </div>
                                @endif
                                <div class="mt-1">
                                    <small class="text-muted">Tạo: {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : 'N/A' }}</small>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center fw-600">
                        <span class="badge bg-{{ $item->instock > 0 ? 'success' : 'danger' }}-subtle text-{{ $item->instock > 0 ? 'success' : 'danger' }}">
                            {{ $item->instock ?? 0 }}
                        </span>
                    </td>
                    <td class="order text-center fw-600">{{ $item->sku }}</td>
                    <td class="status text-center">
                        {!! $badge !!}
                    </td>
                    <td>
                        <div class="dropdown text-end">
                            <a href="#" role="button" id="dropdownMenuLink5" data-bs-toggle="dropdown"
                                aria-expanded="false" class="">
                                <i class="ri-more-2-fill fs-5"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink5" style="">
                                {{-- <li><a class="dropdown-item text-primary" href="#"><i
                                            class="ri-eye-line align-middle"></i> Xem</a></li> --}}
                                <li><a class="dropdown-item text-info"
                                        href="{{ route('product.update', ['slug' => $item->slug]) }}"> <i
                                            class="ri-edit-box-line"></i>
                                        Chỉnh sửa</a></li>

                                <li><a class="dropdown-item text-danger"
                                        href="{{ route('product.delete', ['id' => $item->id]) }}"><i
                                            class="ri-delete-bin-line"></i>
                                        Xóa</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- pagination  --}}
<div class="container-fluid">
    {{ $products->onEachSide(3)->links('pagination::bootstrap-5') }}
</div>
