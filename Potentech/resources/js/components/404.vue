<template>
    <div class="container text-center vh-100 d-flex flex-column justify-content-center">
        <h1 class="display-1">404</h1>
        <h2 class="mb-4">Oops! Page Not Found</h2>
        <p class="lead">
            The page you are looking for does not exist.
        </p>
        <router-link to="/" class="btn btn-primary mt-3">Go to Homepage</router-link>
    </div>
</template>

<script>
export default {
    name: 'NotFound',
}
</script>

<style scoped>
.container {
    background-color: #f8f9fa; /* Light background */
    padding: 20px; /* Padding for mobile */
}

h1 {
    font-size: 6rem; /* Large size for desktop */
}

h2 {
    font-size: 2rem; /* Medium size for desktop */
}

.lead {
    font-size: 1.25rem; /* Regular text size */
}

.btn {
    padding: 10px 20px; /* Button padding */
}

/* Responsive styles */
@media (max-width: 576px) {
    h1 {
        font-size: 4rem; /* Smaller size for mobile */
    }

    h2 {
        font-size: 1.5rem; /* Smaller size for mobile */
    }

    .lead {
        font-size: 1rem; /* Smaller text size for mobile */
    }

    .btn {
        width: 100%; /* Full width button on mobile */
    }
}
</style>
