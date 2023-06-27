<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping List App</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            padding: 20px;
        }
        .center-div {
            margin: auto;
            width: 60%;
        }
    </style>
</head>
<body>
    <div class="container center-div">
        <h2 class="text-center">Shopping List</h2>
        <div id="message" class="alert d-none"></div>
        <form id="item-form">
            <input type="hidden" id="itemId">
            <div class="form-group">
                <label for="item-name">Item Name</label>
                <input type="text" class="form-control" id="item-name" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control" id="quantity" required>
            </div>
            <div class="form-group">
                <label for="unit">Unit</label>
                <input type="text" class="form-control" id="unit" required>
            </div>
            <div class="form-group">
                <label for="notes">Notes</label>
                <input type="text" class="form-control" id="notes" required>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="is-purchased">
                <label class="form-check-label" for="is-purchased">Purchased?</label>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        <br>
        <ul id="item-list" class="list-group"></ul>
    </div>
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="app.js"></script>
</body>
</html>
