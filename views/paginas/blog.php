<main class="contenedor seccion contenido-centrado">
    <h1>Nuestro blog</h1>

    <?php foreach ($entradas as $entrada): ?>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog1.webp" type="image/webp">
                    <source srcset="build/img/blog1.jpg" type="image/jpeg">
                    <img src="build/img/blog1.jpg" alt="Texto entrada blog" loading="lazy">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="/entrada?id=<?php echo $entrada->id ?>">
                    <h4><?php echo $entrada->titulo; ?></h4>
                    <p>Escrito el: <span><?php echo $entrada->fecha; ?></span> por: <span><?php echo $entrada->usuario_id; ?></span></p>
                    <p><?php echo $entrada->resumen; ?>
                    </p>
                </a>
            </div>
        </article>

    <?php endforeach; ?>

</main>