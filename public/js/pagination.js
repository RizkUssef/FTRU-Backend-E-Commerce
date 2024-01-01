// Get all the navigation links
const pagiLinks = document.querySelectorAll('.page');

// Function to handle click event on the links
function handleLinkClick(event) {
  // Prevent the default link behavior (for demonstration purposes)
  event.preventDefault();

  // Remove 'active' class from all links
  pagiLinks.forEach(link => {
    link.classList.remove('active');
  });

  // Add 'active' class to the clicked link
  event.target.classList.add('active');
}

// Add click event listeners to each link
pagiLinks.forEach(link => {
  link.addEventListener('click', handleLinkClick);
});
