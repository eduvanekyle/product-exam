const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


document.getElementById('product-form').addEventListener('submit', function (event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',        
        headers: {
            'X-CSRF-TOKEN': token,
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

    nameCell.hidden = true;
    nameInput.removeAttribute('hidden');
    quantityCell.hidden = true;
    quantityInput.removeAttribute('hidden');
    priceCell.hidden = true;
    priceInput.removeAttribute('hidden');

    buttonContainer = document.getElementById(`button-container-block-${key}`);
    buttonContainer.hidden = true;

    hiddenContainer = document.getElementById(`button-container-${key}`);
    hiddenContainer.removeAttribute('hidden');
}

const toggleClose = (e, key) => {
    // const row = e.closest('tr');

    const nameCell = document.getElementById(`name-cell-${key}`);
    const nameInput = document.getElementById(`name-input-${key}`);

    const quantityCell = document.getElementById(`quantity-cell-${key}`);
    const quantityInput = document.getElementById(`quantity-input-${key}`);

    const priceCell = document.getElementById(`price-cell-${key}`);
    const priceInput = document.getElementById(`price-input-${key}`);

    nameCell.removeAttribute('hidden');
    nameInput.hidden = true;
    quantityCell.removeAttribute('hidden');
    quantityInput.hidden = true;
    priceCell.removeAttribute('hidden');
    priceInput.hidden = true;

    buttonContainer = document.getElementById(`button-container-block-${key}`);
    buttonContainer.removeAttribute('hidden');

    hiddenContainer = document.getElementById(`button-container-${key}`);
    hiddenContainer.hidden = true;
}

document.querySelectorAll('.product-update-form').forEach(form => {
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        Swal.fire({
            icon: "question",
            title: "Do you want to save the changes?",
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = event.target;
                    const formData = new FormData(form);
                    
                    fetch(form.action, {
                        method: 'POST',        
                        headers: {
                            'X-CSRF-TOKEN': token,
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
                            text: "Product Updated Successfully.",
                            icon: "success"
                        });

                        const nameCell = document.getElementById(`name-cell-${data.key}`);
                        const quantityCell = document.getElementById(`quantity-cell-${data.key}`);
                        const priceCell = document.getElementById(`price-cell-${data.key}`);
                        const valueCell = document.getElementById(`total-value-cell-${data.key}`);

                        nameCell.textContent = data.product.name;
                        quantityCell.textContent = data.product.quantity;
                        priceCell.textContent = `₱ ${Number(data.product.price).toFixed(2)}`;
                        oldValue = valueCell.textContent;
                        oldValueFloat = parseFloat(oldValue.replace(/,/g, ''));
                        valueCell.textContent = `${(data.product.quantity * data.product.price).toFixed(2)}`;

                        const totalCell = document.getElementById('total-value');
                        const addedValue = (data.product.quantity * data.product.price) - oldValueFloat;
                        const valueText = document.getElementById('total-value').textContent;
                        const floatValue = parseFloat(valueText.replace(/,/g, ''));

                        const formatted = Number(floatValue + addedValue).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

                        totalCell.textContent = formatted;

                        form.reset();                        

                        toggleClose(event, data.key);
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
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
    });
})