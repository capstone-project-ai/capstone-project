<template>
    <div class="card shadow-sm centered-card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <button type="button" class="btn btn-secondary me-3" @click="goBack">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <h5 class="card-title flex-grow-1 text-center">Create a Room</h5>
            </div>
            <form @submit.prevent="createRoom">
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
                    <div v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</div>
                </div><div class="form-group mb-3">
                    <label for="roomName" class="mb-2">Room Name</label>
                    <input
                        type="text"
                        id="roomName"
                        v-model="roomName"
                        class="form-control"
                        placeholder="Enter Room Name"
                        required
                    />
                    <div v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</div>
                </div>
                <button type="submit" class="btn btn-primary form-control">Create</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            roomId: '',
            roomName: '',
            user: this.$store.state.auth.user,
            errorMessage: '',
        }
    },
    methods: {
        createRoom() {
            // Logic for creating a room
            console.log('Creating room:', this.roomId);
            axios.post('/api/room-creates', { roomId: this.roomId, roomName: this.roomName })
                .then(response => {
                    console.log(response.data.roomId);
                    this.errorMessage = ""
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

    .flex-grow-1 {
        flex-grow: 1; /* Allow the title to take up remaining space */
    }
</style>