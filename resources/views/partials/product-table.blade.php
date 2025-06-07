@php
    $totalValue = 0;
@endphp

<table id="product-table" class="product-table table table-bordered small">
    <thead class="table-secondary">
        <tr class="text-center">
            <th scope="col">#</th>
            <th scope="col">Product Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
            <th scope="col">Date Created</th>
            <th scope="col">Total Value</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody id="product-table-body">
        @foreach ($products as $key => $product)
            <tr class="text-center">
                <form class="product-update-form" id="product-update-form"
                    action="{{ route('product.update', ['id' => $product['id']]) }}" method="put">
                    @csrf
                    @method('PUT')
                    <th scope="row">{{ $product['id'] }}</th>
                    <input type="text" name="key" id="key-input" value="{{ $key }}" hidden>
                    <td id="name-cell-{{ $key }}" class="name-cell">{{ $product['name'] }}</td>
                    <td hidden id="name-input-{{ $key }}" class="table-input">
                        <input type="text" name="name" id="name-input" value="{{ $product['name'] }}"
                            class="form-control name-input">
                    </td>

                    <td id="quantity-cell-{{ $key }}" class="quantity-cell">{{ $product['quantity'] }}</td>
                    <td hidden id="quantity-input-{{ $key }}" class="table-input">
                        <input type="number" min="1" name="quantity" id="quantity-input"
                            value="{{ $product['quantity'] }}" class="form-control quantity-input">
                    </td>

                    <td id="price-cell-{{ $key }}" class="price-cell">₱
                        {{ number_format($product['price'], 2) }}</td>
                    <td hidden id="price-input-{{ $key }}" class="table-input">
                        <input type="number" min="1" name="price" id="price-input"
                            value="{{ $product['price'] }}" class="form-control price-input">
                    </td>

                    <td>{{ \Carbon\Carbon::parse($product['created_at'])->format('F j, Y g:i A') }}</td>
                    <td>₱ <span
                            id="total-value-cell-{{ $key }}">{{ number_format($product['quantity'] * $product['price'], 2) }}</span>
                    </td>
                    <td class="action">
                        <div class="button-container-block" id="button-container-block-{{ $key }}">
                            <button type="button" id="edit-btn-{{ $key }}" class="btn btn-secondary btn-sm"
                                onclick="toggleEdit(this, {{ $key }})">{{ svg('bx-edit') }}</button>
                        </div>

                        <div class="button-container" id="button-container-{{ $key }}" hidden>
                            <button type="submit" id="save-btn" class="btn btn-success btn-sm"
                                onclick="toggleEdit(this, {{ $key }})">{{ svg('bx-save') }}</button>

                            <button type="button" id="close-btn" class="btn btn-danger btn-sm"
                                onclick="toggleClose(this, {{ $key }})">{{ svg('bx-x') }}</button>
                        </div>
                    </td>
                </form>
            </tr>

            @php
                $totalValue += $product['quantity'] * $product['price'];
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr class="text-center">
            <th scope="col" colspan="5">Total</th>
            <th scope="col">₱ <span id="total-value">{{ number_format($totalValue, 2) }}</span></th>
            <th scope="col"></th>
        </tr>
    </tfoot>
</table>
