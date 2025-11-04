
    function toggleClientHistory() {
        const grid = document.getElementById("clientHistory");
        const button = document.querySelector(".client-history-toggle");

        if (grid.classList.contains("active")) {
            // Hide dropdown
            grid.classList.remove("active");

            // Reset animation by forcing reflow
            const cards = grid.querySelectorAll(".client-card");
            cards.forEach(card => {
                card.style.animation = "none";
                card.offsetHeight; // trigger reflow
                card.style.animation = "";
            });

            button.innerHTML = "Client History ▼";
        } else {
            // Show dropdown and trigger float-down animation
            grid.classList.add("active");
            button.innerHTML = "Client History ▲";
        }
    }
