<?php
// Conexión a la base de datos
$conn = new mysqli(hostname: "localhost", username: "root", password: "", database: "portafolio");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los proyectos
$sql = "SELECT * FROM proyectos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio de Asier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            scroll-behavior: smooth;
        }

        section {
            padding: 60px 0;
        }

        #footer {
            padding: 20px 0;
            background-color: #f8f9fa;
            text-align: center;
        }

        .card-body:hover {
            background-color: #f1f1f1;
        }

        .modal-header,
        .modal-footer {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="#">Portafolio</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#inicio">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#proyectos">Proyectos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contacto">Contacto</a>
                </li>
            </ul>
            <form class="form-inline ml-3">
                <input id="buscarProyecto" class="form-control mr-sm-2" type="search" placeholder="Buscar proyectos"
                       aria-label="Buscar">
            </form>
        </div>
    </nav>

    <section id="inicio" class="container text-center" style="margin-top: 80px;">
        <div class="p-3 mb-2 bg-secondary text-white">
            <picture>
                <source srcset="" type="image/svg+xml">
                <img src="Imagenes/Picture.png" class="img-fluid img-thumbnail" alt="..." width="150">
            </picture>
            <h1>Hola, soy Asier</h1>
        </div>
        <p>Soy Administrador de Sistemas y me apasionan los videojuegos. Estudié en CIP Cuatrovientos, y tengo
            experiencia trabajando en distintos entornos de TI, gestionando redes, servidores y asegurando el correcto
            funcionamiento de sistemas críticos.</p>
    </section>

    <section id="proyectos" class="container">
        <div class="p-3 mb-2 bg-secondary text-white">
            <h2 class="text-center">Mis Proyectos</h2>
        </div>
        <div class="row" id="projectCards">

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="Imagenes/' . htmlspecialchars($row['imagen']) . '" class="card-img-top" alt="' . htmlspecialchars($row['titulo']) . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row['titulo']) . '</h5>';
                    echo '<p class="card-text">' . htmlspecialchars($row['descripcion']) . '</p>';
                    echo '<button class="btn btn-primary" data-toggle="modal" data-target="#modalProyecto' . $row['id'] . '">Más información</button>';
                    echo '</div></div></div>';

                    // Modal para cada proyecto
                    echo '<div class="modal fade" id="modalProyecto' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="modalProyecto' . $row['id'] . 'Label" aria-hidden="true">';
                    echo '<div class="modal-dialog" role="document"><div class="modal-content">';
                    echo '<div class="modal-header"><h5 class="modal-title" id="modalProyecto' . $row['id'] . 'Label">' . htmlspecialchars($row['titulo']) . '</h5>';
                    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                    echo '<div class="modal-body">' . htmlspecialchars($row['detalles']) . '</div>';
                    echo '<div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button></div>';
                    echo '</div></div></div>';
                }
            } else {
                echo "<p>No hay proyectos disponibles.</p>";
            }
            ?>

        </div>
    </section>

    <section id="contacto" class="container">
        <h2 class="text-center">Contacto</h2>
        <form id="contactForm">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" placeholder="Tu nombre" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" placeholder="Tu correo electrónico" required>
            </div>
            <div class="form-group">
                <label for="mensaje">Mensaje</label>
                <textarea class="form-control" id="mensaje" rows="3" placeholder="Tu mensaje" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </section>

    <footer id="footer">
        <p>&copy; 2024 Asier | Administrador de Sistemas y Apasionado por los Videojuegos</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>

        document.getElementById('contactForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const email = document.getElementById('email').value;
            const nombre = document.getElementById('nombre').value;
            if (email && nombre) {
                alert('Gracias, ' + nombre + '. ¡Su mensaje ha sido enviado con éxito!');
            }
        });

        document.getElementById('buscarProyecto').addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const projects = document.querySelectorAll('#projectCards .card');
            projects.forEach(function (card) {
                const title = card.querySelector('.card-title').textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>

</body>
</html>

<?php $conn->close(); ?>
