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
                <h1>Categoria</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
                    <li>Produtos</li>
                    <li class="active">Categoria</li>
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
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Novo</a>
                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th>Categoria</th>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $conn = $pdo->open();

                                        try {
                                            $stmt = $conn->prepare("SELECT * FROM category");
                                            $stmt->execute();

                                            foreach ($stmt as $row) {
                                                echo "
                                                    <tr>
                                                        <td>" . $row['name'] . "</td>
                                                        <td>
                                                        <button class='btn btn-success btn-sm edit btn-flat' data-id='" . $row['id'] . "'><i class='fa fa-edit'></i> Editar</button>
                                                        <button class='btn btn-danger btn-sm delete btn-flat' data-id='" . $row['id'] . "'><i class='fa fa-trash'></i> Excluir</button>
                                                        </td>
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
        require_once 'includes/category_modal.php';

        ?>

    </div>

    <?php require 'includes/scripts.php'; ?>

    <script>
        $(function() {
            $(document).on('click', '.edit', function(e) {
                e.preventDefault();
                $('#edit').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                $('#delete').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });

        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'category_row.php',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    $('.catid').val(response.id);
                    $('#edit_name').val(response.name);
                    $('.catname').html(response.name);
                }
            });
        }
    </script>
</body>

</html>