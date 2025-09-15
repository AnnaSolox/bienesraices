<main class="contenedor seccion contenido-centrado">
    <h1>Nuestro blog</h1>

    <?php foreach ($entradas as $entrada): ?>

        <article class="entrada-blog">
            <div class="imagen">
                <img src="/imagenes/<?php echo $entrada->imagen; ?>" alt="Foto blog" loading="lazy">
            </div>
            <div class="texto-entrada">
                <a href="/entrada?id=<?php echo $entrada->id ?>">
                    <h4><?php echo $entrada->titulo; ?></h4>
                    <p>Escrito el: <span><?php echo $entrada->fecha; ?></span> por: <span><?php echo $usuarios[$entrada->usuario_id]; ?></span></p>
                    <p><?php echo $entrada->resumen; ?>
                    </p>
                </a>
            </div>
        </article>

    <?php endforeach; ?>

</main>