<template>
    <div class="card shadow-sm centered-card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <button type="button" class="btn btn-secondary me-3" @click="goBack">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <h5 class="card-title flex-grow-1 text-center">Join Room</h5>
            </div>
            <form @submit.prevent="joinRoom">
                <div class="form-group mb-3">
                    <label for="roomId" class="mb-2">Room ID</label>
                    <input
                        type="text"
                        id="roomId"
                        v-model="roomId"
                        class="form-control"
                        placeholder="Enter Room ID"
                        required
                    />
                </div>
                <button type="submit" class="btn btn-primary form-control">Join</button>
            </form>
        </div>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            roomId: ''
        }
    },
    methods: {
        joinRoom() {
            // Logic for joining a room
            axios.post('/api/check-if-exist', { roomId: this.roomId })
                .then(response => {
                    window.location = "/room/" + response.data.roomId;
                })
                .catch(error => {
                    console.error(error.response);
                    if (error.response && error.response.data.error) {
                        this.errorMessage = error.response.data.error; // Set the error message
                    } else {
                        this.errorMessage = 'An unexpected error occurred.'; // Fallback error message
                    }
                    console.error("There was an error creating the room!", error);
                });
        },
        goBack() {
            window.location.href = "/";
        },
    }
}
</script>
  
<style scoped>
.centered-card {
    width: 100%; /* Full width on small screens */
    max-width: 400px; /* Max width for larger screens */
    margin: 0 auto;
    position: relative; /* Changed from absolute to relative */
    padding: 20px; /* Add some padding for better spacing */
}

@media (max-width: 576px) {
    .centered-card {
        padding: 15px; /* Smaller padding for mobile */
    }
}

.flex-grow-1 {
    flex-grow: 0.7 !important;
}
</style>