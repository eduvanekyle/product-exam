document.getElementById('product-form').addEventListener('submit', function (event) {
    event.preventDefault();
    console.log('Form submitted');
    
    const form = event.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',        
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },        
        body: formData
    })
    .then(response => {
        if (!response.ok) throw response;
        return response.json();
    })
    .then(data => {
        Swal.fire({
            title: "Success",
            text: "Product Created Successfully.",
            icon: "success"
        });

        const table = document.getElementById('product-table-body');
        const tr = document.createElement('tr');
        const product = data.product;
        const valueCell = document.getElementById('total-value');
        const addedValue = product.quantity * product.price;
        const valueText = document.getElementById('total-value').textContent;
        const floatValue = parseFloat(valueText.replace(/,/g, ''));
        const formatted = Number(floatValue + addedValue).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        valueCell.textContent = formatted;

        tr.classList.add('text-center');

        tr.innerHTML = `
            <th scope="row">${product.id}</th>
            <td>${product.name}</td>
            <td>${product.quantity}</td>
            <td>₱ ${Number(product.price).toFixed(2)}</td>
            <td>${product.created_at}</td>
            <td>₱ ${(product.quantity * product.price).toFixed(2)}</td>
            <td class="action">
                <button type="button" id="edit-btn" class="btn btn-secondary btn-sm"
                    onclick="toggleEdit(this)">Edit</button>
            </td>
        `

        table.appendChild(tr);

        form.reset();
    })
    .catch(async (error) => {
        let message = 'An error occurred.';

        if (error.json) {
            const errData = await error.json();
            message = errData.message || message;
        }

        Swal.fire({
            title: "Error",
            text: `${message}`,
            icon: "error"
        });
    });
});

const toggleEdit = (e, key) => {
    const row = e.closest('tr');

    const nameCell = document.getElementById(`name-cell-${key}`);
    const nameInput = document.getElementById(`name-input-${key}`);

    const quantityCell = document.getElementById(`quantity-cell-${key}`);
    const quantityInput = document.getElementById(`quantity-input-${key}`);

    const priceCell = document.getElementById(`price-cell-${key}`);
    const priceInput = document.getElementById(`price-input-${key}`);

    if (e.textContent === 'Edit') {
            e.textContent = 'Save';
            nameCell.style.display = 'none';
            nameInput.removeAttribute('hidden');
            quantityCell.style.display = 'none';
            quantityInput.removeAttribute('hidden');
            priceCell.style.display = 'none';
            priceInput.removeAttribute('hidden');
    } else {
        e.textContent = 'Edit';
        
    }
}