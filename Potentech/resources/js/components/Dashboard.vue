<template>
    <div class="container d-flex flex-column align-items-center justify-content-center vh-100">
        <div class="row text-center">
            <div class="col-12">
                <img src="@images/homepage_image.png" class="img-fluid mb-3" alt="Homepage" />
                <div class="d-flex flex-wrap justify-content-center">
                    <button type="button" class="btn custom-btn me-2 mb-2" >
                        <router-link :to="{name:'join-room'}" class="nav-link">Join</router-link>
                    </button>
                    <button type="button" class="btn custom-btn mb-2" :class="{ hideComponent : isDisabled }">
                        <router-link :to="{name:'create-room'}" class="nav-link">Create</router-link>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import JoinRoom from './student/JoinRoom.vue';
import CreateRoom from './teacher/CreateRoom.vue';

export default {
    name: "dashboard",
    components: {
        JoinRoom,
        CreateRoom,
    },
    data() {
        return {
            user: this.$store.state.auth.user,
            isDisabled: false,
        };
    },
    methods: {
        currentComponent() {
            if (this.user.role_id === 1) {
                this.isDisabled = true;
            }
        }
    },
    created () {
        this.currentComponent();
    },
}
</script>

<style scoped>
    :global(#app) {
        background-color: #fff !important;
    }

    .custom-btn {
        background-color: #EAECFB; 
        border: 1px solid black; 
        border-radius: 0.5rem; 
        padding: 15px; 
        flex: 1; 
        min-width: 150px; /* Ensures buttons are not too small */
    }

    /* Adjustments for mobile responsiveness */
    @media (max-width: 576px) {
        .custom-btn {
            width: 100%; /* Full width on mobile */
        }
    }

    /* Centering on desktop */
    .container {
        max-width: 600px; /* Set a max width for desktop view */
        margin: auto; /* Center horizontally */
    }

    .vh-100 {
        height: 100% !important; /* Full viewport height for vertical centering */
    }

    .hideComponent {
        display: none !important;
    }
</style>