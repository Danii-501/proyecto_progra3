<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Felder-Silverman - Estilos de Aprendizaje</title>
    <style>
        :root {
            --rojo-muy-oscuro: #4a0e0e;
            --rojo-oscuro: #7a1a1a;
            --rojo-medio: #a52a2a;
            --rojo-claro: #cd5c5c;
            --rojo-suave: #f5b2b2;
            --blanco-roto: #fefefe;
            --gris-claro: #f8f8f8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', serif;
            line-height: 1.6;
            color: var(--rojo-muy-oscuro);
            background: linear-gradient(135deg, var(--gris-claro) 0%, var(--rojo-suave) 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            background: var(--blanco-roto);
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(122, 26, 26, 0.2);
            overflow: hidden;
        }

        /* Header con posicionamiento sticky */
        .header {
            position: sticky;
            top: 0;
            background: linear-gradient(45deg, var(--rojo-muy-oscuro), var(--rojo-oscuro));
            color: var(--blanco-roto);
            padding: 30px;
            text-align: center;
            z-index: 100;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: fadeInDown 1s ease-out;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
            animation: fadeInUp 1s ease-out 0.3s both;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 100px;
            height: 100px;
            background: rgba(205, 92, 92, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 60px;
            height: 60px;
            background: rgba(165, 42, 42, 0.1);
            border-radius: 50%;
            animation: float 4s ease-in-out infinite reverse;
        }

        .form-container {
            padding: 40px;
        }

        .question-block {
            margin-bottom: 30px;
            padding: 25px;
            background: var(--gris-claro);
            border-left: 5px solid var(--rojo-medio);
            border-radius: 8px;
            transition: all 0.3s ease;
            animation: slideInLeft 0.6s ease-out;
        }

        .question-block:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 16px rgba(122, 26, 26, 0.15);
            border-left-width: 8px;
        }

        #question-highlight {
            background: linear-gradient(135deg, var(--rojo-suave), var(--gris-claro));
            border-left-color: var(--rojo-oscuro);
        }

        .question-text {
            font-size: 1.1em;
            font-weight: bold;
            margin-bottom: 15px;
            color: var(--rojo-muy-oscuro);
        }

        .option-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .option-item {
            display: flex;
            align-items: center;
            padding: 12px;
            background: var(--blanco-roto);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .option-item:hover {
            background: var(--rojo-suave);
            transform: scale(1.02);
            border-color: var(--rojo-claro);
        }

        input[type="radio"] {
            margin-right: 12px;
            accent-color: var(--rojo-medio);
            transform: scale(1.2);
        }

        input[type="radio"]:checked + label {
            color: var(--rojo-oscuro);
            font-weight: bold;
        }

        input[type="radio"]:focus {
            outline: 2px solid var(--rojo-medio);
            outline-offset: 2px;
        }

        label {
            cursor: pointer;
            flex: 1;
            transition: color 0.3s ease;
        }

        .button-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 40px;
            padding: 20px;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--rojo-medio), var(--rojo-oscuro));
            color: var(--blanco-roto);
            box-shadow: 0 4px 15px rgba(165, 42, 42, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: var(--rojo-medio);
            border: 2px solid var(--rojo-medio);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(122, 26, 26, 0.4);
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, var(--rojo-oscuro), var(--rojo-muy-oscuro));
        }

        .btn-secondary:hover {
            background: var(--rojo-medio);
            color: var(--blanco-roto);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.6s ease;
        }

        .btn:active::before {
            width: 300px;
            height: 300px;
        }

        .progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 4px;
            background: linear-gradient(90deg, var(--rojo-medio), var(--rojo-claro));
            z-index: 1000;
            transition: width 0.3s ease;
            box-shadow: 0 2px 4px rgba(165, 42, 42, 0.3);
        }

        /* Sección multimedia */
        .multimedia-section {
            text-align: center;
            padding: 30px;
            background: linear-gradient(135deg, var(--rojo-suave), rgba(245, 178, 178, 0.3));
            margin: 20px 0;
            border-radius: 10px;
        }

        .multimedia-section img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(122, 26, 26, 0.2);
            animation: zoomIn 1s ease-out;
        }

        .results-container {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--blanco-roto);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 -10px 30px rgba(122, 26, 26, 0.2);
            transform: translateY(20px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.5s ease;
            min-height: 600px;
        }

        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--rojo-suave);
        }

        .results-header h2 {
            color: var(--rojo-oscuro);
            font-size: 2em;
            margin: 0;
        }

        .results-actions {
            display: flex;
            gap: 15px;
        }

        .chart-container {
            position: relative;
            width: 100%;
            max-width: 500px;
            margin: 0 auto 30px;
            padding: 20px;
            background: var(--gris-claro);
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(122, 26, 26, 0.1);
        }

        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9em;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 3px;
        }

        .results-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .dimension-card {
            background: linear-gradient(135deg, var(--gris-claro), var(--rojo-suave));
            padding: 20px;
            border-radius: 12px;
            border-left: 5px solid var(--rojo-medio);
            transition: all 0.3s ease;
            animation: slideInUp 0.6s ease-out;
        }

        .dimension-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(122, 26, 26, 0.15);
        }

        .dimension-title {
            color: var(--rojo-oscuro);
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .dimension-result {
            font-size: 1.1em;
            color: var(--rojo-muy-oscuro);
            margin-bottom: 8px;
        }

        .dimension-percentage {
            font-weight: bold;
            color: var(--rojo-medio);
        }

        .progress-visual {
            width: 100%;
            height: 8px;
            background: rgba(122, 26, 26, 0.2);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 10px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--rojo-medio), var(--rojo-oscuro));
            border-radius: 4px;
            transition: width 1s ease-out;
            animation: fillProgress 2s ease-out;
        }

        .recommendations {
            background: linear-gradient(135deg, var(--rojo-suave), rgba(245, 178, 178, 0.3));
            padding: 25px;
            border-radius: 12px;
            margin-top: 30px;
        }

        .recommendations h3 {
            color: var(--rojo-oscuro);
            margin-bottom: 15px;
        }

        .recommendation-item {
            background: var(--blanco-roto);
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border-left: 4px solid var(--rojo-medio);
            box-shadow: 0 2px 8px rgba(122, 26, 26, 0.1);
        }

        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            
            .header, .form-container, .button-group {
                display: none !important;
            }
            
            .results-container {
                position: static !important;
                transform: none !important;
                opacity: 1 !important;
                visibility: visible !important;
                box-shadow: none !important;
                padding: 20px !important;
            }
            
            .results-actions {
                display: none !important;
            }
            
            .chart-container {
                background: white !important;
                box-shadow: 1px 1px 3px rgba(0,0,0,0.2) !important;
            }
            
            .dimension-card {
                background: #f8f8f8 !important;
                border: 1px solid #ccc !important;
                break-inside: avoid;
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fillProgress {
            from {
                width: 0%;
            }
            to {
                width: var(--target-width);
            }
        }

        .results-container.show {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        /* Animaciones con keyframes */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(165, 42, 42, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(165, 42, 42, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(165, 42, 42, 0);
            }
        }

        .question-block:nth-child(odd) {
            animation-delay: 0.1s;
        }

        .question-block:nth-child(even) {
            animation-delay: 0.2s;
        }

        .question-block:first-child {
            border-left-color: var(--rojo-oscuro);
            border-left-width: 8px;
        }

        .question-block:last-child {
            animation: pulse 2s infinite;
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 10px;
            }
            
            .header h1 {
                font-size: 2em;
            }
            
            .form-container {
                padding: 20px;
            }
            
            .button-group {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 300px;
            }
        }

        .loader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 5px solid var(--rojo-suave);
            border-top: 5px solid var(--rojo-medio);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 2000;
            display: none;
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        /* Estilos para el Menú de Acciones Personalizado */
.custom-dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    bottom: 120%; /* Aparece hacia arriba para no chocar con el footer */
    left: 50%;
    transform: translateX(-50%);
    background-color: var(--blanco-roto);
    min-width: 280px;
    box-shadow: 0 10px 30px rgba(74, 14, 14, 0.2);
    border-radius: 12px;
    overflow: hidden;
    z-index: 1000;
    border: 1px solid var(--rojo-suave);
    animation: fadeInUp 0.4s ease-out;
}

/* Mostrar el menú al pasar el mouse o hacer clic (configurable) */
.custom-dropdown:hover .dropdown-content {
    display: block;
}

.dropdown-item-link {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    text-decoration: none;
    color: var(--rojo-muy-oscuro);
    font-family: 'Georgia', serif;
    font-size: 0.95em;
    border-bottom: 1px solid var(--gris-claro);
    transition: all 0.3s ease;
    background: none;
    width: 100%;
    text-align: left;
    border-left: 4px solid transparent;
    cursor: pointer;
}

.dropdown-item-link:hover {
    background-color: var(--rojo-suave);
    border-left: 4px solid var(--rojo-medio);
    padding-left: 25px;
}

.dropdown-item-link i, .dropdown-item-link span {
    margin-right: 10px;
}

/* Estilo especial para el botón de eliminar */
.item-danger:hover {
    background-color: #ffe5e5;
    border-left-color: #dc3545;
    color: #a71d2a;
}

.dropdown-header-label {
    background: var(--gris-claro);
    padding: 8px 20px;
    font-size: 0.75em;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--rojo-claro);
    font-weight: bold;
}

    </style>
</head>
<body>
    <div class="progress-bar" id="progressBar"></div>
    <div class="loader" id="loader"></div>

    <div class="container">
        <header class="header">
            <h1>Test de Felder-Silverman</h1>
            <p>Descubre tu estilo de aprendizaje personal</p>
        </header>

        <div class="multimedia-section">
            <svg width="200" height="150" viewBox="0 0 200 150">
                <defs>
                    <linearGradient id="brainGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#a52a2a"/>
                        <stop offset="100%" style="stop-color:#7a1a1a"/>
                    </linearGradient>
                </defs>
                <path d="M50 75 Q 100 25, 150 75 Q 125 125, 100 100 Q 75 125, 50 75" 
                    fill="url(#brainGradient)" opacity="0.8"/>
                <circle cx="80" cy="60" r="8" fill="#4a0e0e"/>
                <circle cx="120" cy="60" r="8" fill="#4a0e0e"/>
                <path d="M90 80 Q 100 90, 110 80" stroke="#4a0e0e" stroke-width="2" fill="none"/>
            </svg>
            <p>Conoce cómo procesas mejor la información</p>
        </div>

<form id="learningStyleForm" method="POST" action="procesar_test.php" style="max-width: 900px; margin: auto;">
    
    <div class="form-container" style="margin-bottom: 30px; border-left: 5px solid var(--rojo-oscuro); background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: var(--rojo-muy-oscuro); margin-bottom: 20px; border-bottom: 2px solid var(--rojo-suave); padding-bottom: 10px;">
            <i class="fas fa-user-circle"></i> Datos de Perfil Académico
        </h2>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="field-group">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nombre Completo:</label>
                <input type="text" name="nombre" placeholder="Ej: Juan Pérez" required class="option-item" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            
            <div class="field-group">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email Institucional:</label>
                <input type="email" name="email" placeholder="usuario@universidad.edu" required class="option-item" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div class="field-group">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Fecha de Nacimiento:</label>
                <input type="date" name="fecha_nac" required class="option-item" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div class="field-group">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Carrera / Área:</label>
                <select name="carrera" required class="option-item" style="width: 100%; height: 42px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="">Seleccione Carrera...</option>
                    <option value="Sistemas">Ingeniería de Sistemas</option>
                    <option value="Psicologia">Psicología</option>
                    <option value="Diseno">Diseño Gráfico</option>
                    <option value="Administracion">Administración</option>
                </select>
            </div>
        </div>

        <div class="field-group" style="margin-top: 15px;">
            <label style="font-weight: bold;">Género:</label>
            <div style="display: flex; gap: 25px; margin-top: 10px;">
                <label><input type="radio" name="genero" value="M" required> Masculino</label>
                <label><input type="radio" name="genero" value="F"> Femenino</label>
                <label><input type="radio" name="genero" value="Otro"> Otro</label>
            </div>
        </div>

        <div style="margin-top: 20px; padding: 15px; background: #fff5f5; border-radius: 5px; border: 1px solid var(--rojo-suave);">
            <label style="font-size: 0.9em; display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <input type="checkbox" name="acepto" required style="width: 18px; height: 18px;">
                Acepto el procesamiento lógico de mis datos para fines estadísticos y académicos.
            </label>
        </div>
    </div>

    <div id="questions-container" style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <h2 style="color: var(--rojo-muy-oscuro); margin-bottom: 25px;">Cuestionario de Estilos (Felder-Silverman)</h2>
        
        <div class="question-block" style="margin-bottom: 20px; padding: 15px; border-bottom: 1px solid #eee;">
            <div class="question-text" style="font-weight: bold; margin-bottom: 10px;">1. Cuando estudio para un examen, prefiero:</div>
            <div style="display: grid; gap: 10px;">
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q1" value="a" required> Hacer ejercicios prácticos y resolver problemas similares</label>
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q1" value="b"> Leer la teoría y reflexionar sobre los conceptos</label>
            </div>
        </div>

        <div class="question-block" style="margin-bottom: 20px; padding: 15px; border-bottom: 1px solid #eee;">
            <div class="question-text" style="font-weight: bold; margin-bottom: 10px;">2. Para entender mejor un tema nuevo, necesito:</div>
            <div style="display: grid; gap: 10px;">
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q2" value="a" required> Ver ejemplos concretos y aplicaciones reales</label>
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q2" value="b"> Entender primero la teoría y los principios generales</label>
            </div>
        </div>

        <div class="question-block" style="margin-bottom: 20px; padding: 15px; border-bottom: 1px solid #eee;">
            <div class="question-text" style="font-weight: bold; margin-bottom: 10px;">3. Cuando resuelvo problemas, tiendo a:</div>
            <div style="display: grid; gap: 10px;">
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q3" value="a" required> Seguir pasos ordenados y sistemáticos</label>
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q3" value="b"> Hacer conexiones creativas y saltar entre ideas</label>
            </div>
        </div>

        <div class="question-block" style="margin-bottom: 20px; padding: 15px; border-bottom: 1px solid #eee;">
            <div class="question-text" style="font-weight: bold; margin-bottom: 10px;">4. Aprendo mejor cuando la información se presenta:</div>
            <div style="display: grid; gap: 10px;">
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q4" value="a" required> De forma visual con diagramas, gráficos y esquemas</label>
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q4" value="b"> A través de explicaciones verbales y textos</label>
            </div>
        </div>

        <div class="question-block" style="margin-bottom: 20px; padding: 15px; border-bottom: 1px solid #eee;">
            <div class="question-text" style="font-weight: bold; margin-bottom: 10px;">5. Cuando trabajo en equipo, prefiero:</div>
            <div style="display: grid; gap: 10px;">
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q5" value="a" required> Discutir ideas y colaborar activamente</label>
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q5" value="b"> Trabajar independientemente y luego compartir resultados</label>
            </div>
        </div>

        <div class="question-block" style="margin-bottom: 20px; padding: 15px; border-bottom: 1px solid #eee;">
            <div class="question-text" style="font-weight: bold; margin-bottom: 10px;">6. Mi forma de procesar información es más:</div>
            <div style="display: grid; gap: 10px;">
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q6" value="a" required> Paso a paso, construyendo comprensión gradualmente</label>
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q6" value="b"> Global, viendo primero el panorama completo</label>
            </div>
        </div>

        <div class="question-block" style="margin-bottom: 20px; padding: 15px; border-bottom: 1px solid #eee;">
            <div class="question-text" style="font-weight: bold; margin-bottom: 10px;">7. Para recordar información, me ayuda más:</div>
            <div style="display: grid; gap: 10px;">
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q7" value="a" required> Repetir y practicar activamente</label>
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q7" value="b"> Reflexionar y hacer conexiones mentales</label>
            </div>
        </div>

        <div class="question-block" style="margin-bottom: 20px; padding: 15px;">
            <div class="question-text" style="font-weight: bold; margin-bottom: 10px;">8. Cuando leo instrucciones, prefiero:</div>
            <div style="display: grid; gap: 10px;">
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q8" value="a" required> Diagramas de flujo y representaciones gráficas</label>
                <label class="option-item" style="display: flex; gap: 10px; cursor: pointer;"><input type="radio" name="q8" value="b"> Explicaciones detalladas por escrito</label>
            </div>
        </div>
    </div>

<div class="button-group">
    
    <button type="button" class="btn btn-secondary" onclick="resetForm()">
        🔄 REINICIAR
    </button>

    <button type="submit" class="btn btn-primary">
        💾 GUARDAR DATOS
    </button>

    <div class="custom-dropdown">
        <button type="button" class="btn btn-primary" style="background: var(--rojo-muy-oscuro);">
            ⚙️ MÁS OPCIONES
        </button>
        
        <div class="dropdown-content">
            <div class="dropdown-header-label">Consultas</div>
            <a href="consultas.php" class="dropdown-item-link">🔍 Consulta General</a>
            <a href="consulta_individual.php" class="dropdown-item-link">🔎 Consulta Individual</a>
            
            <div class="dropdown-header-label">Administración</div>
            <a href="actualizar.php" class="dropdown-item-link">✏️ Actualizar Registro</a>
            <a href="reporte.php" class="dropdown-item-link">📊 Generar Reporte</a>
            
            <div class="dropdown-header-label" style="color: #dc3545;">Zona de Peligro</div>
            <a href="eliminar.php" class="dropdown-item-link item-danger">🗑️ Eliminar Registro</a>
        </div>
    </div>

</div>
</div>
</form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>

    let currentProgress = 0;
    let currentChart = null;
    let chartType = 'bar'; 
    const totalQuestions = 8; 

    function updateProgress() {
        const answered = document.querySelectorAll('input[type="radio"]:checked').length;
        const progress = (answered / totalQuestions) * 100;
        const bar = document.getElementById('progressBar');
        if(bar) bar.style.width = progress + '%';
    }

    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', updateProgress);
    });

    function resetForm() {
        if(confirm("¿Estás seguro de que deseas reiniciar todo el test?")) {
            document.getElementById('learningStyleForm').reset();
            updateProgress();
            document.getElementById('resultsContainer').classList.remove('show');
            if (currentChart) {
                currentChart.destroy();
                currentChart = null;
            }
        }
    }

    function processResults(formData) {
        const results = { active: 0, reflective: 0, sensing: 0, intuitive: 0, visual: 0, verbal: 0, sequential: 0, global: 0 };
        const questionsMap = {
            1: { 'a': 'active', 'b': 'reflective' }, 
            2: { 'a': 'sensing', 'b': 'intuitive' }, 
            3: { 'a': 'sequential', 'b': 'global' }, 
            4: { 'a': 'visual', 'b': 'verbal' },     
            5: { 'a': 'active', 'b': 'reflective' }, 
            6: { 'a': 'sequential', 'b': 'global' }, 
            7: { 'a': 'active', 'b': 'reflective' }, 
            8: { 'a': 'visual', 'b': 'verbal' }      
        };

        for (let i = 1; i <= totalQuestions; i++) {
            const answer = formData.get(`q${i}`);
            if (answer && questionsMap[i]) {
                results[questionsMap[i][answer]]++;
            }
        }
        return results;
    }

    document.getElementById('learningStyleForm').addEventListener('submit', function(event) {

        event.preventDefault(); 
        
        const form = event.target;
        const loader = document.getElementById('loader');
        const resultsContainer = document.getElementById('resultsContainer');
        const formContainer = document.querySelector('.form-container');

        // Mostrar efectos visuales
        if(loader) loader.style.display = 'block';
        formContainer.style.opacity = '0.5';

        const formData = new FormData(form);
        const results = processResults(formData);

        if(typeof createInteractiveChart === "function") {
            createInteractiveChart(results); 
        }

        setTimeout(() => {
            if(loader) loader.style.display = 'none';
            formContainer.style.opacity = '1';
            if(resultsContainer) resultsContainer.classList.add('show');

            alert("¡Test procesado visualmente! Ahora guardaremos tus datos en el sistema.");

            form.submit(); 
        }, 2000); 
    });

    document.addEventListener('DOMContentLoaded', updateProgress);
</script>
</body>
</html>