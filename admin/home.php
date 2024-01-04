<?php

require 'includes/session.php';
require 'includes/format.php';

$today = date('Y-m-d');
$year = date('Y');

if (isset($_GET['year'])) {
    $year = $_GET['year'];
}

$conn = $pdo->open();

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
                <h1>Painel</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
                    <li class="active">Painel</li>
                </ol>
            </section>
            <section class="content">
                <?php

                if (isset($_SESSION['error'])) {
                    echo "
                        <div class='alert alert-danger alert-dismissible'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <h4><i class='icon fa fa-warning'></i> Error!</h4>
                            " . $_SESSION['error'] . "
                        </div>
                    ";

                    unset($_SESSION['error']);
                }

                if (isset($_SESSION['success'])) {
                    echo "
                        <div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h4><i class='icon fa fa-check'></i> Sucesso!</h4>
                        " . $_SESSION['success'] . "
                        </div>
                    ";

                    unset($_SESSION['success']);
                }

                ?>

                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <?php

                                $sql = "SELECT * FROM details LEFT JOIN products ON products.id = details.product_id";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $total = 0;

                                foreach ($stmt as $srow) {
                                    $subtotal = $srow['price'] * $srow['quantity'];
                                    $total += $subtotal;
                                }

                                echo "<h3>&#36; " . numberFormatShort($total, 2) . "</h3>";

                                ?>

                                <p>Total de Vendas</p>
                            </div>
                            <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                            <a href="book.php" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-green">
                            <div class="inner">
                                <?php

                                $sql = "SELECT *, COUNT(*) AS numrows FROM products";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $prow =  $stmt->fetch();

                                echo "<h3>" . $prow['numrows'] . "</h3>";

                                ?>

                                <p>Número de Produtos</p>
                            </div>
                            <div class="icon"><i class="fa fa-barcode"></i></div>
                            <a href="student.php" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <?php

                                $sql = "SELECT *, COUNT(*) AS numrows FROM users";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $urow =  $stmt->fetch();

                                echo "<h3>" . $urow['numrows'] . "</h3>";

                                ?>

                                <p>Número de Usuários</p>
                            </div>
                            <div class="icon"><i class="fa fa-users"></i></div>
                            <a href="return.php" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-red">
                            <div class="inner">

                                <?php

                                $sql = "SELECT 
                                            * 
                                        FROM 
                                            details 
                                        LEFT JOIN 
                                            sales ON sales.id = details.sales_id 
                                        LEFT JOIN 
                                            products ON products.id = details.product_id 
                                        WHERE 
                                            sales_date = :sales_date";

                                $stmt = $conn->prepare($sql);
                                $stmt->execute(['sales_date' => $today]);
                                $total = 0;

                                foreach ($stmt as $trow) {
                                    $subtotal = $trow['price'] * $trow['quantity'];
                                    $total += $subtotal;
                                }

                                echo "<h3>&#36; " . numberFormatShort($total, 2) . "</h3>";

                                ?>

                                <p>Vendas de Hoje</p>
                            </div>
                            <div class="icon"><i class="fa fa-money"></i></div>
                            <a href="borrow.php" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Relatório de Vendas Mensais</h3>
                                <div class="box-tools pull-right">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label>Selecione Ano: </label>
                                            <select class="form-control input-sm" id="select_year">
                                                <?php

                                                for ($i = 2015; $i <= 2065; $i++) {
                                                    $selected = ($i == $year) ? 'selected' : '';

                                                    echo "
                                                        <option value='" . $i . "' " . $selected . ">" . $i . "</option>
                                                    ";
                                                }

                                                ?>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="chart">
                                    <br>
                                    <div id="legend" class="text-center"></div>
                                    <canvas id="barChart" style="height: 350px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php require_once 'includes/footer.php'; ?>

    </div>

    <?php

    $months = [];
    $sales = [];

    for ($m = 1; $m <= 12; $m++) {
        try {
            $sql = "SELECT 
                        * 
                    FROM 
                        details 
                    LEFT JOIN 
                        sales ON sales.id = details.sales_id 
                    LEFT JOIN products ON products.id = details.product_id 
                    WHERE 
                        MONTH(sales_date) = :month AND YEAR(sales_date) = :year";

            $stmt = $conn->prepare($sql);
            $stmt->execute(['month' => $m, 'year' => $year]);
            $total = 0;

            foreach ($stmt as $srow) {
                $subtotal = $srow['price'] * $srow['quantity'];
                $total += $subtotal;
            }

            array_push($sales, round($total, 2));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $num = str_pad($m, 2, 0, STR_PAD_LEFT);
        $month =  date('M', mktime(0, 0, 0, $m, 1));

        array_push($months, $month);
    }

    $months = json_encode($months);
    $sales = json_encode($sales);


    $pdo->close();

    require 'includes/scripts.php';

    ?>

    <script>
        $(function() {
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChart = new Chart(barChartCanvas)
            var barChartData = {
                labels: <?= $months; ?>,
                datasets: [{
                    label: 'SALES',
                    fillColor: 'rgba(60,141,188,0.9)',
                    strokeColor: 'rgba(60,141,188,0.8)',
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: <?= $sales; ?>
                }]
            }

            var barChartOptions = {
                // Se a escala estiver em zero ou uma ordem de grandeza abaixo do valor mais baixo.
                scaleBeginAtZero: true,

                // Se as linhas de grade são mostradas no gráfico.
                scaleShowGridLines: true,

                // Cor das linhas de grade.
                scaleGridLineColor: 'rgba(0,0,0,.05)',

                // Largura das linhas de grade.
                scaleGridLineWidth: 1,

                // Se devem ser mostradas linhas horizontais (exceto eixo x).
                scaleShowHorizontalLines: true,

                // Se devem ser mostradas linhas verticais (exceto eixo y).
                scaleShowVerticalLines: true,

                // Se houver um traço em cada barra.
                barShowStroke: true,

                // Largura em pixels do traço da barra.
                barStrokeWidth: 2,

                // Espaçamento entre cada um dos conjuntos de x valores.
                barValueSpacing: 5,

                // Espaçamento entre conjuntos de dados de x valores.
                barDatasetSpacing: 1,

                // Modelo de legenda.
                legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',

                // Se deve tornar o gráfico responsivo.
                responsive: true,
                maintainAspectRatio: true
            }

            barChartOptions.datasetFill = false
            var myChart = barChart.Bar(barChartData, barChartOptions)
            document.getElementById('legend').innerHTML = myChart.generateLegend();
        });
    </script>
    <script>
        $(function() {
            $('#select_year').change(function() {
                window.location.href = 'home.php?year=' + $(this).val();
            });
        });
    </script>
</body>

</html>