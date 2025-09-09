
<fieldset>
    <legend>Información general</legend>

    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo" placeholder="Título propiedad" value="<?php echo $propiedad->titulo; ?>">
    <?php if ($errores['titulo']): ?>
        <div class="alerta error"><?php echo $errores['titulo']; ?></div>
    <?php endif; ?>

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?php echo $propiedad->precio; ?>">
    <?php if ($errores['precio']): ?>
        <div class="alerta error"><?php echo $errores['precio']; ?></div>
    <?php endif; ?>

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
    <?php if ($errores['imagen']): ?>
        <div class="alerta error"><?php echo $errores['imagen']; ?></div>
    <?php endif; ?>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion"><?php if ($propiedad->descripcion !== '') echo $propiedad->descripcion; ?></textarea>
    <?php if ($errores['descripcion']): ?>
        <div class="alerta error"><?php echo $errores['descripcion']; ?></div>
    <?php endif; ?>
</fieldset>

<fieldset>
    <legend>Información propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $propiedad->habitaciones; ?>">
    <?php if ($errores['habitaciones']): ?>
        <div class="alerta error"><?php echo $errores['habitaciones']; ?></div>
    <?php endif; ?>

    <label for="wc">Baños:</label>
    <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $propiedad->wc; ?>">
    <?php if ($errores['wc']): ?>
        <div class="alerta error"><?php echo $errores['wc']; ?></div>
    <?php endif; ?>

    <label for="estacionamiento">Estacionamiento:</label>
    <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $propiedad->estacionamiento; ?>">
    <?php if ($errores['estacionamiento']): ?>
        <div class="alerta error"><?php echo $errores['estacionamiento']; ?></div>
    <?php endif; ?>
</fieldset>

<fieldset>
    <legend>Vendedor</legend>

    <select name="vendedor_id">
        <option value="" selected disabled>-- Seleccionar vendedor --</option>
        <?php while ($row = mysqli_fetch_assoc($resultado_vendedores)): ?>
            <option <?php echo $vendedor_id === $row['id'] ? 'selected' : ''; ?> value="<?php echo $row['id']; ?>">
                <?php echo $row['nombre'] . ' ' . $row['apellido']; ?>
            </option>
        <?php endwhile; ?>
    </select>
    <?php if ($errores['vendedor']): ?>
        <div class="alerta error"><?php echo $errores['vendedor']; ?></div>
    <?php endif; ?>
</fieldset>