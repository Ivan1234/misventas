    <div class="form-group row">
        <label class="col-md-3 form-control-label" for="nombre">Nombre</label>
        <div class="col-md-9">
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del proveedor" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">            
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-3 form-control-label" for="direccion">Dirección</label>
        <div class="col-md-9">
            <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Ingrese la dirección" pattern="^[a-zA-Z_áéíóúñ\s]{0,200}$">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-3 form-control-label" for="documento">Documento</label>
        <div class="col-md-9">
            <select class="form-control" name="tipo_documento" id="tipo_documento">
                <option value="0" disabled>Seleccione</option>
                <option value="DNI">DNI</option>
                <option value="CÉDULA">CÉDULA</option>                
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-3 form-control-label" for="num_documento">Número del documento</label>
        <div class="col-md-9">
            <input type="text" name="num_documento" id="num_documento" class="form-control" placeholder="Ingrese el número del documento" pattern="[0-9]{0,15}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-3 form-control-label" for="telefono">Teléfono</label>
        <div class="col-md-9">
            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Ingrese el número de teléfono" pattern="[0-9]{0,15}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-3 form-control-label" for="email">E-mail</label>
        <div class="col-md-9">
            <input type="email" name="email" id="email" class="form-control" placeholder="Ingrese el correo electrónico">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i> Cerrar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
        
    </div>