<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $entrada->titulo; ?></h1>

    <picture>
        <source srcset="build/img/destacada2.webp" type="image/webp">
        <source srcset="build/img/destacada2.jpg" type="image/jpeg">
        <img src="build/img/destacada2.jpg" alt="Imagen de la propiedad" loading="lazy">
        <p class="informacion-meta">Escrito el: <span><?php echo $entrada->fecha; ?></span> por: <span><?php echo $entrada->usuario_id; ?></span></p>
    </picture>

    <div class="resumen-propiedad">
        <p><?php echo $entrada->contenido; ?></p>
    </div>
</main>