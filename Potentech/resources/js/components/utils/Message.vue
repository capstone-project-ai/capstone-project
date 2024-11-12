<template>
    <div>
        <input v-model="newMessage" @keyup.enter="sendMessage" placeholder="Type a message..." />
        <div v-for="msg in messages" :key="msg.id">{{ msg.message }}</div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            newMessage: '',
            messages: [],
        };
    },
    methods: {
        sendMessage() {
            // Emit event or call an API to send the message
            this.messages.push({ id: Date.now(), message: this.newMessage });
            this.newMessage = '';
        },
    },
    mounted() {
        // Fetch existing messages from the API
    },
};
</script>
