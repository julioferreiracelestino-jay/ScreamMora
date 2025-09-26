

        document.addEventListener('DOMContentLoaded', function() {
    const movieBoxes = document.querySelectorAll('.box');
    const modal = document.getElementById('movieModal');
    const closeModal = document.querySelector('.close-modal');
    const trailerVideo = document.getElementById('trailerVideo');
    const movieTitle = document.getElementById('movieTitle');
    const movieDescription = document.getElementById('movieDescription');
    
    // Dados dos filmes (pode ser substituído por uma API)
    const movieData = {
        "Dr. Estranho": {
            trailer: "https://www.youtube.com/embed/YUfWrIcX4zw?enablejsapi=1",
            description: "O talentoso neurocirurgião Stephen Strange sofre um acidente que deixa suas mãos inutilizadas. Ele busca ajuda em um local misterioso conhecido como Kamar-Taj, onde descobre o mundo da magia.",
            genre: "Fantasia",
            duration: "115 min",
            rating: "4.2/5"
        },
        // Adicione dados para outros filmes...
    };

    movieBoxes.forEach(box => {
        box.addEventListener('click', function() {
            const title = this.querySelector('h3').textContent;
            const movie = movieData[title] || {
                trailer: "https://www.youtube.com/embed/dQw4w9WgXcQ?enablejsapi=1",
                description: "Uma história emocionante cheia de reviravoltas inesperadas.",
                genre: "Drama",
                duration: "120 min",
                rating: "3.8/5"
            };
            
            // Preenche os dados do modal
            movieTitle.textContent = title;
            movieDescription.textContent = movie.description;
            trailerVideo.src = movie.trailer + "&autoplay=1&mute=1&rel=0";
            
            // Atualiza outros elementos (gênero, duração, etc.)
            document.querySelector('.genre').textContent = movie.genre;
            document.querySelector('.duration').textContent = movie.duration;
            document.querySelector('.rating span:last-child').textContent = movie.rating;
            
            // Mostra o modal
            modal.style.display = "block";
            document.body.style.overflow = "hidden";
        });
    });
    
    // Fecha o modal
    closeModal.addEventListener('click', function() {
        modal.style.display = "none";
        trailerVideo.src = "";
        document.body.style.overflow = "auto";
    });
    
    // Fecha ao clicar fora
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
            trailerVideo.src = "";
            document.body.style.overflow = "auto";
        }
    });
    
    // Botão de favorito
    document.querySelector('.favorite-btn').addEventListener('click', function() {
        this.classList.toggle('active');
        if (this.classList.contains('active')) {
            this.innerHTML = '<i class="fas fa-heart"></i> Favoritado';
            this.style.background = "rgba(255, 105, 180, 0.8)";
        } else {
            this.innerHTML = '<i class="fas fa-heart"></i> Favorito';
            this.style.background = "rgba(255, 255, 255, 0.1)";
        }
    });
});

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
        // window.location.href = '/logout';
    });
});


