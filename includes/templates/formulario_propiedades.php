<fieldset>
    <legend>Información general</legend>

    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Título propiedad" value="<?php echo s($propiedad->titulo); ?>">
    <?php if ($errores['titulo']): ?>
        <div class="alerta error"><?php echo $errores['titulo']; ?></div>
    <?php endif; ?>

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio propiedad" value="<?php echo s($propiedad->precio); ?>">
    <?php if ($errores['precio']): ?>
        <div class="alerta error"><?php echo $errores['precio']; ?></div>
    <?php endif; ?>

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">
    <?php if ($errores['imagen']): ?>
        <div class="alerta error"><?php echo $errores['imagen']; ?></div>
    <?php endif; ?>
    <?php if ($propiedad->imagen) : ?>
        <img src="/imagenes/<?php echo s($propiedad->imagen) ?>" alt="Imagen propiedad" class="imagen-small">
    <?php endif; ?>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="propiedad[descripcion]"><?php if (s($propiedad->descripcion) !== '') echo s($propiedad->descripcion); ?></textarea>
    <?php if ($errores['descripcion']): ?>
        <div class="alerta error"><?php echo $errores['descripcion']; ?></div>
    <?php endif; ?>
</fieldset>

<fieldset>
    <legend>Información propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">
    <?php if ($errores['habitaciones']): ?>
        <div class="alerta error"><?php echo $errores['habitaciones']; ?></div>
    <?php endif; ?>

    <label for="wc">Baños:</label>
    <input type="number" id="wc" name="propiedad[wc]" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">
    <?php if ($errores['wc']): ?>
        <div class="alerta error"><?php echo $errores['wc']; ?></div>
    <?php endif; ?>

    <label for="estacionamiento">Estacionamiento:</label>
    <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->estacionamiento); ?>">
    <?php if ($errores['estacionamiento']): ?>
        <div class="alerta error"><?php echo $errores['estacionamiento']; ?></div>
    <?php endif; ?>
</fieldset>

<fieldset>
    <legend>Vendedor</legend>

    <select name="propiedad[vendedor_id]">
        <option value="" selected disabled>-- Seleccionar vendedor --</option>
        <?php foreach ($vendedores as $vendedor): ?>
            <option 
            <?php echo $propiedad->vendedor_id === $vendedor->id ? 'selected' : ''; ?>
            value="<?php echo s($vendedor->id);?>"> 
                <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido);?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if ($errores['vendedor']): ?>
        <div class="alerta error"><?php echo $errores['vendedor']; ?></div>
    <?php endif; ?>
</fieldset>