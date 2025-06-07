<form id="product-form" action="{{ route('product.store') }}" method="post">
    @csrf

    <div class="row">
        <div class="col-md-12">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name"
                required>
        </div>

        <div class="col-md-6">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="0"
                placeholder="Enter product quantity" required>
        </div>

        <div class="col-md-6">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" min="0"
                placeholder="Enter product price" required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
