<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    // Redireciona para login se não estiver autenticado
    header('Location: login.html');
    exit;
}

// Se precisar buscar dados adicionais do usuário (incluindo a foto)
require_once('php/bd.class.php');
$objBD = new bd();
$conexao = $objBD->conecta_mysql();

$stmt = $conexao->prepare("SELECT foto_perfil FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$resultado = $stmt->get_result();

if ($usuario = $resultado->fetch_assoc()) {
    $_SESSION['foto_perfil'] = $usuario['foto_perfil'] 
        ? 'uploads/profiles/' . $usuario['foto_perfil'] 
        : 'img/perfil.png';
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STREAMORA</title>
    <link rel="stylesheet" href="swiper-bundle.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="icon/css/boxicons.min.css">
    <link rel="stylesheet" href="lz/Font-Awesome/css/all.min.css">

</head>
<body>
    <!-- Navbar  -->
    <header>
        <a href="#home" class="logo">
            <div class="logo-icon">
                    <img src="img/logo3.png" alt="">
                </div>
            </i>STREAMORA
        </a>
        <div class="bx bx-menu" id="menu-icon"></div>

        <!-- menu  -->
        <ul class="navbar">
            <li><a href="#home" class="home-active">Página Inicial</a></li>
            <li><a href="#movies">Filmes</a></li>
            <li><a href="series0.php">Series</a></li>
            <li><a href="#coming">Em breve</a></li>
            <li><a href="#newsletter">Sobre</a></li>
        </ul>
        <div class="user-profile-wrapper">
    <div class="user-profile">
        <div class="profile-info">
            <img src="php/<?php echo $_SESSION['foto_perfil'] ?? 'img/perfil.png'; ?>" 
     alt="Perfil" 
     class="profile-pic">
            <span class="profile-name">Bem-vinda, Sofia</span>
            <i class="fas fa-chevron-down dropdown-arrow"></i>
        </div>
        
        <div class="profile-dropdown">
            <div class="dropdown-header">
                 <img src="php/<?= $_SESSION['foto_perfil'] ?? 'img/perfil.png' ?>" alt="Perfil" class="dropdown-pic">
                <div>
                    <h4>Sofia Oliveira</h4>
                    <span>Plano Premium</span>
                </div>
            </div>
            
            <ul class="dropdown-menu">
                <li>
                    <a href="#">
                        <i class="fas fa-user"></i>
                        Minha Conta
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-heart"></i>
                        Favoritos
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-cog"></i>
                        Configurações
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <i class="fas fa-question-circle"></i>
                        Ajuda
                    </a>
                </li>
                <li>
                    <a href="#" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Terminar Sessão
                    </a>
                </li>
            </ul>
        </div>
    </div>
        </div>
    </header>

    <!-- Home  -->
    <section class="home swiper" id="home">
        <div class="swiper-wrapper">
            <div class="swiper-slide container">
                <img src="./img/home1.jpg" alt="">
                <div class="home-text">
                    <span>Universo Marvel</span>
                    <h1>Guardiões da Galáxia <br>Volume 2</h1>
                    <a href="" class="btn" style="display: none;">Reserve Agora</a>
                    <a href="" class="play" style="display: none;">
                        <i class='bx bx-play' ></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide container">
                <img src="./img/home2.png" alt="">
                <div class="home-text">
                    <span>Universo Marvel</span>
                    <h1>Thor: <br>Amor e Trovão</h1>
                    <a href="" class="btn"style="display: none;">Reserve Agora</a>
                    <a href="" class="play" style="display: none;">
                        <i class='bx bx-play' ></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide container">
                <img src="./img/home3.jpg" alt="">
                <div class="home-text">
                    <span>Universo Marvel</span>
                    <h1>Spider-Man <br>Sem Volta Para casa</h1>
                    <a href="" class="btn" style="display: none;">Reserve Agora</a>
                    <a href="" class="play" style="display: none;">
                        <i class='bx bx-play' ></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide container">
                <img src="./img/home4.png" alt="">
                <div class="home-text">
                    <span>Universo Marvel</span>
                    <h1>Avengers: <br>End Game</h1>
                    <a href="" class="btn" style="display: none;">Reserve Agora</a>
                    <a href="" class="play" style="display: none;">
                        <i class='bx bx-play' ></i>
                    </a>
                </div>
            </div>
            
          </div>
          <div class="swiper-pagination"></div>
    </section>

    <!-- Movies  -->
    <div class="movies" id="movies">
        <h2 class="heading">Estreia esta semana</h2>
        <!-- Movies container  -->
        <div class="movies-container">
            <!-- box-1  -->
            <div class="box">
                <div class="box-img">
                    <img src="./img/m1.jpg" alt="">
                </div>
                <h3>Dr. Estranho</h3>
                <span>120 min | Ação</span>
            </div>
            <!-- box-2  -->
            <div class="box">
                <div class="box-img">
                    <img src="./img/m2.jpg" alt="">
                </div>
                <h3>Pathan</h3>
                <span>120 min | Ação</span>
            </div>
            <!-- box-3  -->
            <div class="box">
                <div class="box-img">
                    <img src="./img/m3.jpg" alt="">
                </div>
                <h3>Batman vs Superman</h3>
                <span>120 min | Suspense</span>
            </div>
            <!-- box-4  -->
            <div class="box">
                <div class="box-img">
                    <img src="./img/m4.jpg" alt="">
                </div>
                <h3>John Wick 2</h3>
                <span>120 min | Ação</span>
            </div>
            <!-- box-5  -->
            <div class="box">
                <div class="box-img">
                    <img src="./img/m5.jpg" alt="">
                </div>
                <h3>Aquaman</h3>
                <span>120 min | Aventura</span>
            </div>
            <!-- box-6  -->
            <div class="box">
                <div class="box-img">
                    <img src="./img/m6.jpg" alt="">
                </div>
                <h3>Black Panther</h3>
                <span>120 min | Suspense</span>
            </div>
            <!-- box-7  -->
            <div class="box">
                <div class="box-img">
                    <img src="./img/m7.jpg" alt="">
                </div>
                <h3>Desconhecido</h3>
                <span>120 min | Aventura</span>
            </div>
            <!-- box-8  -->
            <div class="box">
                <div class="box-img">
                    <img src="./img/m8.jpg" alt="">
                </div>
                <h3>Brahmastra</h3>
                <span>120 min | Ação</span>
            </div>
            <!-- box-9  -->
            <div class="box">
                <div class="box-img">
                    <img src="./img/m9.jpg" alt="">
                </div>
                <h3>Motores Mortais</h3>
                <span>120 min | Ação</span>
            </div>
            <!-- box-10  -->
            <div class="box">
                <div class="box-img">
                    <img src="./img/m10.jpg" alt="">
                </div>
                <h3>Guerras Sangrentas do Submundo</h3>
                <span>120 min | Ação</span>
            </div>
        </div>
    </div>

    <!-- coming  -->
    <section class="coming" id="coming">
        <h2 class="heading">Em breve</h2>
        <!-- coming contanier  -->
        <div class="coming-container swiper">
            <div class="swiper-wrapper">
                <!-- box-1  -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="./img/c1.jpg" alt="">
                    </div>
                    <h3>Ant-Man and the Wasp:Quantumania</h3>
                </div>
                <!-- box-2  -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="./img/c2.jpg" alt="">
                    </div>
                    <h3>The Flash</h3>
                </div>
                <!-- box-3  -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="./img/c3.jpg" alt="">
                    </div>
                    <h3>Guardians of the Galaxy Vol.3</h3>
                </div>
                <!-- box-4  -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="./img/c4.jpg" alt="">
                    </div>
                    <h3>Shazam! Fury of the Gods</h3>
                </div>
                <!-- box-5  -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="./img/c5.jpg" alt="">
                    </div>
                    <h3>Aquaman and the Lost Kingdom</h3>
                </div>
                <!-- box-6  -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="./img/c6.jpg" alt="">
                    </div>
                    <h3>John Wick:Chapter 4</h3>
                </div>
                <!-- box-7 -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="./img/c7.jpg" alt="">
                    </div>
                    <h3>Transformer rise of the beasts</h3>
                </div>
                <!-- box-8  -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="./img/c8.jpg" alt="">
                    </div>
                    <h3>Mission: Impossible 7</h3>
                </div>
                <!-- box-9  -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="./img/c9.png" alt="">
                    </div>
                    <h3>Deadpool 3</h3>
                </div>
                <!-- box-10  -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="./img/c10.jpg" alt="">
                    </div>
                    <h3>Dune: Part two</h3>
                </div>
            </div>
        </div>
    </section>

    <section class="cineflux-movie-gallery">
    <div class="cineflux-gallery-header">
        <h2>Catálogo Completo</h2>
        <div class="cineflux-search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Pesquisar filmes..." id="cineflux-search-input">
        </div>
        <div class="cineflux-sort-options">
            <button class="cineflux-sort-btn active" data-sort="title">A-Z</button>
            <button class="cineflux-sort-btn" data-sort="year">Ano</button>
            <button class="cineflux-sort-btn" data-sort="rating">Avaliação</button>
        </div>
    </div>
    
    <!-- Filtros por Gênero -->
    <div class="cineflux-genre-tabs">
        <div class="cineflux-genre-tab active" data-genre="all">
            <i class="fas fa-film"></i>Todos
        </div>
        <div class="cineflux-genre-tab" data-genre="action">
            <i class="fas fa-explosion"></i>Ação
        </div>
        <div class="cineflux-genre-tab" data-genre="adventure">
            <i class="fas fa-mountain-sun"></i>Aventura
        </div>
        <div class="cineflux-genre-tab" data-genre="comedy">
            <i class="fas fa-face-laugh-squint"></i>Comédia
        </div>
        <div class="cineflux-genre-tab" data-genre="drama">
            <i class="fas fa-masks-theater"></i>Drama
        </div>
        <div class="cineflux-genre-tab" data-genre="scifi">
            <i class="fas fa-robot"></i>Ficção Científica
        </div>
        <div class="cineflux-genre-tab" data-genre="horror">
            <i class="fas fa-ghost"></i>Terror
        </div>
        <div class="cineflux-genre-tab" data-genre="romance">
            <i class="fas fa-heart"></i>Romance
        </div>
        <div class="cineflux-genre-tab" data-genre="fantasy">
            <i class="fas fa-dragon"></i>Fantasia
        </div>
        <div class="cineflux-genre-tab" data-genre="animation">
            <i class="fas fa-film"></i>Animação
        </div>
        <div class="cineflux-genre-tab" data-genre="thriller">
            <i class="fas fa-knife-kitchen"></i>Suspense
        </div>
    </div>
    
    <!-- Índice Alfabético -->
    <div class="cineflux-alpha-nav">
        <div class="cineflux-alpha-letter">A</div>
        <div class="cineflux-alpha-letter">B</div>
        <div class="cineflux-alpha-letter">C</div>
        <div class="cineflux-alpha-letter">D</div>
        <div class="cineflux-alpha-letter">E</div>
        <div class="cineflux-alpha-letter">F</div>
        <div class="cineflux-alpha-letter">G</div>
        <div class="cineflux-alpha-letter">H</div>
        <div class="cineflux-alpha-letter">I</div>
        <div class="cineflux-alpha-letter">J</div>
        <div class="cineflux-alpha-letter">K</div>
        <div class="cineflux-alpha-letter">L</div>
        <div class="cineflux-alpha-letter">M</div>
        <div class="cineflux-alpha-letter">N</div>
        <div class="cineflux-alpha-letter">O</div>
        <div class="cineflux-alpha-letter">P</div>
        <div class="cineflux-alpha-letter">Q</div>
        <div class="cineflux-alpha-letter">R</div>
        <div class="cineflux-alpha-letter">S</div>
        <div class="cineflux-alpha-letter">T</div>
        <div class="cineflux-alpha-letter">U</div>
        <div class="cineflux-alpha-letter">V</div>
        <div class="cineflux-alpha-letter">W</div>
        <div class="cineflux-alpha-letter">X</div>
        <div class="cineflux-alpha-letter">Y</div>
        <div class="cineflux-alpha-letter">Z</div>
    </div>
    
    <!-- Grid de Filmes -->
    <div class="cineflux-movie-grid" id="cineflux-movie-grid">
        <!-- Os filmes serão inseridos aqui via JavaScript -->
    </div>
</section>

<style>
    /* Estilos para a seção de catálogo */
    .cineflux-movie-gallery {
        padding: 60px 5%;
    }
    
    .cineflux-gallery-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .cineflux-search-box {
        position: relative;
        width: 100%;
        max-width: 400px;
    }
    
    .cineflux-search-box input {
        width: 100%;
        padding: 12px 20px;
        padding-left: 45px;
        border-radius: 30px;
        border: none;
        background: #2A2A3E;
        color: white;
        font-size: 1rem;
    }
    
    .cineflux-search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-color);
    }
    
    .cineflux-sort-options {
        display: flex;
        gap: 10px;
    }
    
    .cineflux-sort-btn {
        padding: 8px 15px;
        background: #2A2A3E;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 0.9rem;
        border: none;
        color: white;
    }
    
    .cineflux-sort-btn.active {
        background: var(--primary-color);
        color: white;
    }
    
    .cineflux-genre-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
        justify-content: center;
    }
    
    .cineflux-genre-tab {
        padding: 10px 20px;
        background: #2A2A3E;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .cineflux-genre-tab:hover, .cineflux-genre-tab.active {
        background: var(--primary-color);
        transform: translateY(-3px);
    }
    
    .cineflux-genre-tab i {
        font-size: 1rem;
    }
    
    .cineflux-movie-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 20px;
    }
    
    @media (min-width: 768px) {
        .cineflux-movie-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        }
    }
    
    @media (min-width: 1024px) {
        .cineflux-movie-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }
    }
    
    .cineflux-movie-card {
        background: #2A2A3E;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        cursor: pointer;
    }
    
    .cineflux-movie-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(157, 78, 221, 0.3);
    }
    
    .cineflux-movie-cover {
        width: 100%;
        height: 0;
        padding-bottom: 150%;
        position: relative;
        overflow: hidden;
    }
    
    .cineflux-movie-cover img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .cineflux-movie-card:hover .cineflux-movie-cover img {
        transform: scale(1.1);
    }
    
    .cineflux-movie-info {
        padding: 15px;
    }
    
    .cineflux-movie-name {
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .cineflux-movie-year {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
    
    .cineflux-movie-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 8px;
    }
    
    .cineflux-movie-tag {
        font-size: 0.7rem;
        background: rgba(157, 78, 221, 0.2);
        padding: 3px 8px;
        border-radius: 10px;
        color: var(--primary-color);
    }
    
    .cineflux-alpha-nav {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 5px;
        margin: 30px 0;
    }
    
    .cineflux-alpha-letter {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #2A2A3E;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .cineflux-alpha-letter:hover, .cineflux-alpha-letter.active {
        background: var(--primary-color);
    }
    
    .cineflux-no-results {
        text-align: center;
        grid-column: 1 / -1;
        padding: 40px 0;
        color: var(--text-secondary);
    }
</style>

<script>
    // Dados dos filmes (exemplo)
    const cinefluxMovies = [
        {
            title: "A Origem",
            year: 2010,
            rating: 8.8,
            genres: ["scifi", "thriller"],
            image: "img/fts/1.jpg",
            description: "Um ladrão que rouba segredos corporativos através do uso da tecnologia de compartilhamento de sonhos."
           
        },
        {
            title: "Batman: O Cavaleiro das Trevas",
            year: 2008,
            rating: 9.0,
            genres: ["action", "drama", "thriller"],
            image: "img/fts/2.jpg",
            description: "Quando o Coringa causa destruição e caos, Batman deve aceitar um dos maiores testes psicológicos."
        },
        {
            title: "Duna",
            year: 2021,
            rating: 8.0,
            genres: ["scifi", "adventure"],
            image: "img/fts/3.jpeg",
            description: "O filme segue Paul Atreides, um jovem brilhante com um grande destino além de sua compreensão."
        },
        {
            title: "Forrest Gump",
            year: 1994,
            rating: 8.8,
            genres: ["drama", "romance"],
            image: "img/fts/4.jpg",
            description: "As presidências de Kennedy e Johnson, os eventos do Vietnã, Watergate e outros desenvolvimentos históricos."
        },
        {
            title: "Interestelar",
            year: 2014,
            rating: 8.6,
            genres: ["scifi", "adventure", "drama"],
            image: "img/fts/5.jpg",
            description: "Uma equipe de exploradores viaja através de um buraco de minhoca no espaço na tentativa de garantir a sobrevivência da humanidade."
        },
        {
            title: "O Poderoso Chefão",
            year: 1972,
            rating: 9.2,
            genres: ["drama", "thriller"],
            image: "img/fts/6.jpg",
            description: "O patriarca idoso de uma dinastia do crime organizado transfere o controle de seu império clandestino para seu filho relutante."
        },
        {
            title: "O Senhor dos Anéis",
            year: 2001,
            rating: 8.8,
            genres: ["adventure", "fantasy"],
            image: "img/fts/7.jpg",
            description: "Um humilde hobbit da Terra-média e seus amigos partem em uma jornada para destruir o poderoso Um Anel."
        },
        {
            title: "Pulp Fiction",
            year: 1994,
            rating: 8.9,
            genres: ["drama", "thriller"],
            image: "img/fts/8.jpg",
            description: "As vidas de dois assassinos da máfia, um boxeador, um gângster e sua esposa, e um par de bandidos se entrelaçam em quatro histórias de violência e redenção."
        },
        {
            title: "Um Sonho de Liberdade",
            year: 1994,
            rating: 9.3,
            genres: ["drama"],
            image: "img/fts/9.jpg",
            description: "Dois homens presos criam um vínculo ao longo de vários anos, encontrando consolo e eventual redenção através de atos de decência comum."
        },
        {
            title: "Clube da Luta",
            year: 1999,
            rating: 8.8,
            genres: ["drama", "thriller"],
            image: "img/fts/10.jpg",
            description: "Um homem deprimido que sofre de insônia conhece um vendedor de sabão excêntrico e juntos formam um clube de luta clandestino que evolui para algo muito maior."
        }
    ];

    // Função para renderizar os filmes
    function renderCinefluxMovies(filteredMovies = cinefluxMovies) {
        const grid = document.getElementById('cineflux-movie-grid');
        grid.innerHTML = '';
        
        if (filteredMovies.length === 0) {
            grid.innerHTML = '<div class="cineflux-no-results">Nenhum filme encontrado. Tente alterar seus filtros.</div>';
            return;
        }
        
        filteredMovies.forEach(movie => {
            const movieCard = document.createElement('div');
            movieCard.className = 'cineflux-movie-card';
            
            movieCard.innerHTML = `
                <div class="cineflux-movie-cover">
                 <a href=""><img src="${movie.image}" alt="${movie.title}"></a>
                    
                </div>
                <div class="cineflux-movie-info">
                    <div class="cineflux-movie-name">${movie.title}</div>
                    <div class="cineflux-movie-year">${movie.year}</div>
                    <div class="cineflux-movie-tags">
                        ${movie.genres.map(genre => `<span class="cineflux-movie-tag">${getCinefluxGenreName(genre)}</span>`).join('')}
                    </div>
                </div>
            `;
            
            grid.appendChild(movieCard);
        });
    }

    // Mapear códigos de gênero para nomes
    function getCinefluxGenreName(code) {
        const genres = {
            'action': 'Ação',
            'adventure': 'Aventura',
            'comedy': 'Comédia',
            'drama': 'Drama',
            'scifi': 'Ficção Científica',
            'horror': 'Terror',
            'romance': 'Romance',
            'fantasy': 'Fantasia',
            'animation': 'Animação',
            'thriller': 'Suspense'
        };
        return genres[code] || code;
    }

    // Filtros e ordenação
    let currentCinefluxGenre = 'all';
    let currentCinefluxSort = 'title';
    let currentCinefluxSearch = '';

    function filterAndSortCinefluxMovies() {
        let filtered = [...cinefluxMovies];
        
        // Filtrar por gênero
        if (currentCinefluxGenre !== 'all') {
            filtered = filtered.filter(movie => movie.genres.includes(currentCinefluxGenre));
        }
        
        // Filtrar por pesquisa
        if (currentCinefluxSearch) {
            const searchTerm = currentCinefluxSearch.toLowerCase();
            filtered = filtered.filter(movie => 
                movie.title.toLowerCase().includes(searchTerm)
            );
        }
        
        // Ordenar
        filtered.sort((a, b) => {
            if (currentCinefluxSort === 'title') {
                return a.title.localeCompare(b.title);
            } else if (currentCinefluxSort === 'year') {
                return b.year - a.year;
            } else if (currentCinefluxSort === 'rating') {
                return b.rating - a.rating;
            }
            return 0;
        });
        
        renderCinefluxMovies(filtered);
    }

    // Event Listeners
    document.querySelectorAll('.cineflux-genre-tab').forEach(filter => {
        filter.addEventListener('click', () => {
            document.querySelectorAll('.cineflux-genre-tab').forEach(f => f.classList.remove('active'));
            filter.classList.add('active');
            currentCinefluxGenre = filter.dataset.genre;
            filterAndSortCinefluxMovies();
        });
    });

    document.querySelectorAll('.cineflux-sort-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.cineflux-sort-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentCinefluxSort = btn.dataset.sort;
            filterAndSortCinefluxMovies();
        });
    });

    document.getElementById('cineflux-search-input').addEventListener('input', (e) => {
        currentCinefluxSearch = e.target.value;
        filterAndSortCinefluxMovies();
    });

    // Índice alfabético
    document.querySelectorAll('.cineflux-alpha-letter').forEach(letter => {
        letter.addEventListener('click', () => {
            const selectedLetter = letter.textContent;
            currentCinefluxSearch = selectedLetter;
            document.getElementById('cineflux-search-input').value = selectedLetter;
            filterAndSortCinefluxMovies();
        });
    });

    // Inicializar
    renderCinefluxMovies();
</script>

    <!-- Newsletter /\ -->
    <section class="newsletter" id="newsletter" style="display: none;">
        <h2>Seja um membro contribuidor <br>contribuidor</h2>
        <form Ação="">
            <input type="email" class="email" placeholder="Enter Email" required>
            <input type="submit" value="Subscribe" class="btn">
        </form>
    </section>

    <!-- footer  -->
    <section class="footer">
        <a href="" class="logo">
            <i class="bx bxs-movie"></i>STREAMORA
        </a>
        <div class="social">
            <a href=""><i class='bx bxl-facebook'></i></a>
            <a href=""><i class='bx bxl-twitter'></i></a>
            <a href=""><i class='bx bxl-instagram'></i></a>
        </div>
    </section>

    <!-- Copyright  -->
    <div class="copyright">
        <p>&#169; STREAMORA Todos os direitos reservados</p>
    </div>

<!-- Modal Glamour -->
<div id="movieModal" class="modal-glamour">
    <div class="modal-glamour-content">
        <span class="close-modal">&times;</span>
        
        <div class="movie-header">
            <div class="video-container">
                <iframe id="trailerVideo" width="560" height="315" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                <div class="play-pause-overlay">
                    <button class="play-btn">▶</button>
                </div>
            </div>
            
            <div class="movie-meta">
                <h2 id="movieTitle">Título do Filme</h2>
                <div class="movie-details">
                    <span class="duration">120 min</span>
                    <span class="genre">Romance</span>
                    <div class="rating">
                        <span class="stars">★★★★☆</span>
                        <span>4.0/5</span>
                    </div>
                </div>
                
                <div class="action-buttons" style="display: none;">
                    <button class="watch-now-btn">
                        <i class="fas fa-play" ></i> Assistir Agora
                    </button>
                    <button class="favorite-btn">
                        <i class="fas fa-heart"></i> Favorito
                    </button>
                </div>
            </div>
        </div>
        
        <div class="movie-synopsis">
            <h3>Sinopse</h3>
            <p id="movieDescription">Descrição emocionante do filme aparecerá aqui...</p>
        </div>
        
        <div class="movie-extras" style="display: none;">
            <div class="cast">
                <h3>Elenco Principal</h3>
                <div class="cast-scroll">
                    <div class="actor">
                        <div class="actor-img" style="background-image: url('https://via.placeholder.com/80');"></div>
                        <span>Atriz Principal</span>
                    </div>
                    <!-- Mais atores... -->
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="swiper-bundle.min.js"></script>
    <script src="main.js"></script>
    <script src="index.js"></script>

    <script>

/**
 * Atualiza a interface com os dados do usuário logado
 * @param {Object} user - Objeto com dados do usuário
 */
function updateUserProfile(user) {
    // Verifica se os elementos existem antes de atualizar
    const profilePic = document.querySelector('.profile-pic');
    const profileName = document.querySelector('.profile-name');
    const dropdownPic = document.querySelector('.dropdown-pic');
    const dropdownName = document.querySelector('.dropdown-header h4');
    
    if (profilePic) {
        profilePic.style.display = 'block';
    }
    
    if (profileName) {
        profileName.textContent = `Olá, ${user.name.split(' ')[0]}`;
    }
    
    if (dropdownPic) {
    }
    
    if (dropdownName) {
        dropdownName.textContent = user.name;
    }
    
    // Armazena os dados do usuário para uso posterior
    sessionStorage.setItem('currentUser', JSON.stringify(user));
}

// Verifica a sessão ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    checkSession();
    
    // Configura o logout
    document.querySelector('.logout-btn')?.addEventListener('click', function(e) {
        e.preventDefault();
        logoutUser();
    });
});

// Função para verificar a sessão

async function checkSession() {
    try {
        const response = await fetch('php/check_session.php', {
            credentials: 'include',
            headers: {
                'Cache-Control': 'no-cache'
            }
        });
        
        if (!response.ok) {
            console.error('Erro na resposta do servidor:', response.status);
            return; // Não redireciona imediatamente em caso de erro
        }
        
        const data = await response.json();
        
        if (data.authenticated && data.user) {
            updateUserProfile(data.user);
            
            // Se estiver na página de login, redireciona para a home
            if (window.location.pathname.includes('login.html')) {
                window.location.href = data.user.isAdmin ? 'adminPage.html' : 'index.html';
            }
        } else {
            // Adiciona um log antes de redirecionar
            console.log('Usuário não autenticado. Redirecionando...');
            
            // Redireciona apenas se não estiver na página de login
            if (!window.location.pathname.includes('login.html')) {
                // Adiciona um pequeno atraso para visualização
                setTimeout(() => {
                    window.location.href = 'login.html';
                }, 500);
            }
        }
    } catch (error) {
        console.error('Erro ao verificar sessão:', error);
        // Não redireciona automaticamente em caso de erro
    }
}

// Função para logout
async function logoutUser() {
    try {
        const response = await fetch('php/logout.php');
        const data = await response.json();
        
        if (data.success) {
            window.location.href = 'login.html';
        }
    } catch (error) {
        console.error('Erro ao fazer logout:', error);
    }
}

</script>

</body>
</html>