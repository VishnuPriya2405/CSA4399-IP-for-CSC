function register(event) {
    event.preventDefault(); // Prevent the default form submission
    console.log('Register function called'); // Debugging

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        alert('Passwords do not match!');
        return;
    }

    // Save user details in localStorage (for demo purposes)
    localStorage.setItem('name', name);
    localStorage.setItem('email', email);
    localStorage.setItem('password', password); // Note: This is insecure for real applications

    alert('Successfully registered!');
    console.log('Redirecting to home.html'); // Debugging
    window.location.href = 'home.html'; // Redirect to home page
}

function login(event) {
    event.preventDefault(); // Prevent the default form submission
    console.log('Login function called'); // Debugging

    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    // Check against stored values (for demo purposes)
    if (email === localStorage.getItem('email') && password === localStorage.getItem('password')) {
        alert('Successfully logged in!');
        console.log('Redirecting to home.html'); // Debugging
        window.location.href = 'home.html'; // Redirect to home page
    } else {
        alert('Invalid credentials!');
        console.log('Login failed, credentials do not match'); // Debugging
    }
}

function logout() {
    alert('Logged out successfully!');
    window.location.href = 'login.html';
}

document.addEventListener('DOMContentLoaded', function() {
    // Load profile details if on profile page
    if (window.location.pathname.endsWith('profile.html')) {
        document.getElementById('profileName').textContent = localStorage.getItem('name');
        document.getElementById('profileEmail').textContent = localStorage.getItem('email');
    }
});
