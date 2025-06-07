@php
    $totalValue = 0;
@endphp

<table id="product-table" class="product-table table table-striped table-bordered small">
    <thead>
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
                <th scope="row">{{ $product['id'] }}</th>
                <td id="name-cell-{{ $key }}">{{ $product['name'] }}</td>
                <td hidden id="name-input-{{ $key }}" class="table-input">
                    <input type="text" name="" class="form-control">
                </td>

                <td id="quantity-cell-{{ $key }}">{{ $product['quantity'] }}</td>
                <td hidden id="quantity-input-{{ $key }}" class="table-input">
                    <input type="text" name="" class="form-control">
                </td>

                <td id="price-cell-{{ $key }}">₱ {{ number_format($product['price'], 2) }}</td>
                <td hidden id="price-input-{{ $key }}" class="table-input">
                    <input type="text" name="" class="form-control">
                </td>

                <td>{{ \Carbon\Carbon::parse($product['created_at'])->format('F j, Y g:i A') }}</td>
                <td>₱ {{ number_format($product['quantity'] * $product['price'], 2) }}</td>
                <td class="action">
                    <button type="button" id="edit-btn" class="btn btn-secondary btn-sm"
                        onclick="toggleEdit(this, {{ $key }})">Edit{{ svg('bx-edit') }}</button>

                    <div class="button-container">
                        <button type="button" id="save-btn" class="btn btn-success btn-sm"
                            onclick="toggleEdit(this, {{ $key }})">Save</button>

                        <button type="button" id="close-btn" class="btn btn-danger btn-sm"
                            onclick="toggleEdit(this, {{ $key }})">Close</button>
                    </div>
                </td>
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
