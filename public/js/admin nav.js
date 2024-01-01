// Get all the navigation links
const navLinks = document.querySelectorAll('.nav-link');

// Function to handle click event on the links
function handleLinkClick(event) {
  // Prevent the default link behavior (for demonstration purposes)
  event.preventDefault();

  // Remove 'active' class from all links
  navLinks.forEach(link => {
    link.classList.remove('active');
  });

  // Add 'active' class to the clicked link
  event.target.classList.add('active');
}

// Add click event listeners to each link
navLinks.forEach(link => {
  link.addEventListener('click', handleLinkClick);
});