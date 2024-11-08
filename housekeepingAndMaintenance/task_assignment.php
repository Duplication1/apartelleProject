<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">


    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        /* Add some basic styling for the table */
        .stock-levels-table {
            width: 100%;
            border-collapse: collapse; /* Combine borders */
            margin-top: 20px; /* Space between buttons and table */
        }
        .stock-levels-table th, .stock-levels-table td {
            padding: 12px;
            border: 1px solid #ddd; /* Light grey border */
            text-align: left; /* Align text to the left */
        }
        .stock-levels-table th {
            background-color: #f2f2f2; /* Light grey background for header */
        }
        .stock-levels-table tr:hover {
            background-color: #f5f5f5; /* Change background color on hover */
        }
    </style>
</head>
<body>

<!-- Table for displaying cleanng schedules -->
<div class="container pt-5">
<table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th> ASSIGNEE </th>
                <th> DAY </th>
                <th> TASK </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td> Qweqwe </td>
                <td> Monday </td>
                <td> Lorem ipsum dolor sit amet. </td>
            </tr>
            <tr>
                <td> Qweqwe </td>
                <td> Monday </td>
                <td> Lorem ipsum dolor sit amet. </td>
            </tr>
            <tr>
                <td> Qweqwe </td>
                <td> Monday </td>
                <td> Lorem ipsum dolor sit amet. </td>
            </tr>
            <tr>
                <td> Qweqwe </td>
                <td> Monday </td>
                <td> Lorem ipsum dolor sit amet. </td>
            </tr>
            <tr>
                <td> Qweqwe </td>
                <td> Monday </td>
                <td> Lorem ipsum dolor sit amet. </td>
            </tr>
            <tr>
                <td> Qweqwe </td>
                <td> Monday </td>
                <td> Lorem ipsum dolor sit amet. </td>
            </tr>
            <tr>
                <td> Qweqwe </td>
                <td> Monday </td>
                <td> Lorem ipsum dolor sit amet. </td>
            </tr>
            <tr>
                <td> Qweqwe </td>
                <td> Monday </td>
                <td> Lorem ipsum dolor sit amet. </td>
            </tr>

        </tbody>
        <tfoot>
        <tr>
                <td> Qweqwe </td>
                <td> Monday </td>
                <td> Lorem ipsum dolor sit amet. </td>
            </tr>
        </tfoot>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

<script src="script.js"></script>

<script>
new DataTable('#example');
</script>

</body>
</html>
