<fieldset>
    <legend>Información general</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre vendedor" value="<?php echo s($vendedor->nombre); ?>">
    <?php if ($errores['nombre']): ?>
        <div class="alerta error"><?php echo $errores['nombre']; ?></div>
    <?php endif; ?>

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido vendedor" value="<?php echo s($vendedor->apellido); ?>">
    <?php if ($errores['apellido']): ?>
        <div class="alerta error"><?php echo $errores['apellido']; ?></div>
    <?php endif; ?>

</fieldset>

<fieldset>
    <legend>Información extra</legend>

    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="vendedor[telefono]" placeholder="Teléfono vendedor" value="<?php echo s($vendedor->telefono); ?>">
    <?php if ($errores['telefono']): ?>
        <div class="alerta error"><?php echo $errores['telefono']; ?></div>
    <?php endif; ?>

</fieldset>