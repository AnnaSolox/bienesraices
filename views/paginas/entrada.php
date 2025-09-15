<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $entrada->titulo; ?></h1>

    <img src="/imagenes/<?php echo $entrada->imagen; ?>" alt="Imagen de la entrada de blog" loading="lazy">
    <p class="informacion-meta">Escrito el: <span><?php echo $entrada->fecha; ?></span> por: <span><?php echo $usuario->nombre; ?></span></p>

    <div class="resumen-propiedad">
        <p><?php echo $entrada->contenido; ?></p>
    </div>
</main>