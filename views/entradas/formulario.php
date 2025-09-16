<fieldset>
    <legend>Información entrada</legend>

    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="entrada[titulo]" placeholder="Título entrada" value="<?php echo s($entrada->titulo); ?>">
    <?php if ($errores['titulo']): ?>
        <div class="alerta error"><?php echo $errores['titulo']; ?></div>
    <?php endif; ?>

    <label for="resumen">Resumen:</label>
    <input type="text" id="resumen" name="entrada[resumen]" placeholder="Resumen entrada" value="<?php echo s($entrada->resumen); ?>">
    <?php if ($errores['resumen']): ?>
        <div class="alerta error"><?php echo $errores['resumen']; ?></div>
    <?php endif; ?>

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="entrada[imagen]">
    <?php if ($errores['imagen']): ?>
        <div class="alerta error"><?php echo $errores['imagen']; ?></div>
    <?php endif; ?>
    <?php if ($entrada->imagen) : ?>
        <img src="/imagenes/<?php echo s($entrada->imagen) ?>" alt="Imagen entrada" class="imagen-small">
    <?php endif; ?>

    <label for="contenido">Contenido:</label>
    <textarea contenteditable="true" id="contenido" name="entrada[contenido]"><?php if (s($entrada->contenido) !== '') echo s($entrada->contenido); ?></textarea>
    <?php if ($errores['contenido']): ?>
        <div class="alerta error"><?php echo $errores['contenido']; ?></div>
    <?php endif; ?>
</fieldset>