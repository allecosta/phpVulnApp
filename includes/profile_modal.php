<!-- Modal historico de transação -->
<div class="modal fade" id="transaction">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button 
                    type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                <button 
                    type="button" 
                    class="btn btn-default btn-flat pull-left" 
                    data-dismiss="modal">
                    <i class="fa fa-close"></i> Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal editar perfil -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button 
                    type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Atualizar Conta</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="profile_edit.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="firstname" class="col-sm-3 control-label">Nome</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?= $user['firstname']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname" class="col-sm-3 control-label">Sobrenome</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?= $user['lastname']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="email" name="email" value="<?= $user['email']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Senha</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password" name="password" value="<?= $user['password']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="contact" class="col-sm-3 control-label">Contato</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="contact" name="contact" value="<?= $user['contact_info']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-sm-3 control-label">Endereço</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="address" name="address"><?= $user['address']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="photo" class="col-sm-3 control-label">Foto</label>
                    <div class="col-sm-9">
                        <input type="file" id="photo" name="photo">
                    </div>
                </div><hr>
                <div class="form-group">
                    <label for="curr_password" class="col-sm-3 control-label">Senha Atual</label>
                    <div class="col-sm-9">
                       <input type="password" class="form-control" id="curr_password" name="curr_password" placeholder="Insira a senha atual para salvar as altereções" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button 
                    type="button" 
                    class="btn btn-default btn-flat pull-left" 
                    data-dismiss="modal">
                    <i class="fa fa-close"></i> Fechar
                </button>
                <button 
                    type="submit" 
                    class="btn btn-success btn-flat" 
                    name="edit"><i class="fa fa-check-square-o"></i> Atualizar
                </button>
              </form>
            </div>
        </div>
    </div>
</div>