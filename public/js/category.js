document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('categorySelect');
    categorySelect.addEventListener('change', function() {
        const selectedCategory = this.value;
        const productCards = document.querySelectorAll('.col-md-4.mb-4'); // Adjust the selector as needed

        productCards.forEach(card => {
            const cardCategory = card.getAttribute('data-category'); // Assuming each card has a data-category attribute
            if (selectedCategory === '' || cardCategory === selectedCategory) {
                card.style.display = ''; // Or 'flex' if your layout is flex-based
            } else {
                card.style.display = 'none';
            }
        });
    });
});