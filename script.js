document.addEventListener('DOMContentLoaded', function() {
    // Elementos do DOM
    const menuIcon = document.querySelector('#menu-icon');
    const navbar = document.querySelector('.navbar');
    const header = document.querySelector('header');
    const usersTable = document.querySelector('.users-table');
    
    // Verificação de elementos
    if (!menuIcon || !navbar || !header || !usersTable) {
        console.error('Elementos essenciais não encontrados no DOM');
        return;
    }
    
    // Menu Toggle
    menuIcon.onclick = () => {
        menuIcon.classList.toggle('bx-x');
        navbar.classList.toggle('active');
    }
    
    // Fechar menu ao clicar nos links
    document.querySelectorAll('.navbar a').forEach(link => {
        link.addEventListener('click', () => {
            menuIcon.classList.remove('bx-x');
            navbar.classList.remove('active');
        });
    });
    
    // Efeito de sombra no header ao scrollar
    function handleScroll() {
        if (window.scrollY > 0) {
            header.classList.add('shadow');
        } else {
            header.classList.remove('shadow');
        }
    }
    
    // Debounce para melhor performance no scroll
    let isScrolling;
    window.addEventListener('scroll', () => {
        window.clearTimeout(isScrolling);
        isScrolling = setTimeout(handleScroll, 50);
    }, false);
    
    // Carrega os usuários do banco de dados
    async function loadUsers() {
    try {
        const response = await fetch('php/get_users.php');
        
        // Verifica se a resposta é JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            // Se não for JSON, pega o texto para diagnóstico
            const text = await response.text();
            throw new Error(`Resposta inesperada: ${text.substring(0, 100)}...`);
        }
        
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.error || 'Erro ao carregar usuários');
        }
        
        const users = await response.json();
        renderUsers(users);
        updateStats(users);
    } catch (error) {
        console.error('Erro detalhado:', error);
        showNotification('Erro ao carregar usuários: ' + error.message, 'error');
        
        // Log adicional para diagnóstico
        fetch('php/get_users.php')
            .then(res => res.text())
            .then(text => console.log('Resposta bruta:', text))
            .catch(err => console.error('Erro ao obter resposta bruta:', err));
    }
}
    
    // Renderiza os usuários na tabela
    function renderUsers(users) {
        // Remove as linhas de exemplo (exceto o cabeçalho)
        const existingRows = usersTable.querySelectorAll('.table-row');
        existingRows.forEach(row => {
            if (!row.classList.contains('table-header')) {
                row.remove();
            }
        });
        
        // Adiciona os usuários reais
        users.forEach(user => {
            const row = document.createElement('div');
            row.className = 'table-row';
            
            row.innerHTML = `
                <div class="table-data user-info">
                    <img src="php/${user.foto}" alt="User" onerror="this.src='img/perfil.png'">
                    <div>
                        <h4>${user.nome}</h4>
                        <span>${user.email}</span>
                    </div>
                </div>
                <div class="table-data">${user.data_cadastro}</div>
                <div class="table-data"><span class="status ${user.status.toLowerCase()}">${user.status}</span></div>
                <div class="table-data">${user.ultimo_acesso}</div>
                <div class="table-data actions">
                    <button class="btn-edit" data-id="${user.id}"><i class='bx bx-edit'></i></button>
                    <button class="btn-delete" data-id="${user.id}"><i class='bx bx-trash'></i></button>
                </div>
            `;
            
            usersTable.appendChild(row);
        });
        
        // Adiciona eventos aos botões
        addButtonEvents();
         // Atualize o event listener
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const userId = this.getAttribute('data-id');
            const isAdmin = this.getAttribute('data-admin') === '1';
            deleteUser(userId, isAdmin);
        });
    });
    }
    
    // Atualiza as estatísticas
    function updateStats(users) {
        const activeUsers = users.filter(user => user.status === 'Ativo').length;
        const inactiveUsers = users.filter(user => user.status === 'Inativo').length;
        const totalUsers = users.length;
        
        // Atualiza os cards de estatísticas
        document.querySelector('.stats-cards .card:nth-child(1) h3').textContent = totalUsers.toLocaleString();
        document.querySelector('.stats-cards .card:nth-child(2) h3').textContent = activeUsers.toLocaleString();
    }
    
    // Adiciona eventos aos botões de editar e deletar
    function addButtonEvents() {
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const userId = this.getAttribute('data-id');
                deleteUser(userId);
            });
        });
        
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const userId = this.getAttribute('data-id');
                editUser(userId);
            });
        });
    }
    
    // Função para deletar usuário
   async function deleteUser(userId) {
    try {
        // Confirmação antes de deletar
        const confirmation = await Swal.fire({
            title: 'Confirmar exclusão',
            html: `Você está prestes a deletar o usuário <b>#${userId}</b>.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, deletar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        });

        if (!confirmation.isConfirmed) return;

        // Mostra loader
        Swal.fire({
            title: 'Processando...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        // Envia como POST com JSON
        const response = await fetch(`php/delete_user.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: userId }),
            credentials: 'include'
        });

        const data = await response.json();

        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Erro ao deletar usuário');
        }

        // Sucesso
        await Swal.fire({
            title: 'Sucesso!',
            text: data.message,
            icon: 'success',
            timer: 2000
        });

        // Recarrega a lista
        loadUsers();

    } catch (error) {
        console.error('Erro:', error);
        Swal.fire({
            title: 'Erro',
            text: error.message,
            icon: 'error'
        });
    }
}
    
function editUser(userId) {
    Swal.fire({
        title: 'Edição em Desenvolvimento',
        html: `
            <div style="text-align: left;">
                <p>Esta funcionalidade será disponibilizada em breve.</p>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'OK',
        confirmButtonColor: 'var(--primary)', 
        timer: 8000,
        timerProgressBar: true,
        showConfirmButton: false,
        backdrop: `
            rgba(77, 9, 70, 0.4)
            left top
            no-repeat
        `,
        showClass: {
            popup: 'animate__animated animate__zoomIn'
        }
    });
}
    
    // Função de notificação
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Função de busca/filtro
    document.querySelector('.search-bar .btn').addEventListener('click', function() {
        const searchTerm = document.querySelector('.search-bar input').value.toLowerCase();
        const rows = document.querySelectorAll('.users-table .table-row:not(.table-header)');
        
        rows.forEach(row => {
            const name = row.querySelector('.user-info h4').textContent.toLowerCase();
            const email = row.querySelector('.user-info span').textContent.toLowerCase();
            
            if (name.includes(searchTerm) || email.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Inicializa o dashboard
    handleScroll(); // Define estado inicial do header
    loadUsers();    // Carrega os usuários
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