<template>
    <div class="card shadow-sm centered-card" style="margin-top: 20vh">
        <div class="card-body">
            <!-- Welcome Section -->
            <div class="d-flex align-items-center mb-3">
                <h5 class="card-title flex-grow-1 text-center">Welcome to Flexible Classroom</h5>
            </div>

            <!-- Buttons Section -->
            <div class="button-group d-flex justify-content-center mb-3">
                <button type="button" class="btn custom-btn">
                    <i class="fa-solid fa-right-to-bracket"></i> Join
                </button>
                <button type="button" class="btn custom-btn">
                    <i class="fa-regular fa-pen-to-square"></i> Create
                </button>
            </div>

            <!-- My Room List Header -->
            <div class="d-flex align-items-center mb-3">
                <h5 class="card-title flex-grow-1 text-center">My Room List</h5>
            </div>

            <!-- Room List Section -->
            <div class="room-list">
                <div class="room-item">
                    <div class="room-content">
                        <span>Room 1</span>
                        <button class="btn btn-sm custom-btn">Join</button>
                    </div>
                </div>
                <div class="room-item">
                    <div class="room-content">
                        <span>Room 2</span>
                        <button class="btn btn-sm custom-btn">Join</button>
                    </div>
                </div>
                <div class="room-item">
                    <div class="room-content">
                        <span>Room 3</span>
                        <button class="btn btn-sm custom-btn">Join</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: this.$store.state.auth.user, // Getting user data from the store
        }
    },
    methods: {
        // You can add methods here if needed later
    }
}
</script>

<style scoped>
    .centered-card {
        width: 90%; /* Full width on small screens */
        max-width: 400px; /* Max width for larger screens */
        margin: 0 auto; /* Center the card */
        padding: 20px; /* Add some padding */
    }

    @media (max-width: 576px) {
        .centered-card {
            padding: 15px; /* Smaller padding for mobile */
        }
    }

    .button-group {
        display: flex;
        justify-content: center; /* Center the buttons horizontally */
        gap: 10px; /* Add spacing between buttons */
    }

    .custom-btn {
        border: 1px solid #007bff;
        border-radius: 5px;
        padding: 10px 20px;
        background-color: #fff;
        color: #007bff;
        font-size: 14px;
        text-align: center;
    }

    .custom-btn:hover {
        background-color: #007bff;
        color: #fff;
    }

    .room-list {
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        padding: 10px;
    }

    .room-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
    }

    .room-item:last-child {
        border-bottom: none; /* Remove border for last item */
    }

    .room-content {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }
</style>
