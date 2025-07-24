// Variables globales
let currentSlideIndex = 0;
const slides = document.querySelectorAll('.carousel-slide');
const dots = document.querySelectorAll('.dot');
const carouselWrapper = document.getElementById('carouselWrapper');
const themeToggle = document.getElementById('themeToggle');
const musicToggle = document.getElementById('musicToggle');

let audioContext = null;
let audioBuffer = null; // Para almacenar el buffer de la canción
let sourceNode = null;  // Para el nodo de la fuente de audio que reproduce el buffer
let autoPlay = null;

// Función para cambiar slide
function showSlide(index) {
    currentSlideIndex = index;
    const offset = -index * 100;
    carouselWrapper.style.transform = `translateX(${offset}%)`;
    
    // Actualizar dots
    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
    });
}

// Función para ir al slide anterior
function prevSlide() {
    currentSlideIndex = currentSlideIndex === 0 ? slides.length - 1 : currentSlideIndex - 1;
    showSlide(currentSlideIndex);
}

// Función para ir al siguiente slide
function nextSlide() {
    currentSlideIndex = currentSlideIndex === slides.length - 1 ? 0 : currentSlideIndex + 1;
    showSlide(currentSlideIndex);
}

// Función para iniciar el carrusel automático
function startAutoPlay() {
    autoPlay = setInterval(nextSlide, 5000);
}

// Función para reproducir música de fondo (ahora carga un archivo)
async function playBackgroundMusic() {
    try {
        // Crea un nuevo AudioContext si no existe o si se cerró previamente
        if (!audioContext) {
            audioContext = new (window.AudioContext || window.webkitAudioContext)();
        }

        // Cargar el archivo de audio si aún no se ha cargado
        if (!audioBuffer) {
            // Reemplaza 'fontaine.mp3' con la ruta correcta a tu archivo de música
            const response = await fetch('Fontaine - HOYO-MiX.mp3'); 
            const arrayBuffer = await response.arrayBuffer();
            audioBuffer = await audioContext.decodeAudioData(arrayBuffer);
        }

        // Si ya hay un sourceNode activo, lo detenemos y lo reseteamos para evitar superposiciones
        if (sourceNode) {
            sourceNode.stop();
            sourceNode.disconnect();
            sourceNode = null;
        }

        // Crear un nuevo SourceNode cada vez que se reproduce (los SourceNodes solo se pueden iniciar una vez)
        sourceNode = audioContext.createBufferSource();
        sourceNode.buffer = audioBuffer;

        // Crear un GainNode para controlar el volumen
        const gainNode = audioContext.createGain();
        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime); // Volumen inicial (ajusta este valor si es necesario)

        sourceNode.connect(gainNode);
        gainNode.connect(audioContext.destination);

        sourceNode.loop = true; // Para que la canción se repita
        sourceNode.start(0); // Inicia la reproducción inmediatamente

        musicToggle.classList.add('playing');
        musicToggle.textContent = '🔊';
    } catch (e) {
        console.error('Error al reproducir música:', e);
        // Si hay un error, asegúrate de que el botón refleje que no está sonando
        musicToggle.classList.remove('playing');
        musicToggle.textContent = '🔇';
    }
}

// Función para detener la música
function stopBackgroundMusic() {
    if (sourceNode) {
        sourceNode.stop();
        sourceNode.disconnect(); // Desconecta el nodo para liberar recursos
        sourceNode = null;
    }
    if (audioContext) {
        audioContext.close(); // Cierra el contexto de audio para liberar recursos del sistema
        audioContext = null;
    }
    musicToggle.classList.remove('playing');
    musicToggle.textContent = '🎵';
}

// Inicialización del carrusel
function initCarousel() {
    if (slides.length > 0) {
        startAutoPlay();
        
        // Event listeners para navegación del carrusel
        document.getElementById('prevBtn').addEventListener('click', () => {
            clearInterval(autoPlay);
            prevSlide();
            startAutoPlay();
        });
        
        document.getElementById('nextBtn').addEventListener('click', () => {
            clearInterval(autoPlay);
            nextSlide();
            startAutoPlay();
        });
        
        // Event listeners para dots
        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                clearInterval(autoPlay);
                showSlide(parseInt(dot.dataset.index));
                startAutoPlay();
            });
        });
        
        // Pausar auto-play cuando el mouse está sobre el carrusel
        const carouselContainer = document.querySelector('.carousel-container');
        carouselContainer.addEventListener('mouseenter', () => {
            clearInterval(autoPlay);
        });
        
        carouselContainer.addEventListener('mouseleave', () => {
            startAutoPlay();
        });
    }
}

// Cambio de tema
themeToggle.addEventListener('click', () => {
    const currentTheme = document.body.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    
    document.body.setAttribute('data-theme', newTheme);
    themeToggle.textContent = newTheme === 'light' ? '🌙' : '☀️';
    
    // Guardar preferencia en localStorage
    localStorage.setItem('theme', newTheme);
});

// Control de música
musicToggle.addEventListener('click', () => {
    // Si no hay un sourceNode activo (es decir, la música no está sonando), la reproducimos
    if (!sourceNode || sourceNode.buffer === null || audioContext.state === 'closed') { 
        playBackgroundMusic();
    } else { // Si ya hay un sourceNode activo y la música está sonando, la detenemos
        stopBackgroundMusic();
    }
});

// Inicialización al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    // Cargar tema guardado
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.body.setAttribute('data-theme', savedTheme);
    themeToggle.textContent = savedTheme === 'light' ? '🌙' : '☀️';
    
    // Iniciar carrusel
    initCarousel();
    
    // Menú móvil
    document.getElementById('mobileMenuBtn').addEventListener('click', () => {
        const navLinks = document.querySelector('.nav-links');
        // Toggle de la visibilidad del menú móvil
        navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
    });
    
    // Suavizar desplazamiento para enlaces de anclaje
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // --- Botón "Volver al inicio" ---
    const backToTopBtn = document.createElement('button');
    backToTopBtn.id = 'backToTopBtn';
    backToTopBtn.textContent = '↑';
    backToTopBtn.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: var(--primary-color);
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 99;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.3s, transform 0.3s, background-color 0.3s;
        border: none;
        font-size: 1.5rem;
    `;
    document.body.appendChild(backToTopBtn);
    
    // Función para mostrar/ocultar el botón "Volver al inicio"
    function toggleBackToTopButton() {
        if (window.pageYOffset > 300) {
            backToTopBtn.style.opacity = '1';
            backToTopBtn.style.transform = 'translateY(0)';
        } else {
            backToTopBtn.style.opacity = '0';
            backToTopBtn.style.transform = 'translateY(20px)';
        }
    }
    
    // Evento para el botón "Volver al inicio"
    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Escuchar el evento scroll para mostrar/ocultar el botón
    window.addEventListener('scroll', toggleBackToTopButton);
    
    // Inicializar el estado del botón al cargar la página
    toggleBackToTopButton();
});