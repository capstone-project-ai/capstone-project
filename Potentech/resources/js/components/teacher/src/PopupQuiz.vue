<template>
    <div class="container mt-4">
        <h2>{{ user.role_id === 2 ? 'Create a Quiz' : 'Take the Quiz' }}</h2>
        
        <div v-if="user.role_id === 2">
            <div class="form-group">
                <label for="quizTitle">Quiz Title</label>
                <input type="text" id="quizTitle" v-model="quizTitle" class="form-control" />
            </div>

            <div class="form-group">
                <label for="questionType">Select Question Type</label>
                <select v-model="questionType" id="questionType" class="form-control">
                    <option value="fill-in-the-blank">Fill in the Blanks</option>
                    <option value="multiple-choice">Multiple Choice</option>
                    <option value="essay">Essay</option>
                </select>
            </div>
        
            <div v-if="questionType === 'fill-in-the-blank'" class="mt-3">
                <div class="form-group">
                    <label for="fillQuestion">Question</label>
                    <textarea id="fillQuestion" v-model="fillQuestion" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="fillAnswer">Answer</label>
                    <input type="text" id="fillAnswer" v-model="correctAnswer" class="form-control" />
                </div>
            </div>
        
            <div v-if="questionType === 'multiple-choice'" class="mt-3">
                <div class="form-group">
                    <label for="multiQuestion">Question</label>
                    <textarea id="multiQuestion" v-model="fillQuestion" class="form-control" rows="3"></textarea>
                </div>
                <label>Options:</label>
                <div v-for="(option, index) in options" :key="index" class="form-group d-flex align-items-center mb-2">
                    <input type="text" v-model="options[index]" class="form-control me-2" />
                    <button @click="removeOption(index)" class="btn btn-danger btn-sm">Remove</button>
                </div>
                <div class="form-group">
                    <label for="multiQuestion">Correct Answer</label>
                    <input 
                        type="text" 
                        v-model="correctAnswer" 
                        placeholder="Please fill the correct answer based on selected option" 
                        class="form-control me-2" 
                    />
                </div>
                <button @click="addOption" class="btn btn-secondary">Add Option</button>
            </div>
        
            <div v-if="questionType === 'essay'" class="mt-3">
                <div class="form-group">
                    <label for="essayQuestion">Question</label>
                    <textarea id="essayQuestion" v-model="fillQuestion" class="form-control" rows="3"></textarea>
                </div>
            </div>
        
            <button @click="submitQuiz" class="btn btn-primary mt-3">Submit Question</button>
        </div>
        
        <div v-else>
            <h4>Your Quiz</h4>
            <div v-for="(question, index) in questions" :key="index" class="mt-3">
                <p>{{ question.content.question }}</p>
                <div v-if="question.type === 'multiple-choice'">
                    <div v-for="(option, idx) in question.content.options" :key="idx" class="form-check">
                    <input type="radio" :value="option" v-model="userAnswers[question.id]" class="form-check-input" :id="'option' + index + idx">
                    <label class="form-check-label" :for="'option' + index + idx">{{ option }}</label>
                    </div>
                </div>

                <div v-if="question.type === 'fill-in-the-blank'">
                    <input type="text" v-model="userAnswers[question.id]" class="form-control" placeholder="Your answer" />
                </div>

                <div v-if="question.type === 'essay'">
                    <textarea v-model="userAnswers[question.id]" class="form-control" rows="3" placeholder="Your answer"></textarea>
                </div>
            </div>
            <div v-if="totalPoints > 0" class="mt-3">
                <h5>Your Points: {{ totalPoints }}</h5>
            </div>
            <button @click="submitAnswers" class="btn btn-success mt-3">Submit Answers</button>
        </div>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            user: this.$store.state.auth.user,
            options: ['', ''], 
            quizTitle: '',
            questionType: "",
            fillQuestion: "",
            correctAnswer: "",
            questions: [
                { id: 1, type: 'fill-in-the-blank', content: { question: '', answer: '' } },
                { id: 2, type: 'multiple-choice', content: { question: '', options: ['', ''] } },
                { id: 3, type: 'essay', content: { question: '' } },
            ],
            userAnswers: {},
            totalPoints: 0,
            roomId: this.$router.currentRoute.value?.params?.roomId,
        };
    },
    methods: {
        updateQuestionType(index) {
            this.$set(this.questions[index], 'content', this.getDefaultContent(this.questions[index].type));
        },

        getDefaultContent(type) {
            switch (type) {
                case 'fill-in-the-blank':
                    return { question: '', answer: '' };
                case 'multiple-choice':
                    return { question: '', options: ['', ''] };
                case 'essay':
                    return { question: '' };
            }
        },

        async submitQuiz() {

            const quizData = {
                title: this.quizTitle,
                questionType: this.questionType,
                question: this.fillQuestion,
                correctAnswer: this.correctAnswer,
                options: this.options,
                roomId: this.roomId,
            };

            try {
                await axios.post('/api/quizzes', quizData)
                .then(response => {
                    console.log(response);
                    
                    alert(response.data.message);
                })
                .catch(error => {
                    console.error(error.response);
                    if (error.response && error.response.data.error) {
                        this.errorMessage = error.response.data.error; // Set the error message
                    } else {
                        this.errorMessage = 'An unexpected error occurred.'; // Fallback error message
                    }
                    alert("Error submitting quiz");
                });
            } catch (error) {
                console.error('Error submitting quiz:', error);
            }
        },

        async submitAnswers() {
            const answersData = {
                answers: this.userAnswers,
            };

            try {
                const response = await axios.post(`/api/quizzes/${this.quizId}/answers`, answersData);
                this.totalPoints += response.data.points;
                console.log('Submitted Answers:', response.data);
            } catch (error) {
                console.error('Error submitting answers:', error);
            }
        },

        addOption() {
            if (this.options.length < 4) {
                this.options.push('');
            }
        },
        removeOption(index) {
            if (this.options.length > 2) {
                this.options.splice(index, 1);
            }
        },
    }
};
</script>

<style scoped>
/* Add any additional styling here if needed */
</style>
  