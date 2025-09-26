<?php
session_start();
require_once('php/bd.class.php');



// Verificação de sessão de administrador corrigida
if (!isset($_SESSION['is_admin'])) {
    header("Location: login.html");
    exit();
}

// Verifica se o usuário é admin
if (!$_SESSION['is_admin']) {
    header("Location: index.html");
    exit();
}

// Você pode adicionar mais informações da sessão aqui se necessário
$admin_name = $_SESSION['admin_name'] ?? 'Administrador';
$admin_email = $_SESSION['admin_email'] ?? 'admin@streamora.com';
?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard STREAMORA</title>
    <link rel="stylesheet" href="swiper-bundle.min.css">
    <link rel="stylesheet" href="lz/animate.min.css">
    <link href='icon/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="adminPage.css">   
    <link rel="stylesheet" href="perfil.css">
</head>
<body>
    <!-- Navbar  -->
    <header>
        <a href="#home" class="logo">
            <div class="logo-icon">
                    <img src="img/logo3.png" alt="">
                </div>
            <i class='bx bxs-dashbsoard'></i>STREAMORA
        </a>
        <div class="bx bx-menu" id="menu-icon"></div>

        <!-- menu  -->
        <ul class="navbar">
            <li><a href="#home" class="home-active">Dashboard</a></li>
            <li><a href="#users">Usuários</a></li>
            <li style="display: none;"><a href="#stats">Estatísticas</a></li>
            <li><a href="#settings">Configurações</a></li>
        </ul>
        <div class="user-profile-wrapper">
    <div class="user-profile">
        <div class="profile-info">
            <img src="img/perfil.png" alt="Perfil" class="profile-pic">
            <span class="profile-name">Olá, Admin</span>
            <i class="fas fa-chevron-down dropdown-arrow"></i>
        </div>
        
        <div class="profile-dropdown">
            <div class="dropdown-header">
                <img src="img/perfil.png" alt="Perfil" class="dropdown-pic">
                <div>
                    <h4>Adminstrador</h4>
                </div>
            </div>
            
            <ul class="dropdown-menu">
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

    <!-- Dashboard Main  -->
    <section class="dashboard" id="home">
        <div class="welcome-banner">
            <div class="welcome-text">
                <h1>Bem-vinda ao Painel de Controle</h1>
                <p>Gerencie sua plataforma de streaming com facilidade e estilo</p>
                <div class="stats-cards">
                    <div class="card">
                        <i class='bx bx-user'></i>
                        <h3>2,458</h3>
                        <p>Usuários</p>
                    </div>
                    <div class="card">
                        <i class='bx bx-play-circle'></i>
                        <h3>1,245</h3>
                        <p>Streams Hoje</p>
                    </div>
                    <div class="card" style="display: none;">
                        <i class='bx bx-dollar-circle'></i>
                        <h3>R$ 8,542</h3>
                        <p>Receita Diária</p>
                    </div>
                </div>
            </div>
            <div class="welcome-image">
                <img src="img/img.jpeg" alt="Streaming">
            </div>
        </div>
    </section>

    <!-- Users Section  -->
    <section class="users-section" id="users">
        <h2 class="heading">Gerenciamento de Usuários</h2>
        
        <div class="search-bar">
            <i class='bx bx-search'></i>
            <input type="text" placeholder="Pesquisar usuários...">
            <button class="btn">Filtrar</button>
        </div>
        
        <div class="users-table">
            <div class="table-header">
                <div class="header-item">Usuário</div>
                <div class="header-item">Data de Inclusão</div>
                <div class="header-item">Status</div>
                <div class="header-item">Último Acesso</div>
                <div class="header-item">Ações</div>
            </div>
            
            <div class="table-row">
                <div class="table-data user-info">
                    <img src="img/perfil.png" alt="User">
                    <div>
                        <h4>Ana Silva</h4>
                        <span>ana.silva@email.com</span>
                    </div>
                </div>
                <div class="table-data">Premium</div>
                <div class="table-data"><span class="status active">Ativo</span></div>
                <div class="table-data">2 horas atrás</div>
                <div class="table-data actions">
                    <button class="btn-edit"><i class='bx bx-edit'></i></button>
                    <button class="btn-delete"><i class='bx bx-trash'></i></button>
                </div>
            </div>
            
            <div class="table-row">
                <div class="table-data user-info">
                    <img src="img/perfil.png" alt="User">
                    <div>
                        <h4>Beatriz Oliveira</h4>
                        <span>beatriz.oliveira@email.com</span>
                    </div>
                </div>
                <div class="table-data">Básico</div>
                <div class="table-data"><span class="status inactive">Inativo</span></div>
                <div class="table-data">3 dias atrás</div>
                <div class="table-data actions">
                    <button class="btn-edit"><i class='bx bx-edit'></i></button>
                    <button class="btn-delete"><i class='bx bx-trash'></i></button>
                </div>
            </div>
            
            <div class="table-row">
                <div class="table-data user-info">
                    <img src="img/perfil.png" alt="User">
                    <div>
                        <h4>Camila Santos</h4>
                        <span>camila.santos@email.com</span>
                    </div>
                </div>
                <div class="table-data">Família</div>
                <div class="table-data"><span class="status active">Ativo</span></div>
                <div class="table-data">1 hora atrás</div>
                <div class="table-data actions">
                    <button class="btn-edit"><i class='bx bx-edit'></i></button>
                    <button class="btn-delete"><i class='bx bx-trash'></i></button>
                </div>
            </div>
            
            <div class="table-row">
                <div class="table-data user-info">
                    <img src="img/perfil.png" alt="User">
                    <div>
                        <h4>Daniela Costa</h4>
                        <span>daniela.costa@email.com</span>
                    </div>
                </div>
                <div class="table-data">Premium</div>
                <div class="table-data"><span class="status pending">Pendente</span></div>
                <div class="table-data">5 dias atrás</div>
                <div class="table-data actions">
                    <button class="btn-edit"><i class='bx bx-edit'></i></button>
                    <button class="btn-delete"><i class='bx bx-trash'></i></button>
                </div>
            </div>
            
            <div class="table-row">
                <div class="table-data user-info">
                    <img src="img/perfil.png" alt="User">
                    <div>
                        <h4>Eduarda Pereira</h4>
                        <span>eduarda.pereira@email.com</span>
                    </div>
                </div>
                <div class="table-data">Básico</div>
                <div class="table-data"><span class="status active">Ativo</span></div>
                <div class="table-data">10 minutos atrás</div>
                <div class="table-data actions">
                    <button class="btn-edit"><i class='bx bx-edit'></i></button>
                    <button class="btn-delete"><i class='bx bx-trash'></i></button>
                </div>
            </div>
        </div>
        
        <div class="pagination">
            <button class="btn-pagination"><i class='bx bx-chevron-left'></i></button>
            <button class="btn-pagination active">1</button>
            <button class="btn-pagination">2</button>
            <button class="btn-pagination">3</button>
            <button class="btn-pagination"><i class='bx bx-chevron-right'></i></button>
        </div>
    </section>

    <!-- Stats Section  -->
    <section class="stats-section" id="stats" style="display: none;">
        <h2 class="heading">Estatísticas e Análises</h2>
        
        <div class="stats-grid">
            <div class="stat-card big">
                <h3>Atividade dos Usuários</h3>
                <div class="chart-placeholder"></div>
            </div>
            
            <div class="stat-card">
                <h3>Planos Mais Populares</h3>
                <div class="pie-chart-placeholder"></div>
            </div>
            
            <div class="stat-card">
                <h3>Novos Usuários</h3>
                <div class="mini-chart-placeholder"></div>
                <div class="stat-number">+124</div>
                <p>este mês</p>
            </div>
            
            <div class="stat-card">
                <h3>Taxa de Retenção</h3>
                <div class="mini-chart-placeholder"></div>
                <div class="stat-number">78%</div>
                <p>usuários ativos</p>
            </div>
        </div>
    </section>

    <!-- Footer  -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>STREAMORA</h3>
                <p>A plataforma de streaming feita por mulheres que amam cinema.</p>
            </div>
            <div class="footer-section">
                <h3>Links Rápidos</h3>
                <ul>
                    <li><a href="#home">Dashboard</a></li>
                    <li><a href="#users">Usuários</a></li>
                    <li style="display: none;"><a href="#stats">Estatísticas</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contato</h3>
                <p>suporte@streamora.com</p>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-instagram'></i></a>
                    <a href="#"><i class='bx bxl-twitter'></i></a>
                    <a href="#"><i class='bx bxl-pinterest'></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 STREAMORA. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="swiper-bundle.min.js"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="script.js"></script>
      <script src="main.js"></script>

    <script>


 document.addEventListener('DOMContentLoaded', function() {
    const userProfile = document.querySelector('.user-profile');
    
    // Abrir/fechar dropdown
    userProfile.addEventListener('click', function(e) {
        e.stopPropagation();
        this.classList.toggle('active');
    });
    
    // Fechar ao clicar fora
    document.addEventListener('click', function() {
        userProfile.classList.remove('active');
    });
    
    // Prevenir fechamento ao clicar no dropdown
    const dropdown = document.querySelector('.profile-dropdown');
    dropdown.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // Efeito de hover nos itens
    const menuItems = document.querySelectorAll('.dropdown-menu li a');
    menuItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
        });
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
    
    // Logout action
    const logoutBtn = document.querySelector('.logout-btn');
    logoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        // Aqui você pode adicionar a lógica de logout
         window.location.href = 'login.html';
    });
});

function updateUserProfile(user) {
    // Verifica se os elementos existem antes de atualizar
    const profilePic = document.querySelector('.profile-pic');
    const profileName = document.querySelector('.profile-name');
    const dropdownPic = document.querySelector('.dropdown-pic');
    const dropdownName = document.querySelector('.dropdown-header h4');
    
    if (profilePic) {
        profilePic.src = user.photo || 'img/perfil.png';
        profilePic.style.display = 'block';
    }
    
    if (profileName) {
        profileName.textContent = `Olá, ${user.name.split(' ')[0]}`;
    }
    
    if (dropdownPic) {
        dropdownPic.src = user.photo || 'img/perfil.png';
    }
    
    if (dropdownName) {
        dropdownName.textContent = user.name;
    }
    
    // Armazena os dados do usuário para uso posterior
    sessionStorage.setItem('currentUser', JSON.stringify(user));
}

// Verifica a sessão ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    
    // Configura o logout
    document.querySelector('.logout-btn')?.addEventListener('click', function(e) {
        e.preventDefault();
        logoutUser();
    });
});


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