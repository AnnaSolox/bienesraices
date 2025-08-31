document.addEventListener('DOMContentLoaded', function() {

    eventListeners();

    darkMode();
});

function darkMode(){

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme:dark)');

    prefiereDarkMode.addEventListener('change', cambiarEsquemaColor)

    function cambiarEsquemaColor(){
        prefiereDarkMode.matches ?
        document.body.classList.add('dark-mode') :
        document.body.classList.remove('dark-mode');
    }

    const botonDarkMode = document.querySelector('.dark-mode-boton');
    botonDarkMode.addEventListener('click', toggleDarkMode);

    function toggleDarkMode(){
        document.body.classList.toggle('dark-mode');
    }
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);

    function navegacionResponsive(){
        const navegacion = document.querySelector('.navegacion');
        
        navegacion.classList.toggle('mostrar');
    }
}