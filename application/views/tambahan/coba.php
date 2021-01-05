<script type="text/javascript" language="javascript">
    $(document).ready(function() {

        var dataTable = $('#order_data').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "fetch.php",
                type: "POST"
            },
            drawCallback: function(settings) {
                $('#total_order').html(settings.json.total);
            }
        });



    });
</script>

<?php

//fetch.php

$connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");

$column = array('order_customer_name', 'order_item', 'order_date', 'order_value');

$query = '
SELECT * FROM tbl_order 
WHERE order_customer_name LIKE "%' . $_POST["search"]["value"] . '%" 
OR order_item LIKE "%' . $_POST["search"]["value"] . '%" 
OR order_date LIKE "%' . $_POST["search"]["value"] . '%" 
OR order_value LIKE "%' . $_POST["search"]["value"] . '%" 

';

if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY order_id DESC ';
}

$query1 = '';

if ($_POST["length"] != -1) {
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$statement = $connect->prepare($query . $query1);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

$total_order = 0;

foreach ($result as $row) {
    $sub_array = array();
    $sub_array[] = $row["order_customer_name"];
    $sub_array[] = $row["order_item"];
    $sub_array[] = $row["order_date"];
    $sub_array[] = $row["order_value"];

    $total_order = $total_order + floatval($row["order_value"]);
    $data[] = $sub_array;
}

function count_all_data($connect)
{
    $query = "SELECT * FROM tbl_order";
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}

$output = array(
    'draw'    => intval($_POST["draw"]),
    'recordsTotal'  => count_all_data($connect),
    'recordsFiltered' => $number_filter_row,
    'data'    => $data,
    'total'    => number_format($total_order, 2)
);

echo json_encode($output);


?>