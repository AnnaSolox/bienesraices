<?php 
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Casa en venta frente al bosque</h1>

    <picture>
        <source srcset="build/img/destacada.webp" type="image/webp">
        <source srcset="build/img/destacada.jpg" type="image/jpeg">
        <img src="build/img/destacada.jpg" alt="Imagen de la propiedad" loading="lazy">
    </picture>

    <div class="resumen-propiedad">
        <p class="precio">$3,000,000</p>

        <ul class="iconos-caracteristicas">
            <li>
                <img class="icono" src="build/img/icono_wc.svg" alt="Icono wc" loading="lazy" />
                <p>3</p>
            </li>
            <li>
                <img class="icono" src="build/img/icono_estacionamiento.svg" alt="Icono estacionamiento" loading="lazy" />
                <p>3</p>
            </li>
            <li>
                <img class="icono" src="build/img/icono_dormitorio.svg" alt="Icono habitaciones" loading="lazy" />
                <p>4</p>
            </li>
        </ul>

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