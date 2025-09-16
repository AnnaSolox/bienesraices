<main class="contenedor seccion contenido-centrado">
    <h1>Nuestro blog</h1>

    <?php foreach ($entradas as $entrada): ?>

        <?php include __DIR__ . '/resumenEntrada.php'?>

    <?php endforeach; ?>

</main>