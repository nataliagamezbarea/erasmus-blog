<?php
// likes.php
include "../../../backend/config.php";

// Conexión a la base de datos
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");

// 1. País con más likes
$result = $conexion->query("
    SELECT p.nombre AS pais, COUNT(l.id) AS total_likes
    FROM publicaciones pub
    JOIN paises p ON pub.pais_id = p.id
    LEFT JOIN likes l ON l.publicacion_id = pub.id
    GROUP BY pub.pais_id
    HAVING COUNT(l.id) > 0
    ORDER BY total_likes DESC
    LIMIT 1
");
$paisConMasLikes = ($result && $row = $result->fetch_assoc()) ? $row['pais'] : 'Ninguno';

// 2. Número total de likes
$result = $conexion->query("SELECT COUNT(id) AS total FROM likes");
$totalLikes = ($result && $row = $result->fetch_assoc()) ? $row['total'] : 0;

// 3. Usuario con más likes recibidos
$result = $conexion->query("
    SELECT u.nombre_usuario, COUNT(l.id) AS total_likes
    FROM publicaciones pub
    JOIN usuarios u ON pub.usuario_id = u.id
    LEFT JOIN likes l ON l.publicacion_id = pub.id
    GROUP BY pub.usuario_id
    HAVING COUNT(l.id) > 0
    ORDER BY total_likes DESC
    LIMIT 1
");
$usuarioMasLikes = ($result && $row = $result->fetch_assoc()) ? $row['nombre_usuario'] : 'Ninguno';

// 4. País con menos likes
$result = $conexion->query("
    SELECT p.nombre AS pais, COUNT(l.id) AS total_likes
    FROM publicaciones pub
    JOIN paises p ON pub.pais_id = p.id
    LEFT JOIN likes l ON l.publicacion_id = pub.id
    GROUP BY pub.pais_id
    HAVING COUNT(l.id) > 0
    ORDER BY total_likes ASC
    LIMIT 1
");
$paisConMenosLikes = ($result && $row = $result->fetch_assoc()) ? $row['pais'] : 'Ninguno';

// 5. Top 5 países por likes
$topPaises = [];
$result = $conexion->query("
    SELECT p.nombre AS pais, COUNT(l.id) AS total_likes
    FROM publicaciones pub
    JOIN paises p ON pub.pais_id = p.id
    LEFT JOIN likes l ON l.publicacion_id = pub.id
    GROUP BY pub.pais_id
    ORDER BY total_likes DESC
    LIMIT 5
");
$maxLikesPais = 1;
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $topPaises[] = $row;
        if ($row['total_likes'] > $maxLikesPais) $maxLikesPais = $row['total_likes'];
    }
}

// 6. Likes por día de la semana
$diasSemana = ["Lunes" => 0, "Martes" => 0, "Miércoles" => 0, "Jueves" => 0, "Viernes" => 0, "Sábado" => 0, "Domingo" => 0];
$result = $conexion->query("
    SELECT DAYOFWEEK(pub.fecha_publicacion) AS dia, COUNT(l.id) AS total
    FROM publicaciones pub
    LEFT JOIN likes l ON l.publicacion_id = pub.id
    GROUP BY dia
");
$maxLikesDia = 1;
if ($result) {
    while ($row = $result->fetch_assoc()) {
        switch ($row['dia']) {
            case 1:
                $diasSemana['Domingo'] = $row['total'];
                break;
            case 2:
                $diasSemana['Lunes'] = $row['total'];
                break;
            case 3:
                $diasSemana['Martes'] = $row['total'];
                break;
            case 4:
                $diasSemana['Miércoles'] = $row['total'];
                break;
            case 5:
                $diasSemana['Jueves'] = $row['total'];
                break;
            case 6:
                $diasSemana['Viernes'] = $row['total'];
                break;
            case 7:
                $diasSemana['Sábado'] = $row['total'];
                break;
        }
        if ($row['total'] > $maxLikesDia) $maxLikesDia = $row['total'];
    }
}

// 7. Últimas publicaciones con likes
$ultimasPublicaciones = [];
$result = $conexion->query("
    SELECT pub.titulo
    FROM publicaciones pub
    JOIN likes l ON l.publicacion_id = pub.id
    GROUP BY pub.id
    ORDER BY pub.fecha_publicacion DESC, pub.hora_publicacion DESC
    LIMIT 9
");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $ultimasPublicaciones[] = htmlspecialchars($row["titulo"], ENT_QUOTES, "UTF-8");
    }
}

// Cerrar conexión
$conexion->close();
$alturaMax = 400; // altura máxima vh para las barras
?>
<!-- HTML -->
<div class="row invoice-card-row">
    <!-- País con más likes -->
    <div class="col-xl-3 col-xxl-3 col-sm-6">
        <div class="card bg-warning invoice-card">
            <div class="card-body d-flex">
                <div class="icon me-3">
                <svg width="33px" height="32px">
                        <path fill-rule="evenodd" fill="rgb(255, 255, 255)" d="M31.963,30.931 C31.818,31.160 31.609,31.342 31.363,31.455 C31.175,31.538 30.972,31.582 30.767,31.583 C30.429,31.583 30.102,31.463 29.845,31.243 L25.802,27.786 L21.758,31.243 C21.502,31.463 21.175,31.583 20.837,31.583 C20.498,31.583 20.172,31.463 19.915,31.243 L15.872,27.786 L11.829,31.243 C11.622,31.420 11.370,31.534 11.101,31.572 C10.832,31.609 10.558,31.569 10.311,31.455 C10.065,31.342 9.857,31.160 9.710,30.931 C9.565,30.703 9.488,30.437 9.488,30.167 L9.488,17.416 L2.395,17.416 C2.019,17.416 1.658,17.267 1.392,17.001 C1.126,16.736 0.976,16.375 0.976,16.000 L0.976,6.083 C0.976,4.580 1.574,3.139 2.639,2.076 C3.703,1.014 5.146,0.417 6.651,0.417 L26.511,0.417 C28.016,0.417 29.459,1.014 30.524,2.076 C31.588,3.139 32.186,4.580 32.186,6.083 L32.186,30.167 C32.186,30.437 32.109,30.703 31.963,30.931 ZM9.488,6.083 C9.488,5.332 9.189,4.611 8.657,4.080 C8.125,3.548 7.403,3.250 6.651,3.250 C5.898,3.250 5.177,3.548 4.645,4.080 C4.113,4.611 3.814,5.332 3.814,6.083 L3.814,14.583 L9.488,14.583 L9.488,6.083 ZM29.348,6.083 C29.348,5.332 29.050,4.611 28.517,4.080 C27.985,3.548 27.263,3.250 26.511,3.250 L11.559,3.250 C12.059,4.111 12.324,5.088 12.325,6.083 L12.325,27.092 L14.950,24.840 C15.207,24.620 15.534,24.500 15.872,24.500 C16.210,24.500 16.537,24.620 16.794,24.840 L20.837,28.296 L24.880,24.840 C25.137,24.620 25.463,24.500 25.802,24.500 C26.140,24.500 26.467,24.620 26.724,24.840 L29.348,27.092 L29.348,6.083 ZM25.092,20.250 L16.581,20.250 C16.205,20.250 15.844,20.101 15.578,19.835 C15.312,19.569 15.162,19.209 15.162,18.833 C15.162,18.457 15.312,18.097 15.578,17.831 C15.844,17.566 16.205,17.416 16.581,17.416 L25.092,17.416 C25.469,17.416 25.829,17.566 26.096,17.831 C26.362,18.097 26.511,18.457 26.511,18.833 C26.511,19.209 26.362,19.569 26.096,19.835 C25.829,20.101 25.469,20.250 25.092,20.250 ZM25.092,14.583 L16.581,14.583 C16.205,14.583 15.844,14.434 15.578,14.168 C15.312,13.903 15.162,13.542 15.162,13.167 C15.162,12.791 15.312,12.430 15.578,12.165 C15.844,11.899 16.205,11.750 16.581,11.750 L25.092,11.750 C25.469,11.750 25.829,11.899 26.096,12.165 C26.362,12.430 26.511,12.791 26.511,13.167 C26.511,13.542 26.362,13.903 26.096,14.168 C25.829,14.434 25.469,14.583 25.092,14.583 ZM25.092,8.916 L16.581,8.916 C16.205,8.916 15.844,8.767 15.578,8.501 C15.312,8.236 15.162,7.875 15.162,7.500 C15.162,7.124 15.312,6.764 15.578,6.498 C15.844,6.232 16.205,6.083 16.581,6.083 L25.092,6.083 C25.469,6.083 25.829,6.232 26.096,6.498 C26.362,6.764 26.511,7.124 26.511,7.500 C26.511,7.875 26.362,8.236 26.096,8.501 C25.829,8.767 25.469,8.916 25.092,8.916 Z" />
                    </svg>
                   
                </div>
                <div>
                    <h2 class="text-white invoice-num"><?= $paisConMasLikes ?></h2>
                    <span class="text-white fs-18">País con más likes</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Número de likes totales -->
    <div class="col-xl-3 col-xxl-3 col-sm-6">
        <div class="card bg-success invoice-card">
            <div class="card-body d-flex">
                <div class="icon me-3">
                <svg width="35px" height="34px">
                        <path fill-rule="evenodd" fill="rgb(255, 255, 255)" d="M33.002,9.728 C31.612,6.787 29.411,4.316 26.638,2.583 C22.781,0.179 18.219,-0.584 13.784,0.438 C9.356,1.454 5.585,4.137 3.178,7.989 C0.764,11.840 -0.000,16.396 1.023,20.825 C2.048,25.247 4.734,29.013 8.584,31.417 C11.297,33.110 14.409,34.006 17.594,34.006 L17.800,34.006 C20.973,33.967 24.058,33.050 26.731,31.363 C27.509,30.872 27.735,29.849 27.243,29.072 C26.751,28.296 25.727,28.070 24.949,28.561 C22.801,29.922 20.314,30.660 17.761,30.693 C15.141,30.726 12.581,30.002 10.346,28.614 C7.241,26.675 5.080,23.647 4.262,20.088 C3.444,16.515 4.056,12.850 5.997,9.748 C10.001,3.353 18.473,1.401 24.876,5.399 C27.110,6.793 28.879,8.779 29.996,11.143 C31.087,13.447 31.513,16.004 31.227,18.527 C31.126,19.437 31.778,20.260 32.696,20.360 C33.607,20.459 34.432,19.809 34.531,18.892 C34.884,15.765 34.352,12.591 33.002,9.728 L33.002,9.728 Z" />
                        <path fill-rule="evenodd" fill="rgb(255, 255, 255)" d="M23.380,11.236 C22.728,10.585 21.678,10.585 21.026,11.236 L17.608,14.656 L14.190,11.243 C13.539,10.592 12.488,10.592 11.836,11.243 C11.184,11.893 11.184,12.942 11.836,13.593 L15.254,17.006 L11.836,20.420 C11.184,21.071 11.184,22.120 11.836,22.770 C12.162,23.096 12.588,23.255 13.014,23.255 C13.438,23.255 13.864,23.096 14.190,22.770 L17.608,19.357 L21.026,22.770 C21.352,23.096 21.777,23.255 22.203,23.255 C22.629,23.255 23.054,23.096 23.380,22.770 C24.031,22.120 24.031,21.071 23.380,20.420 L19.962,17.000 L23.380,13.587 C24.031,12.936 24.031,11.887 23.380,11.236 L23.380,11.236 Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-white invoice-num"><?= $totalLikes ?></h2>
                    <span class="text-white fs-18">Número de Likes totales</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Usuario con más likes -->
    <div class="col-xl-3 col-xxl-3 col-sm-6">
        <div class="card bg-info invoice-card">
            <div class="card-body d-flex">
                <div class="icon me-3">
                <svg width="33px" height="32px">
                        <path fill-rule="evenodd" fill="rgb(255, 255, 255)" d="M31.963,30.931 C31.818,31.160 31.609,31.342 31.363,31.455 C31.175,31.538 30.972,31.582 30.767,31.583 C30.429,31.583 30.102,31.463 29.845,31.243 L25.802,27.786 L21.758,31.243 C21.502,31.463 21.175,31.583 20.837,31.583 C20.498,31.583 20.172,31.463 19.915,31.243 L15.872,27.786 L11.829,31.243 C11.622,31.420 11.370,31.534 11.101,31.572 C10.832,31.609 10.558,31.569 10.311,31.455 C10.065,31.342 9.857,31.160 9.710,30.931 C9.565,30.703 9.488,30.437 9.488,30.167 L9.488,17.416 L2.395,17.416 C2.019,17.416 1.658,17.267 1.392,17.001 C1.126,16.736 0.976,16.375 0.976,16.000 L0.976,6.083 C0.976,4.580 1.574,3.139 2.639,2.076 C3.703,1.014 5.146,0.417 6.651,0.417 L26.511,0.417 C28.016,0.417 29.459,1.014 30.524,2.076 C31.588,3.139 32.186,4.580 32.186,6.083 L32.186,30.167 C32.186,30.437 32.109,30.703 31.963,30.931 ZM9.488,6.083 C9.488,5.332 9.189,4.611 8.657,4.080 C8.125,3.548 7.403,3.250 6.651,3.250 C5.898,3.250 5.177,3.548 4.645,4.080 C4.113,4.611 3.814,5.332 3.814,6.083 L3.814,14.583 L9.488,14.583 L9.488,6.083 ZM29.348,6.083 C29.348,5.332 29.050,4.611 28.517,4.080 C27.985,3.548 27.263,3.250 26.511,3.250 L11.559,3.250 C12.059,4.111 12.324,5.088 12.325,6.083 L12.325,27.092 L14.950,24.840 C15.207,24.620 15.534,24.500 15.872,24.500 C16.210,24.500 16.537,24.620 16.794,24.840 L20.837,28.296 L24.880,24.840 C25.137,24.620 25.463,24.500 25.802,24.500 C26.140,24.500 26.467,24.620 26.724,24.840 L29.348,27.092 L29.348,6.083 ZM25.092,20.250 L16.581,20.250 C16.205,20.250 15.844,20.101 15.578,19.835 C15.312,19.569 15.162,19.209 15.162,18.833 C15.162,18.457 15.312,18.097 15.578,17.831 C15.844,17.566 16.205,17.416 16.581,17.416 L25.092,17.416 C25.469,17.416 25.829,17.566 26.096,17.831 C26.362,18.097 26.511,18.457 26.511,18.833 C26.511,19.209 26.362,19.569 26.096,19.835 C25.829,20.101 25.469,20.250 25.092,20.250 ZM25.092,14.583 L16.581,14.583 C16.205,14.583 15.844,14.434 15.578,14.168 C15.312,13.903 15.162,13.542 15.162,13.167 C15.162,12.791 15.312,12.430 15.578,12.165 C15.844,11.899 16.205,11.750 16.581,11.750 L25.092,11.750 C25.469,11.750 25.829,11.899 26.096,12.165 C26.362,12.430 26.511,12.791 26.511,13.167 C26.511,13.542 26.362,13.903 26.096,14.168 C25.829,14.434 25.469,14.583 25.092,14.583 ZM25.092,8.916 L16.581,8.916 C16.205,8.916 15.844,8.767 15.578,8.501 C15.312,8.236 15.162,7.875 15.162,7.500 C15.162,7.124 15.312,6.764 15.578,6.498 C15.844,6.232 16.205,6.083 16.581,6.083 L25.092,6.083 C25.469,6.083 25.829,6.232 26.096,6.498 C26.362,6.764 26.511,7.124 26.511,7.500 C26.511,7.875 26.362,8.236 26.096,8.501 C25.829,8.767 25.469,8.916 25.092,8.916 Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-white invoice-num"><?= $usuarioMasLikes ?></h2>
                    <span class="text-white fs-18">Usuario con más likes</span>
                </div>
            </div>
        </div>
    </div>

    <!-- País con menos likes -->
    <div class="col-xl-3 col-xxl-3 col-sm-6">
        <div class="card bg-secondary invoice-card">
            <div class="card-body d-flex">
                <div class="icon me-3">
                <svg width="35px" height="34px">
                        <path fill-rule="evenodd" fill="rgb(255, 255, 255)" d="M33.002,9.728 C31.612,6.787 29.411,4.316 26.638,2.583 C22.781,0.179 18.219,-0.584 13.784,0.438 C9.356,1.454 5.585,4.137 3.178,7.989 C0.764,11.840 -0.000,16.396 1.023,20.825 C2.048,25.247 4.734,29.013 8.584,31.417 C11.297,33.110 14.409,34.006 17.594,34.006 L17.800,34.006 C20.973,33.967 24.058,33.050 26.731,31.363 C27.509,30.872 27.735,29.849 27.243,29.072 C26.751,28.296 25.727,28.070 24.949,28.561 C22.801,29.922 20.314,30.660 17.761,30.693 C15.141,30.726 12.581,30.002 10.346,28.614 C7.241,26.675 5.080,23.647 4.262,20.088 C3.444,16.515 4.056,12.850 5.997,9.748 C10.001,3.353 18.473,1.401 24.876,5.399 C27.110,6.793 28.879,8.779 29.996,11.143 C31.087,13.447 31.513,16.004 31.227,18.527 C31.126,19.437 31.778,20.260 32.696,20.360 C33.607,20.459 34.432,19.809 34.531,18.892 C34.884,15.765 34.352,12.591 33.002,9.728 L33.002,9.728 Z" />
                        <path fill-rule="evenodd" fill="rgb(255, 255, 255)" d="M23.380,11.236 C22.728,10.585 21.678,10.585 21.026,11.236 L17.608,14.656 L14.190,11.243 C13.539,10.592 12.488,10.592 11.836,11.243 C11.184,11.893 11.184,12.942 11.836,13.593 L15.254,17.006 L11.836,20.420 C11.184,21.071 11.184,22.120 11.836,22.770 C12.162,23.096 12.588,23.255 13.014,23.255 C13.438,23.255 13.864,23.096 14.190,22.770 L17.608,19.357 L21.026,22.770 C21.352,23.096 21.777,23.255 22.203,23.255 C22.629,23.255 23.054,23.096 23.380,22.770 C24.031,22.120 24.031,21.071 23.380,20.420 L19.962,17.000 L23.380,13.587 C24.031,12.936 24.031,11.887 23.380,11.236 L23.380,11.236 Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-white invoice-num"><?= $paisConMenosLikes ?></h2>
                    <span class="text-white fs-18">País con menos likes</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Top 5 países -->
    <div class="col-xl-3 col-xxl-5">
        <div class="card">
            <h4 class="card-title mb-2 top">Top 5 Países con más Likes</h4>
            <div class="card-body">
                <?php foreach ($topPaises as $index => $pais):
                    $porcentaje = ($pais['total_likes'] / $maxLikesPais) * 100;
                ?>
                    <div class="progress default-progress mt-4">
                        <div class="progress-bar bg-gradient-<?= ($index + 1) ?> progress-animated" style="width:<?= $porcentaje ?>%; height:20px;">
                            <span class="text-white px-2"><?= $pais['total_likes'] ?> likes</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-end mt-2 pb-3 justify-content-between">
                        <span><?= $pais['pais'] ?></span>
                        <span><?= round($porcentaje, 2) ?>%</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Likes por día -->
    <div class="col-xl-6 col-xxl-7">
        <div class="card">
            <div class="card-header d-flex justify-content-center border-0 pb-2">
                <h4 class="card-title mb-0 text-center">Likes por día</h4>
            </div>
            <div class="card-body d-flex justify-content-center align-items-end" >
                <div class="d-flex justify-content-between align-items-end" style="width:80%;height:100%;gap:15px;">
                    <?php
                    $gradientes = [
                        "linear-gradient(180deg, #9b59b6, #e84393)",
                        "linear-gradient(180deg, #8e44ad, #fd79a8)",
                        "linear-gradient(180deg, #a29bfe, #d63031)",
                        "linear-gradient(180deg, #6c5ce7, #e84393)",
                        "linear-gradient(180deg, #be2edd, #ff6b81)",
                        "linear-gradient(180deg, #9c88ff, #ff7979)",
                        "linear-gradient(180deg, #6c5ce7, #fd79a8)",
                    ];
                    $i = 0;
                    foreach ($diasSemana as $dia => $cantidad):
                        $alturaVh = ($cantidad / $maxLikesDia) * $alturaMax;
                        $color = $gradientes[$i % count($gradientes)];
                    ?>
                        <div class="text-center d-flex flex-column justify-content-end" style="flex:1;">
                            <div style="background:<?= $color ?>; width:100%; min-height:5px; height:<?= $alturaVh ?>px; border-radius:10px; transition: height 0.3s;"></div>
                            <span class="d-block mt-2 fw-bold text-black"><?= $dia ?></span>
                            <span class="d-block fs-12 text-black"><?= $cantidad ?></span>
                        </div>
                    <?php $i++;
                    endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimas publicaciones -->
    <div class="col-xl-3 col-xxl-3">
        <div class="card">
            <div class="card-header d-flex justify-content-center border-0 pb-2">
                <h4 class="card-title mb-0 text-center">Últimas Publicaciones con likes</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($ultimasPublicaciones)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($ultimasPublicaciones as $titulo): ?>
                            <li class="list-group-item"><?= $titulo ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-center">No hay publicaciones</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>