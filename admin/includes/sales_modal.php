<div class="modal fade" id="transaction">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><strong>Detalhes da Transação</strong></h4>
            </div>
            <div class="modal-body">
                <p>
                    Data: <span id="date"></span>
                    <span class="pull-right">Transação: <span id="transid"></span></span>
                </p>
                <table class="table table-bordered">
                    <thead>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Sub-total</th>
                    </thead>
                    <tbody id="detail">
                        <tr>
                            <td colspan="3" align="right"><strong>Total</strong></td>
                            <td><span id="total"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                    <i class="fa fa-close"></i> Fechar
                </button>
            </div>
        </div>
    </div>
</div>