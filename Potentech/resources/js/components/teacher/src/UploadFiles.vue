<template>
    <div class="d-flex justify-content-center mt-5 mb-5">
        <div class="card shadow-sm centered-card">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Select File to Upload</h5>
                <div class="mb-3">
                    <label for="formFileSm" class="form-label">Choose a file</label>
                    <input class="form-control form-control-sm" id="formFileSm" type="file" @change="onFileChange"/>
                </div>
                <button @click="uploadFile" class="btn btn-primary w-100">Upload</button>
                <div v-if="message" class="alert alert-info mt-3">{{ message }}</div>
            </div>

            <div v-if="files.length" class="m-3">
                <h6>Uploaded Files</h6>
                <ul>
                    <li v-for="file in files" :key="file.id">
                        {{ file.filename }} <a :href="`/api/download/${file.id}`" target="_blank">Download</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            selectedFile: null,
            files: [],
            message: '',
        };
    },

    methods: {
        onFileChange(event) {
            this.selectedFile = event.target.files[0];
        },

        async uploadFile() {
            if (!this.selectedFile) {
                this.message = 'Please select a file.';
                return;
            }

            const formData = new FormData();
            formData.append('file', this.selectedFile);

            try {
                await axios.post('/api/upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                this.message = 'File uploaded successfully.';
                this.fetchFiles(); // Refresh the file list after upload
            } catch (error) {
                this.message = 'Error uploading file.';
                console.error(error);
            }
        },

        async fetchFiles() {
            const response = await axios.get('/api/files');
            console.log(response);
            
            this.files = response.data;
        },
    },

    mounted() {
        this.fetchFiles();
    },
};
</script>

<style scoped>
.centered-card {
    width: 100%; /* Full width on small screens */
    max-width: 400px; /* Max width for larger screens */
}

.mt-5 {
    margin-top: 50px; /* Adds margin at the top */
}

.mb-5 {
    margin-bottom: 50px; /* Adds margin at the bottom */
}

.alert {
    margin-top: 15px; /* Space between the button and message */
}
</style>
