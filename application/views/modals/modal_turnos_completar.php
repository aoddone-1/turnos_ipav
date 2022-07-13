
<div class="modal fade" id="modalCompletar" role="dialog" data-backdrop="static" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
<!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><strong style="color:red">Atencion!! </strong>Debe completar los siguientes datos</h5>
    </div>
    <div class="modal-body">
      <form id="updateUsuario-form" name="update" autocomplete="off" class="form needs-validation" action="update"  method="post" >
        <b><label class="text-info">Datos de Domicilio ACTUAL</label></b>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="selectprov" class="text-info">Provincia *</label><br>
            <select name="selectprov"  id="selectprov" class="form-control" required onchange="CargarLocalidadesProvincia(this.value);">
              <option value="">Seleccionar</option>
              <?php for ($i=0; $i < count($provincia); $i++) { ?>
                <option value="<?php echo $provincia[$i]['idprovincias']; ?>"><?php echo $provincia[$i]['nombre_provincia']; ?></option>
              <?php } ?>

            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="selectloc" class="text-info">Localidad *</label><br>
            <select name="selectloc"  id="selectloc" class="form-control" required>
              <option value="" >Seleccionar</option>
            </select>
          </div>
        </div>
        <div class="form-group">
            <label for="calle" class="text-info" >Calle *</label><br>
            <input type="text" name="calle" placeholder="ej: Av. Pedro Luro" id="calle" class="form-control form-control-sm" required>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
              <label class="text-info">Número * </label><br>
              <input type="text" placeholder="ej: 742" pattern="[0-9]{3,4}" title="La Altura debe contener solo números" required name="altura" id="altura" class="form-control form-control-sm " maxlength = "4">

          </div>
          <div class="form-group col-md-6">
            <label class="text-info">Departamento </label><br>
            <input type="text" placeholder="ej: A PA o 2 PB"  name="dpto" id="dpto" class="form-control form-control-sm " >
          </div>
        </div>
        <div class="btn-toolbar justify-content-between" role="toolbar" >
            <div class="input-group">
                <a class="btn btn-danger" href="<?php echo site_url('turnos/logout') ?>" role="button">Salir</a>
            </div>
            <div class="input-group">
                <button type="submit" name="update" class="btn btn-success">Actualizar</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
