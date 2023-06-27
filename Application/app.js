// Replace with your API URL
var API_URL = 'http://localhost:8880/RESTful_API/index.php';

// Handle form submission
$('#item-form').on('submit', function(e) {
    e.preventDefault();

    var id = $('#itemId').val();
    var url = id ? API_URL + '?id=' + id : API_URL;
    var method = id ? 'PUT' : 'POST';
    var data = {
        item_name: $('#item-name').val(),
        quantity: $('#quantity').val(),
        unit: $('#unit').val(),
        notes: $('#notes').val(),
        is_purchased: $('#is-purchased').is(':checked') ? 1 : 0
    };

    $.ajax({
        url: url,
        method: method,
        data: JSON.stringify(data),
        success: function(response) {
            $('#item-form')[0].reset();
            $('#itemId').val('');
            showMessage('Item saved successfully', 'success');
            loadItems();
        }
    });
});

// Fetch items from the API and display in the list
function loadItems() {
    $.ajax({
        url: API_URL,
        method: 'GET',
        success: function(items) {
            $('#item-list').empty();
            items.forEach(function(item) {
                var listItem = $('<li class="list-group-item d-flex justify-content-between align-items-center"></li>');
                
                var itemText = item.item_name + ' (Quantity: ' + item.quantity + ' - Unit: ' + item.unit + ')\n';
                if(item.notes) itemText += ' - Note: ' + item.notes;
                var itemDiv = $('<div></div>').text(itemText);
                listItem.append(itemDiv);
                
                var buttonGroup = $('<div class="btn-group" role="group"></div>');
                listItem.append(buttonGroup);
                
                var editButton = $('<button class="btn btn-info btn-sm">Edit</button>');
                editButton.click(function() {
                    editItem(item);
                });
                buttonGroup.append(editButton);

                var purchasedButton = $('<button class="btn btn-success btn-sm">Mark as Purchased</button>');
                if (item.is_purchased == 1) {
                    purchasedButton.text('Purchased').attr('disabled', true).removeClass('btn-success').addClass('btn-secondary');
                } else {
                    purchasedButton.click(function() {
                        markAsPurchased(item.id);
                    });
                }
                buttonGroup.append(purchasedButton);

                var deleteButton = $('<button class="btn btn-danger btn-sm">Delete</button>');
                deleteButton.click(function() {
                    deleteItem(item.id);
                });
                buttonGroup.append(deleteButton);
                
                $('#item-list').append(listItem);
            });
        }
    });
}

// Edit an item
function editItem(item) {
    $('#itemId').val(item.id);
    $('#item-name').val(item.item_name);
    $('#quantity').val(item.quantity);
    $('#unit').val(item.unit);
    $('#notes').val(item.notes);
    $('#is-purchased').prop('checked', item.is_purchased == 1);
}

// Mark an item as purchased
function markAsPurchased(id) {
    $.ajax({
        url: API_URL + '?id=' + id,
        method: 'PUT',
        data: JSON.stringify({ is_purchased: 1 }),
        success: function(response) {
            showMessage('Item marked as purchased', 'success');
            loadItems();
        }
    });
}


// Delete an item
function deleteItem(id) {
    $.ajax({
        url: API_URL + '?id=' + id,
        method: 'DELETE',
        success: function() {
            showMessage('Item deleted successfully', 'success');
            loadItems();
        }
    });
}

// Show a message in the page
function showMessage(message, type) {
    $('#message').text(message).attr('class', 'alert alert-' + type).removeClass('d-none');
    setTimeout(function() {
        $('#message').addClass('d-none');
    }, 3000);
}

// Load items on page load
loadItems();
