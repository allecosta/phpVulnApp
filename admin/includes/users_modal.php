<!-- Modal Adicionar Usuario  -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><strong>Adicionar Novo Usuário</strong></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="users_add.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Senha</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="col-sm-3 control-label">Nome</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="firstname" name="firstname" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-sm-3 control-label">Sobrenome</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="lastname" name="lastname" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">Endereço</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="address" name="address"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact" class="col-sm-3 control-label">Contato</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="contact" name="contact">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="photo" class="col-sm-3 control-label">Foto</label>
                        <div class="col-sm-9">
                            <input type="file" id="photo" name="photo">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Fechar</button>
                <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Usuário -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><strong>Editar Usuário</strong></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="users_edit.php">
                    <input type="hidden" class="userid" name="id">
                    <div class="form-group">
                        <label for="edit_email" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="edit_email" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_password" class="col-sm-3 control-label">Senha</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="edit_password" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_firstname" class="col-sm-3 control-label">Nome</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_firstname" name="firstname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_lastname" class="col-sm-3 control-label">Sobrenome</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_lastname" name="lastname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_address" class="col-sm-3 control-label">Endereço</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="edit_address" name="address"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_contact" class="col-sm-3 control-label">Contato</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_contact" name="contact">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Fechar</button>
                <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Atualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Excluir Usuário -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Deseja realmente excluir este usuário?</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="users_delete.php">
                    <input type="hidden" class="userid" name="id">
                    <div class="text-center">
                        <!-- <p>Excluir Usuário</p> -->
                        <h2 class="bold fullname"></h2>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Fechar</button>
                <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Atualizar Foto Usuário -->
<div class="modal fade" id="edit_photo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><strong><span class="fullname"></span></strong></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="users_photo.php" enctype="multipart/form-data">
                    <input type="hidden" class="userid" name="id">
                    <div class="form-group">
                        <label for="photo" class="col-sm-3 control-label">Foto</label>
                        <div class="col-sm-9">
                            <input type="file" id="photo" name="photo" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Fechar</button>
                <button type="submit" class="btn btn-success btn-flat" name="upload"><i class="fa fa-check-square-o"></i> Atualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ativação Usuário -->
<div class="modal fade" id="activate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><strong>Ativando...</strong></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="users_activate.php">
                    <input type="hidden" class="userid" name="id">
                    <div class="text-center">
                        <p>Ativar Usuário</p>
                        <h2 class="bold fullname"></h2>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Fechar</button>
                <button type="submit" class="btn btn-success btn-flat" name="activate"><i class="fa fa-check"></i> Ativar</button>
                </form>
            </div>
        </div>
    </div>
</div>