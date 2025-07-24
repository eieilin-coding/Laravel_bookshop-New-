// document.addEventListener('DOMContentLoaded', function () {

//     // Get the CSRF token from the meta tag
//     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
//     const wishlistButtons = document.querySelectorAll('.wishlist-btn');
//     const wishlistModal = document.getElementById('wishlistModal');
//     const wishlistModalOverlay = document.getElementById('wishlistModalOverlay');
//     const wishlistModalTitle = document.getElementById('wishlistModalTitle');
//     const wishlistModalMessage = document.getElementById('wishlistModalMessage');
//     const closeModalBtn = document.getElementById('closeWishlistModal');

//     wishlistButtons.forEach(button => {
//         button.addEventListener('click', function (e) {
//             e.preventDefault();
//             const bookId = this.getAttribute('data-book-id');
//             const bookTitle = this.getAttribute('data-book-title');

//             // Show loading state
//             wishlistModalTitle.textContent = 'Processing...';
//             wishlistModalMessage.textContent = '';
//             wishlistModal.style.display = 'block';
//             wishlistModalOverlay.style.display = 'block';

//             // Send AJAX request to add to wishlist
//             fetch(`/wishlist/add/${bookId}`, {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': csrfToken
//                 }
//             })
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data.success) {
//                         wishlistModalTitle.textContent = 'Added to Wishlist';
//                         wishlistModalMessage.innerHTML = `<em>${bookTitle}</em> added to your wishlist`;
//                     } else {
//                         wishlistModalTitle.textContent = 'Error';
//                         wishlistModalMessage.textContent = data.message || 'Could not add to wishlist';
//                     }
//                 })
//                 .catch(error => {
//                     wishlistModalTitle.textContent = 'Error';
//                     wishlistModalMessage.textContent = 'An error occurred';
//                     console.error('Error:', error);
//                 });
//         });
//     });

//     // Close modal handlers
//     closeModalBtn.addEventListener('click', function (e) {
//         e.preventDefault();
//         wishlistModal.style.display = 'none';
//         wishlistModalOverlay.style.display = 'none';
//     });

//     wishlistModalOverlay.addEventListener('click', function () {
//         wishlistModal.style.display = 'none';
//         this.style.display = 'none';
//     });
// });

// public/js/wishlist.js

document.addEventListener('DOMContentLoaded', function() {
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

    // Call it on page load
    updateWishlistCount();

    // Event listener for each wishlist button
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const bookId = this.dataset.bookId;
            const bookTitle = this.dataset.bookTitle;

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
                        modalIconDiv.innerHTML = '<i class="ri-heart-3-fill"></i>'; // Full heart icon
                        modalTitle.textContent = 'Added to Wishlist';
                        modalMessage.innerHTML = `"${bookTitle}" added to your wishlist`;
                    } else if (data.action === 'removed') {
                        modalIconDiv.innerHTML = '<i class="ri-close-circle-fill"></i>'; // Close icon
                        modalTitle.textContent = 'Removed from Wishlist';
                        modalMessage.innerHTML = `"${bookTitle}" removed from your wishlist`;
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
    closeModalButton.addEventListener('click', function() {
        wishlistModal.style.display = 'none';
        modalOverlay.style.display = 'none';
    });

    modalOverlay.addEventListener('click', function() {
        wishlistModal.style.display = 'none';
        modalOverlay.style.display = 'none';
    });
});