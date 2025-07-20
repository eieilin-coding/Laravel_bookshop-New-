
    document.querySelectorAll('.dropdown-toggle').forEach(button => {
        button.addEventListener('click', function () {
            const dropdown = this.closest('.dropdown');
            dropdown.classList.toggle('show');

            // Close other open dropdowns
            document.querySelectorAll('.dropdown').forEach(d => {
                if (d !== dropdown) d.classList.remove('show');
            });
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('show'));
        }
    });

