<template>
    <div class="container mt-5">
        <div class="mb-5">
            <h2 v-if="user.role_id === 2">Create a Poll</h2>
            <form @submit.prevent="createPoll" v-if="user.role_id === 2">
                <div class="mb-3">
                    <label for="question" class="form-label">Question</label>
                    <textarea
                        id="question"
                        class="form-control"
                        v-model="question"
                        required
                    ></textarea>
                </div>
                <div class="mb-3">
                    <label for="timer" class="form-label">Time limit</label>
                    <input class="form-control" id="timer" v-model.number="timeLimit" placeholder="Time Limit (seconds)" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Options</label>
                    <div v-for="(option, index) in options" :key="index" class="input-group mb-3">
                        <input
                            type="text"
                            class="form-control"
                            :value="option"
                            @input="updateoption(index, $event.target.value)"
                            placeholder="Option"
                            required
                        />
                        <button type="button" class="btn btn-danger" @click="removeOption(index)">Remove</button>
                    </div>
                    <button type="button" class="btn btn-secondary" @click="addOption">Add Option</button>
                </div>

                <button type="submit" class="btn btn-primary">Submit Poll</button>
            </form>
        </div>
        <ul v-if="polls.length > 0 && user.role_id != 2">
            <h2 >Poll</h2>
            <li v-for="poll in polls" :key="poll.id">
                <h4>{{ poll.question }}</h4>
                <div v-if="poll.is_expired">
                    <p>This poll has expired.</p>
                    <button @click="showResults(poll.id)">Show Results</button>
                </div>
                <div v-else>
                    <p>Time remaining: {{ formatTimeRemaining(poll.expires_at) }}</p>
                    <button @click="submitResponse(poll.id)">Submit Response</button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user:this.$store.state.auth.user,
            question: '',
            roomId: this.$router.currentRoute.value?.params?.roomId,
            options: [''],
            polls: [],
            timeLimit: null,
        };
    },

    mounted() {
        this.fetchPolls();
    },

    methods: {
        addOption() {
            this.options.push('');
        },

        removeOption(index) {
            this.options.splice(index, 1);
        },

        updateoption(index, value) {
            this.$set(this.options, index, value);
        },

        async createPoll() {
            console.log(this.roomId);
            
            await axios.post('/api/polls', {
                room_id: this.roomId,
                question: this.question,
                options: this.options,
                time_limit: this.timeLimit,
            })
            .then(response => {
                console.log(response);
                
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

        resetForm() {
            this.question = '';
            this.options = [''];
        },
        
        async fetchPolls() {
            const response = await axios.get(`/api/polls?room_id=${this.roomId}`);
            console.log(response.data);
            
            // this.polls = response.data;
        },

        async showResults(pollId) {
            const response = await axios.get(`/api/polls/${pollId}/results`);
            this.results = response.data;
        },
        
        formatTimeRemaining(expiresAt) {
            const remaining = new Date(expiresAt) - new Date();
            const seconds = Math.floor((remaining / 1000) % 60);
            const minutes = Math.floor((remaining / (1000 * 60)) % 60);
            const hours = Math.floor((remaining / (1000 * 60 * 60)) % 24);
            return `${hours}h ${minutes}m ${seconds}s`;
        },
    },
};
</script>

<style scoped>
/* Add any custom styles here */
</style>
