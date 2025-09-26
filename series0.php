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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streamora | Streaming Feminino</title>
    <style>
        :root {
            --primary: #ff4d8d;
            --secondary: #ff85a2;
            --dark: #1a1a2e;
            --light: #f8f8f8;
            --accent: #a64dff;
        }
        
*{
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    text-decoration: none;
    list-style: none;
    scroll-padding-top: 2rem;
    scroll-behavior: smooth;
}
        
        body {
            background-color: var(--dark);
            color: var(--light);
        }
        
 
/* User Profile Styles */
.user-profile-wrapper {
    position: relative;
    z-index: 1000;
}

.user-profile {
    display: flex;
    align-items: center;
    cursor: pointer;
    position: relative;
    padding: 8px 12px;
    border-radius: 30px;
    transition: all 0.3s ease;
}

.user-profile:hover {
    background: rgba(255, 182, 193, 0.2);
}

.profile-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.profile-pic {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ffb6c1;
}

.profile-name {
    font-weight: 500;
    color: #fff;
    font-size: 15px;
}

.dropdown-arrow {
    color: #ffb6c1;
    font-size: 12px;
    transition: transform 0.3s;
}

/* Dropdown Menu */
.profile-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    width: 280px;
    background: linear-gradient(145deg, #1e1e3a, #2a2a4a);
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    padding: 15px 0;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.3s ease;
    z-index: 1000;
    border: 1px solid rgba(255, 182, 193, 0.2);
}

.user-profile.active .profile-dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.user-profile.active .dropdown-arrow {
    transform: rotate(180deg);
}

.dropdown-header {
    display: flex;
    align-items: center;
    padding: 0 20px 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 10px;
}

.dropdown-pic {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ffb6c1;
    margin-right: 15px;
}

.dropdown-header h4 {
    color: #fff;
    margin: 0 0 5px;
    font-size: 16px;
}

.dropdown-header span {
    color: #ffb6c1;
    font-size: 12px;
    display: block;
}

.dropdown-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.dropdown-menu li a {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    color: #e0e0e0;
    text-decoration: none;
    transition: all 0.2s;
    font-size: 14px;
}

.dropdown-menu li a:hover {
    background: rgba(255, 182, 193, 0.1);
    color: #ffb6c1;
    padding-left: 25px;
}

.dropdown-menu li a i {
    margin-right: 12px;
    width: 20px;
    text-align: center;
    color: #ffb6c1;
}

.dropdown-menu .divider {
    height: 1px;
    background: rgba(255, 255, 255, 0.1);
    margin: 8px 0;
}

.logout-btn {
    color: #ff6b6b !important;
}

.logout-btn i {
    color: #ff6b6b !important;
}
        
       header{
    position: fixed;
    width: 100%;
    top: 0;
    right: 0;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 100px;
    transition: 0.5s;
    /* background: var(--main-color); */
}
header.shadow{
    background: rgb(177 46 187 / 35%);
    box-shadow: 0 0 4px rgb(14 55 54/15%);
}
header.shadow .navbar a{
   
}
header.shadow .logo{
    
}


.logo{
    font-size: 1.5rem;
    font-weight: 800;
    align-items: center;
    color: #ff4d8d;
    display: flex;
    column-gap: 0.5rem;
        font-family: math;
}
.bx{
    color: var(--main-color);
}
.navbar{
    display: flex;
    column-gap: 5rem;
}
.navbar li{
    position: relative;
}
.navbar a{
    font-size: 1rem;
    font-weight: 500;
    color: var(--bg-color);
}
.navbar a::after{
    content: '';
    width: 0;
    height: 2px;
    background: var(--main-color);
    position: absolute;
    bottom: -4px;
    left: 0;
    transition: 0.4s all linear;
}
.navbar a:hover::after,
.navbar .home-active::after{
    width: 100%;
}
#menu-icon{
    font-size: 24px;
    cursor: pointer;
    z-index: 1000001;
    display: none;
}
.btn{
    padding: 0.7rem 1.4rem;
    background: var(--main-color);
    color: var(--bg-color);
    font-weight: 400;
    border-radius: 0.5rem;
}
.btn:hover{
    background: #fa1216;
}

       
        .hero {
            padding: 150px 5% 50px;
            text-align: center;
            background: linear-gradient(135deg, var(--dark), #16213e);
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 40px;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .category {
            margin: 50px 5%;
        }
        
        .category-title {
            font-size: 1.8rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .category-title::before {
            content: '';
            display: inline-block;
            width: 10px;
            height: 30px;
            background: var(--primary);
            margin-right: 15px;
            border-radius: 5px;
        }
        
        .carousel {
            position: relative;
            overflow: hidden;
        }
        
        .carousel-container {
            display: flex;
            gap: 20px;
            padding: 10px 0;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scrollbar-width: none;
        }
        
        .carousel-container::-webkit-scrollbar {
            display: none;
        }
        
        .series-card {
            min-width: 250px;
            scroll-snap-align: start;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            transition: transform 0.3s;
            cursor: pointer;
        }
        
        .series-card:hover {
            transform: scale(1.05);
        }
        
        .series-card img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            display: block;
        }
        
        .series-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
        }
        
        .series-info h3 {
            margin-bottom: 5px;
            font-size: 1.2rem;
        }
        
        .series-info p {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            pointer-events: none;
        }
        
        .carousel-nav button {
            pointer-events: all;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            backdrop-filter: blur(5px);
            transition: background 0.3s;
        }
        
        .carousel-nav button:hover {
            background: var(--primary);
        }
        
        footer {
            text-align: center;
            padding: 30px 5%;
            background-color: rgba(0, 0, 0, 0.3);
            margin-top: 50px;
        }
        
        .footer-logo {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--primary);
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 20px;
        }
        
        .footer-links a {
            color: var(--light);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--primary);
        }
        
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        
        .social-icons a {
            color: var(--light);
            font-size: 1.5rem;
            transition: color 0.3s;
        }
        
        .social-icons a:hover {
            color: var(--primary);
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .series-card {
                min-width: 180px;
            }
            
            .series-card img {
                height: 250px;
            }
        }


        
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="icon/css/boxicons.min.css">
    <link rel="stylesheet" href="lz/Font-Awesome/css/all.min.css">
</head>
<body>
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
            <li><a href="index.php" class="home-active">Página Inicial</a></li>
            <li><a href="#movies">Filmes</a></li>
            <li><a href="series0.php">Series</a></li>
            <li><a href="index.php #coming">Em breve</a></li>
            <li><a href="index.php #newsletter">Sobre</a></li>
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
    
    <section class="hero">
        <h1>Inovação e Entretenimento Em Um Clique!</h1>
        <p>Descubra histórias cativantes e personagens memoráveis em nossa coleção curada de séries desenvolvidas.</p>
    </section>
    
    <section class="category">
        <h2 class="category-title">Animações</h2>
        <div class="carousel">
            <div class="carousel-container">
                <!-- Série 1 -->
                <div class="series-card" onclick="openSeries('she-ra')">
                    <img src="img/series/rick.jpeg" alt="She-Ra">
                    <div class="series-info">
                        <h3>Rick And Morty</h3>
                        <p>Criada por Justin Roiland e Dan Harmon.</p>
                    </div>
                </div>

                <div class="series-card" onclick="openSeries('she-ra')">
                    <img src="img/series/Rt2.jpeg" alt="She-Ra">
                    <div class="series-info">
                        <h3>Rick And Morty</h3>
                        <p>Criada por Justin Roiland e Dan Harmon.</p>
                    </div>
                </div>

                <div class="series-card" onclick="openSeries('she-ra')">
                    <img src="img/series/shera.jpg" alt="She-Ra">
                    <div class="series-info">
                        <h3>Rick And Morty</h3>
                        <p>Criada por Justin Roiland e Dan Harmon.</p>
                    </div>
                </div>
                
                <!-- Série 2 -->
                <div class="series-card" onclick="openSeries('hilda')">
                    <img src="img/series/hilda.jpeg" alt="Hilda">
                    <div class="series-info">
                        <h3>Hilda</h3>
                        <p>Baseada nos quadrinhos de Luke Pearson</p>
                    </div>
                </div>
                
                <!-- Série 3 -->
                <div class="series-card" onclick="openSeries('kipo')">
                    <img src="img/series/kipo.jpg" alt="Kipo">
                    <div class="series-info">
                        <h3>Kipo e os Animonstros</h3>
                        <p>Criada por Radford Sechrist</p>
                    </div>
                </div>
                
                <!-- Série 4 -->
                <div class="series-card" onclick="openSeries('owl-house')">
                    <img src="img/series/coruja.jpeg" alt="A Casa da Coruja">
                    <div class="series-info">
                        <h3>A Casa da Coruja</h3>
                        <p>Criada por Dana Terrace</p>
                    </div>
                </div>
                
                <!-- Série 5 -->
                <div class="series-card" onclick="openSeries('steven-universe')">
                    <img src="img/series/steven.jpg" alt="Steven Universe">
                    <div class="series-info">
                        <h3>Steven Universe</h3>
                        <p>Criada por Rebecca Sugar</p>
                    </div>
                </div>
            </div>
            
            <div class="carousel-nav">
                <button class="carousel-prev"><i class="fas fa-chevron-left"></i></button>
                <button class="carousel-next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </section>
    
    <section class="category">
        <h2 class="category-title">Aventuras</h2>
        <div class="carousel">
            <div class="carousel-container">
                <!-- Série 1 -->
                <div class="series-card" onclick="openSeries('anne')">
                    <img src="img/series/anne.jpeg" alt="Anne with an E">
                    <div class="series-info">
                        <h3>Anne with an E</h3>
                        <p>Desenvolvida por Moira Walley-Beckett</p>
                    </div>
                </div>
                
                <!-- Série 2 -->
                <div class="series-card" onclick="openSeries('the-marvelous-mrs-maisel')">
                    <img src="img/series/maisel.jpeg" alt="The Marvelous Mrs. Maisel">
                    <div class="series-info">
                        <h3>The Marvelous Mrs. Maisel</h3>
                        <p>Criada por Amy Sherman-Palladino</p>
                    </div>
                </div>

                <div class="series-card" onclick="openSeries('the-marvelous-mrs-maisel')">
                    <img src="img/m1.jpg" alt="The Marvelous Mrs. Maisel">
                    <div class="series-info">
                        <h3>The Marvelous Mrs. Maisel</h3>
                        <p>Criada por Amy Sherman-Palladino</p>
                    </div>
                </div>

                <div class="series-card" onclick="openSeries('the-marvelous-mrs-maisel')">
                    <img src="img/m2.jpg" alt="The Marvelous Mrs. Maisel">
                    <div class="series-info">
                        <h3>The Marvelous Mrs. Maisel</h3>
                        <p>Criada por Amy Sherman-Palladino</p>
                    </div>
                </div>

                <div class="series-card" onclick="openSeries('the-marvelous-mrs-maisel')">
                    <img src="img/m3.jpg" alt="The Marvelous Mrs. Maisel">
                    <div class="series-info">
                        <h3>The Marvelous Mrs. Maisel</h3>
                        <p>Criada por Amy Sherman-Palladino</p>
                    </div>
                </div>
                
                <!-- Série 3 -->
                <div class="series-card" onclick="openSeries('flea-bag')">
                    <img src="img/series/fleabag.jpeg" alt="Fleabag">
                    <div class="series-info">
                        <h3>Fleabag</h3>
                        <p>Criada por Phoebe Waller-Bridge</p>
                    </div>
                </div>
                
                <!-- Série 4 -->
                <div class="series-card" onclick="openSeries('big-little-lies')">
                    <img src="img/series/big.jpg" alt="Big Little Lies">
                    <div class="series-info">
                        <h3>Big Little Lies</h3>
                        <p>Desenvolvida por David E. Kelley (baseado no livro de Liane Moriarty)</p>
                    </div>
                </div>
            </div>
            
            <div class="carousel-nav">
                <button class="carousel-prev"><i class="fas fa-chevron-left"></i></button>
                <button class="carousel-next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </section>
    
    <section class="category">
        <h2 class="category-title">Dramas</h2>
        <div class="carousel">
            <div class="carousel-container">
                <!-- Série 1 -->
                <div class="series-card" onclick="openSeries('killing-eve')">
                    <img src="img/series/kelling.jpeg" alt="Killing Eve">
                    <div class="series-info">
                        <h3>Killing Eve</h3>
                        <p>Criada por Phoebe Waller-Bridge</p>
                    </div>
                </div>
                
                <!-- Série 2 -->
                <div class="series-card" onclick="openSeries('the-handmaids-tale')">
                    <img src="img/series/tale.jpeg" alt="The Handmaid's Tale">
                    <div class="series-info">
                        <h3>The Handmaid's Tale</h3>
                        <p>Baseado no livro de Margaret Atwood</p>
                    </div>
                </div>
                
                <!-- Série 3 -->
                <div class="series-card" onclick="openSeries('little-fires-everywhere')">
                    <img src="img/series/litle.jpeg" alt="Little Fires Everywhere">
                    <div class="series-info">
                        <h3>Little Fires Everywhere</h3>
                        <p>Baseado no livro de Celeste Ng</p>
                    </div>
                </div>
                
                <!-- Série 4 -->
                <div class="series-card" onclick="openSeries('unbelievable')">
                    <img src="img/m6.jpg" alt="Unbelievable">
                    <div class="series-info">
                        <h3>Unbelievable</h3>
                        <p>Criada por Susannah Grant</p>
                    </div>
                </div>

                <div class="series-card" onclick="openSeries('unbelievable')">
                    <img src="img/m7.jpg" alt="Unbelievable">
                    <div class="series-info">
                        <h3>Unbelievable</h3>
                        <p>Criada por Susannah Grant</p>
                    </div>
                </div>

                <div class="series-card" onclick="openSeries('unbelievable')">
                    <img src="img/m8.jpg" alt="Unbelievable">
                    <div class="series-info">
                        <h3>Unbelievable</h3>
                        <p>Criada por Susannah Grant</p>
                    </div>
                </div>

                <div class="series-card" onclick="openSeries('unbelievable')">
                    <img src="img/series/unbelievable.jpeg" alt="Unbelievable">
                    <div class="series-info">
                        <h3>Unbelievable</h3>
                        <p>Criada por Susannah Grant</p>
                    </div>
                </div>
            </div>
            
            <div class="carousel-nav">
                <button class="carousel-prev"><i class="fas fa-chevron-left"></i></button>
                <button class="carousel-next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="footer-logo">Streamora</div>
        <div class="footer-links">
            <a href="#">Termos de Uso</a>
            <a href="#">Política de Privacidade</a>
            <a href="#">Contato</a>
            <a href="#">Sobre Nós</a>
        </div>
        <p>© 2023 Streamora - Plataforma de streaming desenvolvida por mulheres</p>
        <div class="social-icons">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-tiktok"></i></a>
        </div>
    </footer>
    
    <script>
        // Navegação do carrossel
        document.querySelectorAll('.carousel').forEach(carousel => {
            const container = carousel.querySelector('.carousel-container');
            const prevBtn = carousel.querySelector('.carousel-prev');
            const nextBtn = carousel.querySelector('.carousel-next');
            
            prevBtn.addEventListener('click', () => {
                container.scrollBy({
                    left: -250,
                    behavior: 'smooth'
                });
            });
            
            nextBtn.addEventListener('click', () => {
                container.scrollBy({
                    left: 250,
                    behavior: 'smooth'
                });
            });
        });
        
        // Função para abrir a página da série
        function openSeries(seriesId) {
            // Aqui você pode redirecionar para a página da série ou mostrar um modal
            window.location.href = `series.html?id=${seriesId}`;
            
            // Para este exemplo, vamos mostrar um alerta
            // alert(`Abrindo página da série: ${seriesId}`);
            
            // Na implementação real, você pode usar:
            // window.location.href = `series-details.html?id=${seriesId}`;
        }


        function addToList(seriesId, title, creator, image) {
    const myList = JSON.parse(localStorage.getItem('myList')) || [];
    
    if (!myList.some(item => item.id === seriesId)) {
        myList.push({ id: seriesId, title, creator, image });
        localStorage.setItem('myList', JSON.stringify(myList));
        alert('Adicionado à sua lista!');
    } else {
        alert('Esta série já está na sua lista!');
    }
}
    </script>

    <script>
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
            credentials: 'include'
        });
        
        if (!response.ok) {
            throw new Error(`Erro HTTP: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.authenticated && data.user) {
            // Atualiza a interface com os dados do usuário
            updateUserProfile(data.user);
            
            // Se estiver na página de login, redireciona para a home
            if (window.location.pathname.includes('login.html')) {
                window.location.href = data.user.isAdmin ? 'adminPage.html' : 'index.html';
            }
        } else {
            // Se não autenticado e não estiver na página de login, redireciona
            if (!window.location.pathname.includes('index.html')) {
                window.location.href = 'index.html';
            }
        }
    } catch (error) {
        console.error('Erro ao verificar sessão:', error);
        
        // Redireciona para login apenas se não estiver já na página de login
        if (!window.location.pathname.includes('index.html')) {
            window.location.href = 'index.html';
        }
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

     <script src="main.js"></script>
    <script src="index.js"></script>
</body>
</html>