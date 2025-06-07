<form id="product-form" action="{{ route('product.store') }}" method="post">
    @csrf

    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Product name" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="0"
                placeholder="In Stock" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" min="0"
                placeholder="Price per item" required>
        </div>
    </div>

    <button type="submit" class="btn form-button">Submit</button>
</form>
