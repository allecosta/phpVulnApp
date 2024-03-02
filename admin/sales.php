<?php

require 'includes/session.php';
require_once 'includes/header.php';

?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php

        require_once 'includes/navbar.php';
        require_once 'includes/menubar.php';

        ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>Histórico de Vendas</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
                    <li class="active">Vendas</li>
                </ol>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <div class="pull-right">
                                    <form method="POST" class="form-inline" action="sales_print.php">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right col-sm-8" id="reservation" name="date_range">
                                        </div>
                                        <button type="submit" class="btn btn-success btn-sm btn-flat" name="print"><span class="glyphicon glyphicon-print"></span> Imprimir</button>
                                    </form>
                                </div>
                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th class="hidden"></th>
                                        <th>Data</th>
                                        <th>Comprador</th>
                                        <th>Transação#</th>
                                        <th>Valor</th>
                                        <th>Detalhes</th>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $conn = $pdo->open();

                                        try {
                                            $sql = "SELECT 
                                                        *, sales.id AS salesid 
                                                    FROM 
                                                        sales 
                                                    LEFT JOIN 
                                                        users ON users.id = sales.user_id ORDER BY sales_date DESC";

                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();

                                            foreach ($stmt as $row) {
                                                $sql = "SELECT 
                                                            * 
                                                        FROM 
                                                            details 
                                                        LEFT JOIN 
                                                            products ON products.id = details.product_id 
                                                        WHERE details.sales_id = :id";

                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute(['id' => $row['salesid']]);
                                                $total = 0;

                                                foreach ($stmt as $details) {
                                                    $subtotal = $details['price'] * $details['quantity'];
                                                    $total += $subtotal;
                                                }
                                                echo "
                                                    <tr>
                                                        <td class='hidden'></td>
                                                        <td>" . date('d M, Y', strtotime($row['sales_date'])) . "</td>
                                                        <td>" . $row['firstname'] . ' ' . $row['lastname'] . "</td>
                                                        <td>" . $row['pay_id'] . "</td>
                                                        <td>&#82;&#36; " . number_format($total, 2, ',', '.') . "</td>
                                                        <td><button type='button' class='btn btn-info btn-sm btn-flat transact' data-id='" . $row['salesid'] . "'><i class='fa fa-search'></i> Visualizar</button></td>
                                                    </tr>
                                                ";
                                            }
                                        } catch (PDOException $e) {
                                            echo $e->getMessage();
                                        }

                                        $pdo->close();

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php

        require_once 'includes/footer.php';
        require_once 'includes/sales_modal.php';

        ?>

    </div>

    <?php require 'includes/scripts.php'; ?>

    <script>
        $(function() {
            $('#datepicker_add').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            })
            $('#datepicker_edit').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            })
            $('.timepicker').timepicker({
                showInputs: false
            })
            $('#reservation').daterangepicker()
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                format: 'MM/DD/YYYY h:mm A'
            })
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Hoje': [moment(), moment()],
                        'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
                        'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
                        'Mês atual': [moment().startOf('month'), moment().endOf('month')],
                        'Mês passado ': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )
        });
    </script>
    <script>
        $(function() {
            $(document).on('click', '.transact', function(e) {
                e.preventDefault();
                $('#transaction').modal('show');
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: 'transact.php',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#date').html(response.date);
                        $('#transid').html(response.transaction);
                        $('#detail').prepend(response.list);
                        $('#total').html(response.total);
                    }
                });
            });

            $("#transaction").on("hidden.bs.modal", function() {
                $('.prepend_items').remove();
            });
        });
    </script>
</body>

</html>