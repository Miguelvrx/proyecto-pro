<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="bi bi-tag"></i> Editor</h1>
    </div>
</div>
<button class="btn btn-primary mb-2" type="button" onclick="frmEditorial()"><i class="fa fa-plus"></i></button>
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tblEditorial">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Situación</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="nuevoEditorial" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="title">Registrar Editor</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmEditorial">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="editorial">Nombre</label>
                                <input type="hidden" id="id" name="id">
                                <input id="editorial" class="form-control" type="text" name="editorial" required placeholder="Nombre del Editorial">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" onclick="registrarEditorial(event)" id="btnAccion">Registrarse</button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal">Volver</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>
