<template>
    <div class="tab-panel">
        <!-- Header -->
        <div class="header">
            <span><b>{{ roomName }}</b> | </span>
            <span><b>ID: {{ roomId }}</b> | </span>
            <button type="button" class="btn btn-success" @click="copyLink">Copy Link</button>
            <button type="button" class="btn btn-danger" @click="endSession">End Session</button>
        </div>

        <!-- <div class="tabs">
            <button
                v-for="tab in tabs"
                :key="tab.name"
                :class="{ active: activeTab === tab.name }"
                @click="activeTab = tab.name"
            >
                <i :class="tab.tabIcon"></i> {{ tab.label }}
            </button>
        </div>
        <div class="tab-content">
            <component :is="activeComponent"></component>
        </div> -->

        <div class="tab-panel">
            <div class="tabs">
              <button
                v-for="tab in tabs"
                :key="tab.name"
                :class="{ active: activeTab === tab.name }"
                @click="activeTab = tab.name"
              >
                <i :class="tab.tabIcon"></i> {{ tab.label }}
              </button>
            </div>
            
            <!-- Wrap the dynamic component with keep-alive -->
            <div class="tab-content">
              <keep-alive>
                <component :is="activeComponent"></component>
              </keep-alive>
            </div>
        </div>


        <!-- Message Icon Box -->
        <div class="message-icon" @click="toggleInbox">
            <i class="fa-regular fa-message"></i>
        </div>

        <!-- Inbox Messages -->
        <div v-if="showInbox" class="inbox">
            <h3>Inbox Messages</h3>
            <ul>
                <li v-for="(message, index) in messages" :key="index">{{ message }}</li>
            </ul>
            <input 
                v-model="newMessage" 
                type="text" 
                placeholder="Type your response..." 
                @keyup.enter="sendMessage" 
                class="message-input"
            />
            <button @click="sendMessage">Send</button>
        </div>
    </div>
</template>


<script>
import Whiteboard from './src/Whiteboard.vue';
import PopupQuiz from './src/PopupQuiz.vue';
import Poll from './src/Poll.vue';
import UploadFiles from './src/UploadFiles.vue';
import Participants from './src/Participants.vue';

export default {
    data() {
        return {
            activeTab: 'Whiteboard',
            roomName: '', // Set your room name here
            roomId: null,
            tabs: [
                { name: 'Whiteboard', label: 'Whiteboard', tabIcon: 'fa-solid fa-chalkboard-user' },
                { name: 'PopupQuiz', label: 'Pop-Up Quiz', tabIcon: 'fa-solid fa-clipboard-question' },
                { name: 'Poll', label: 'Poll', tabIcon: 'fa-solid fa-square-poll-horizontal' },
                { name: 'UploadFiles', label: 'Upload Files', tabIcon: 'fa-solid fa-file-arrow-up' },
                { name: 'Participants', label: 'Participants', tabIcon: 'fa-solid fa-people-arrows' },
            ],
            showInbox: false,
            messages: [
                'Message 1: Hello!',
                'Message 2: How are you?',
                'Message 3: Don’t forget our meeting!',
            ],
            newMessage: '',
        };
    },
    computed: {
        activeComponent() {
            this.roomId = this.$router.currentRoute.value?.params?.roomId;

            axios.post('/api/room-check/'+ this.roomId)
                .then(response => {
                    this.roomName = response.data.room_name
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

            return {
                Whiteboard,
                PopupQuiz,
                Poll,
                UploadFiles,
                Participants,
            }[this.activeTab];
        },
    },
    methods: {
        toggleInbox() {
            this.showInbox = !this.showInbox;
        },
        sendMessage() {
            if (this.newMessage.trim()) {
                this.messages.push(this.newMessage);
                this.newMessage = '';
            }
        },
        copyLink() {
            const link = `127.0.0.1:8000/room/${this.roomId}`; // Customize your link
            navigator.clipboard.writeText(link).then(() => {
                alert('Link copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy link: ', err);
            });
        },
        endSession() {
            this.$router.push('/disconnection-page');
        }
    },
};
</script>


<style scoped>
    .tab-panel {
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .tabs {
        display: flex;
        border-bottom: 1px solid #ccc;
    }

    .tabs button {
        flex: 1;
        padding: 10px;
        border: none;
        background: none;
        cursor: pointer;
    }

    .tabs button.active {
        border-bottom: 2px solid blue;
        font-weight: bold;
    }

    .tab-content {
        padding: 20px;
    }

    /* Message Icon */
    .message-icon {
        z-index: 999999999999999;
        position: fixed;
        bottom: 20px;
        left: 20px;
        font-size: 40px;
        cursor: pointer;
        background: white; /* Set the background to white */
        width: 60px; /* Set a fixed width */
        height: 60px; /* Set a fixed height */
        border-radius: 50%; /* Make it round */
        display: flex; /* Center the icon */
        align-items: center; /* Center vertically */
        justify-content: center; /* Center horizontally */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Optional: add shadow for depth */
    }

    /* Inbox Messages */
    .inbox {
        z-index: 99999999999999;
        position: fixed;
        bottom: 80px;
        left: 20px;
        width: 250px;
        background: white;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .header {
        display: flex;
        justify-content: center; /* Center the content horizontally */
        align-items: center; /* Center the content vertically */
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }
    
    .header span {
        margin: 0 10px; /* Space out the items */
    }
    
    .header button {
        padding: 5px 10px;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>