<?php 
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Guía para la decoración de tu hogar</h1>

    <picture>
        <source srcset="build/img/destacada2.webp" type="image/webp">
        <source srcset="build/img/destacada2.jpg" type="image/jpeg">
        <img src="build/img/destacada2.jpg" alt="Imagen de la propiedad" loading="lazy">
        <p class="informacion-meta">Escrito el: <span>20/10/21</span> por: <span>Admin</span></p>
    </picture>

    <div class="resumen-propiedad">
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione, quo doloremque earum laudantium
            expedita unde inventore. Reiciendis inventore cumque deleniti possimus ea maiores eum non, saepe
            assumenda expedita? Culpa, error?</p>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Animi esse similique quis, aspernatur magnam
            eos voluptatum quae vero rerum hic repellat ducimus nisi sint exercitationem facere. Nisi tempore ad
            illum.
            Doloremque cum eveniet facere earum molestiae culpa quibusdam saepe quo quidem pariatur illo ducimus
            voluptatibus similique fugit, repellendus cupiditate odio labore soluta veritatis, ab impedit error!
            Recusandae, fuga officia. Enim!
            Molestiae facilis aliquid corrupti deserunt, consequuntur odio totam tempore veniam cumque dicta
            nesciunt placeat. Cupiditate, tenetur exercitationem. Ut praesentium est nobis? Possimus aspernatur fuga
            autem perspiciatis culpa veniam saepe perferendis?</p>
    </div>
</main>

<?php incluirTemplate('footer'); ?>