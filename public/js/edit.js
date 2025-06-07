const toggleEdit = (e) => {
    const row = e.closest('tr');
    
    console.log(price);

    if (e.textContent === 'Edit') {
            e.textContent = 'Save';
    } else {
        e.textContent = 'Edit';
    }
}