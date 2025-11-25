$(document).ready(function () {

  
  $('#name').on('input change', function() {
    const name = $(this).val();
    $('#CostumerName').val(name);
  });
  
  let selectedFoods = {};
  let selectedFoodTotal = 0;
  let selectedFoodIds = [];

  const baseTotal = parseFloat($('#base-total').text().replace(/,/g, ''));

  // ...existing code...
  $('#total_amount').val(baseTotal.toFixed(2));
  $('#partial-amount').text((baseTotal / 2).toFixed(2))
  $('#facility_income').val(baseTotal.toFixed(2));

  $('.add-food-form').on('submit', function (e) {
    e.preventDefault();

    const foodId = $(this).data('food-id');
    const foodName = $(this).data('food-name');
    const foodPrice = parseFloat($(this).data('food-price'));
    let qty = parseInt($(this).find('.food-qty').val());

    if (isNaN(qty) || qty < 1) qty = 1;

    // Add or update food quantity
    if (selectedFoods[foodId]) {
      selectedFoods[foodId].qty += qty;
    } else {
      selectedFoods[foodId] = { name: foodName, price: foodPrice, qty: qty };
      // Only push if not already in the queue
      if (!selectedFoodIds.includes(foodId)) {
        selectedFoodIds.push(foodId);
      }
    }

    // Calculate total and display
    let foodNamesArr = [];
    selectedFoodTotal = 0;

    $.each(selectedFoods, function (id, data) {
      foodNamesArr.push(`${data.name} x ${data.qty}`);
      selectedFoodTotal += data.price * data.qty;
    });

    $('#food-name').text(foodNamesArr.join(', '));
    $('#food-price').text(
      selectedFoodTotal.toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      })
    );

    const newTotal = baseTotal + selectedFoodTotal;
    $('#total-amount').text(
      newTotal.toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      })
    );

    // Update hidden input with queue order
    $('#food_id').val(selectedFoodIds.join(','));
    $('#food_quantity').val(selectedFoodIds.map(id => selectedFoods[id].qty).join(','));
    $('#partial-amount').text((newTotal / 2).toFixed(2))
    $('#total_amount').val(newTotal.toFixed(2));
  });
});
