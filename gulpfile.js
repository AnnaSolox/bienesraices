import path from 'path'
import fs from 'fs'
import { glob } from 'glob'
import { src, dest, watch, series } from 'gulp' // importar funciones de gulp
import * as dartSass from 'sass' // importar sass
import gulpSass from 'gulp-sass' // importar gulp-sass
import terser from 'gulp-terser' // minificar js
import sharp from 'sharp'

const sass = gulpSass(dartSass); //enlazamos gulp con sas

export function js() {
    return src('src/js/app.js')
        .pipe(terser())
        .pipe(dest('build/js'));
}

export function css() {
    return src('src/scss/app.scss', { sourcemaps: true }) // source
        .pipe(sass({
            style: 'compressed'
        }).on('error', sass.logError)) // aplicar sass con la relación hecha previamente
        .pipe(dest('build/css', { sourcemaps: '.' }))
        .on('end', () => touchHTML()); // carpeta destino
}

// Función para actualizar timestamp del HTML
function touchHTML() {
  const htmlFile = 'index.php'; 
  const time = new Date();
  fs.utimesSync(htmlFile, time, time);
  console.log('✨ index.php actualizado para Live Server');
}


// Codigo de node.js para hacer las imágenes más pequeñas --> sharp + fs
export async function crop() {
    const inputFolder = 'src/img/'
    const outputFolder = 'build/img/thumb';
    const width = 250;
    const height = 180;
    if (!fs.existsSync(outputFolder)) {
        fs.mkdirSync(outputFolder, { recursive: true })
    }
    const images = fs.readdirSync(inputFolder).filter(file => {
        return /\.(jpg)$/i.test(path.extname(file));
    });
    try {
        return images.forEach(file => {
            const inputFile = path.join(inputFolder, file)
            const outputFile = path.join(outputFolder, file)
            sharp(inputFile)
                .resize(width, height, {
                    position: 'centre'
                })
                .toFile(outputFile)
        });
    } catch (error) {
        console.log(error)
    }
}


export async function imagenes() {
    const srcDir = './src/img';
    const buildDir = './build/img';
    const images = await glob('./src/img/*{jpg,png}')

    return images.forEach(file => {
        const relativePath = path.relative(srcDir, path.dirname(file));
        const outputSubDir = path.join(buildDir, relativePath);
        procesarImagenes(file, outputSubDir);
    });
}

function procesarImagenes(file, outputSubDir) {
    if (!fs.existsSync(outputSubDir)) {
        fs.mkdirSync(outputSubDir, { recursive: true })
    }
    const baseName = path.basename(file, path.extname(file))
    const extName = path.extname(file)
    const outputFile = path.join(outputSubDir, `${baseName}${extName}`)
    const outputFileWebp = path.join(outputSubDir, `${baseName}.webp`)
    const outputFileAvif = path.join(outputSubDir, `${baseName}.avif`)

    const options = { quality: 80 }
    if(!fs.existsSync(outputFile)) sharp(file).jpeg(options).toFile(outputFile)
    if(!fs.existsSync(outputFile)) sharp(file).webp(options).toFile(outputFileWebp)
    if(!fs.existsSync(outputFile)) sharp(file).avif(options).toFile(outputFileAvif)
}

export function dev() {
    console.log('🔄 Iniciando watch...');
    
    // Configuración específica para Docker
    const watchOptions = {
        ignoreInitial: false,
        usePolling: true,    // Importante para Docker
        interval: 1000       // Check cada segundo
    };
    
    watch('src/scss/**/*.scss', watchOptions, css)
        .on('change', path => console.log(`📝 SCSS changed: ${path}`));
        
    watch('src/js/**/*.js', watchOptions, js)
        .on('change', path => console.log(`📜 JS changed: ${path}`));
        
    watch('src/img/*.{png,jpg}', watchOptions, imagenes)
        .on('change', path => console.log(`🖼️ Image changed: ${path}`));
    
    console.log('👀 Watch activo - modifica archivos SCSS para probar');
}

// Inicializar todas las tareas cuando se abre la página
export default series(imagenes, crop, js, css, dev);