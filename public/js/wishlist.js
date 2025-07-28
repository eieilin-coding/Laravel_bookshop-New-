document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');
    const wishlistCountSpan = document.getElementById('wishlist-count');
    const wishlistModal = document.getElementById('wishlistModal');
    const modalOverlay = document.getElementById('wishlistModalOverlay');
    const modalIconDiv = document.getElementById('modalIcon');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const closeModalButton = document.getElementById('closeModal');

    // Function to update the wishlist count in the navbar
    function updateWishlistCount() {
        if (!wishlistCountSpan) return;
        fetch('/wishlist/count')
            .then(response => response.json())
            .then(data => {
                wishlistCountSpan.textContent = data.count;
            })
            .catch(error => console.error('Error fetching wishlist count:', error));
    }

    // Function to check wishlist status for all books
    function checkWishlistStatus() {
        const bookIds = Array.from(wishlistButtons).map(button => button.dataset.bookId);
        
        if (bookIds.length === 0) return;
        
        fetch('/wishlist/check-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ book_ids: bookIds })
        })
        .then(response => response.json())
        .then(data => {
            // Update icons based on server response
            wishlistButtons.forEach(button => {
                const bookId = button.dataset.bookId;
                const icon = button.querySelector('i');
                if (data.wishlist_status && data.wishlist_status[bookId]) {
                    // Book is in wishlist - show filled heart
                    icon.classList.remove('ri-heart-3-line');
                    icon.classList.add('ri-heart-3-fill');
                } else {
                    // Book is not in wishlist - show outline heart
                    icon.classList.remove('ri-heart-3-fill');
                    icon.classList.add('ri-heart-3-line');
                }
            });
        })
        .catch(error => console.error('Error checking wishlist status:', error));
    }

    // Call these on page load
    updateWishlistCount();
    checkWishlistStatus();

    // Event listener for each wishlist button
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const bookId = this.dataset.bookId;
            const bookTitle = this.dataset.bookTitle;
            const icon = this.querySelector('i');

            fetch('/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ book_id: bookId })
            })
                .then(response => response.json())
                .then(data => {
                    // Check if the server returned a redirect command
                    if (!data.success && data.message === 'Unauthenticated' && data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else if (data.success) {
                        updateWishlistCount();

                        modalOverlay.style.display = 'block';
                        wishlistModal.style.display = 'block';

                        if (data.action === 'added') {
                            modalIconDiv.innerHTML = '<i class="ri-heart-3-fill"></i>';
                            modalTitle.textContent = 'Added to Wishlist';
                            modalMessage.innerHTML = `"${bookTitle}" added to your wishlist`;
                            icon.classList.remove('ri-heart-3-line');
                            icon.classList.add('ri-heart-3-fill');
                        } else if (data.action === 'removed') {
                            modalIconDiv.innerHTML = '<i class="ri-close-circle-fill"></i>';
                            modalTitle.textContent = 'Removed from Wishlist';
                            modalMessage.innerHTML = `"${bookTitle}" removed from your wishlist`;
                            icon.classList.remove('ri-heart-3-fill');
                            icon.classList.add('ri-heart-3-line');
                        }
                    } else {
                        // Handle login required error or other errors
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    });

    // Close modal event listeners
    closeModalButton.addEventListener('click', function () {
        wishlistModal.style.display = 'none';
        modalOverlay.style.display = 'none';
    });

    modalOverlay.addEventListener('click', function () {
        wishlistModal.style.display = 'none';
        modalOverlay.style.display = 'none';
    });
});