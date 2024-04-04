// Function to load page content
function loadPage(url) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById('content-container').innerHTML = data;

            // Save the loaded content to localStorage
            localStorage.setItem('loadedContent', data);
        })
        .catch(error => console.error('Error loading page:', error));
}

// Function to check for previously loaded content in localStorage
function loadSavedContent() {
    const savedContent = localStorage.getItem('loadedContent');
    if (savedContent) {
        document.getElementById('content-container').innerHTML = savedContent;
    }
}

// Call loadSavedContent when the page loads
window.addEventListener('load', loadSavedContent);
