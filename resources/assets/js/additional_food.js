$(document).ready(function() {
    // Store additional foods in an array
    let additionalFoods = [];

    // Handle add food button click
    $('.add-food-form').on('submit', function(e) {
        e.preventDefault();

        // Get the form and its data
        let form = $(this);
        let foodName = form.data('food-name');
        let foodId = form.data('food-id');
        let foodPrice = parseFloat(form.data('food-price'));
        let quantity = parseInt(form.find('.food-qty').val());

        if (quantity < 1) {
            alert("Quantity must be at least 1");
            return;
        }

        // Check if food is already added
        let existingFood = additionalFoods.find(f => f.id === foodId);
        if (existingFood) {
            existingFood.quantity += quantity;
        } else {
            additionalFoods.push({
                id: foodId,
                name: foodName,
                price: foodPrice,
                quantity: quantity
            });
        }

        // Update the sidebar and hidden inputs
        updateAdditionalFoodsSidebar();
        updateHiddenInputs();
    });

    function updateAdditionalFoodsSidebar() {
        let container = $('li:contains("Additional Foods")');
        let html = '';

        let total = 0;
        additionalFoods.forEach((food, index) => {
            html += `${food.name} x ${food.quantity}`;
            if (index !== additionalFoods.length - 1) html += ', ';
            total += food.price * food.quantity;
        });

        // Update the HTML
        container.next('li').html('<strong>Added Foods: </strong>' + html);
        container.next('li').next('li').html('<strong>Total Price: </strong>₱' + total.toFixed(2));
        $('#total-amount').text('₱' + total.toFixed(2));
    }

    function updateHiddenInputs() {
        // Collect food IDs and quantities into arrays
        let foodIds = additionalFoods.map(f => f.id);
        let foodQuantities = additionalFoods.map(f => f.quantity);
        let total = additionalFoods.reduce((sum, f) => sum + (f.price * f.quantity), 0);

        // Set the hidden input values
        $('#food_id').val(foodIds.join(','));          // e.g., "1,3,5"
        $('#food_quantity').val(foodQuantities.join(',')); // e.g., "2,1,4"
        $('#total_amount').val(total.toFixed(2));      // total amount
    }
});
