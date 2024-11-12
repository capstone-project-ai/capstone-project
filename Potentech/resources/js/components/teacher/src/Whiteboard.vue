<template>
    <div>
        <!-- <div class="d-flex justify-content-between align-items-center" style="position:absolute; margin-left:30%; width: 600px !important; background: linear-gradient(to right, #CFD7FF 0%, #FFFFFF 49%);">
            <div class="row" style="text-align: center">
                <div class="col-6">
                    <h1 style="font-size: 47px; color: black;">Potentech</h1>
                </div>
                <div class="col-6">
                    <p style="font-size: 20px; color: gray; padding-left:10px; margin-top: 20px">Flexible Classroom</p>
                </div>
            </div>
        </div> -->
        <div v-if="iframeSrc">
            <div class="d-flex justify-content-center align-items-center potentech">
                <div class="text-center">
                    <h1 style="font-size:40px; font-family: fantasy; color: black;">Potentech Flexible Classroom</h1>
                </div>
            </div>
                <iframe class="custom-iframe w-100" :src="iframeSrc" frameborder="0"></iframe>
            </div>
        <div class="timer text-center">
            <h2 class="mt-4" style="font-family: fantasy; color: black;">TIMER: {{ formattedTime  }}</h2>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Whiteboard',

    data() {
        return {
            seconds: 0,
            timer: null,
            iframeSrc: null, // Data property to hold the iframe source
        };
    },

    computed: {
        formattedTime() {
            const minutes = Math.floor(this.seconds / 60);
            const remainingSeconds = this.seconds % 60;
            return `${minutes < 10 ? '0' : ''}${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
        },
    },
    methods: {
        createIframe() {
            // Logic to determine the iframe source
            let roomId = this.$router.currentRoute.value?.params?.roomId;
            axios.post('/api/check-if-exist', { roomId: roomId })
                .then(response => {
                    this.iframeSrc = 'https://whiteboard.ably.dev/?boardName='+response.data.roomId; // Set the iframe URL here
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
            
            console.log();
            // this.iframeSrc = 'https://whiteboard.ably.dev/?boardName='; // Set the iframe URL here
        },

        startTimer() {
            this.isRunning = true;
            this.timer = setInterval(() => {
                this.seconds++;
            }, 1000);
        },
        stopTimer() {
            clearInterval(this.timer);
            this.isRunning = false;
        },
    },
    beforeDestroy() {
        // Clean up the timer when the component is destroyed
        if (this.timer) {
            clearInterval(this.timer);
        }
    },

    mounted () {
        this.createIframe();
        this.startTimer();
    },
};
</script>

<style>
    .custom-iframe {
        height: 120vh !important;
    }
    .potentech {
        position: absolute; 
        margin-left: 30%; 
        width: 600px; 
        height: 100px; 
        background: linear-gradient(to right, #CFD7FF 0%, #FFFFFF 49%);
        border-radius: 2vh;
    }

    .timer {
        z-index: 999999 !important;
        position: absolute;
        margin-left: 2vh;
        top: 130vh;
        width: 300px;
        height: 100px;
        background: linear-gradient(to right, rgb(207, 215, 255) 0%, rgb(255, 255, 255) 49%);
        padding: 2vh;
        border-radius: 5vh;
    }
</style>
