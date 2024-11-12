<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <button type="button" class="btn btn-secondary me-3" @click="goBack">
                                <i class="fa-solid fa-arrow-left"></i>
                            </button>
                            <h1 class="card-title flex-grow-1 text-center">Register</h1>
                        </div>
                        <hr/>
                        <form action="javascript:void(0)" @submit="register" class="row" method="post">
                            <div class="col-12" v-if="Object.keys(validationErrors).length > 0">
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <li v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="name" class="font-weight-bold">Name</label>
                                <input type="text" name="name" v-model="user.name" id="name" placeholder="Enter name" class="form-control">
                            </div>
                            <div class="form-group col-12 my-2">
                                <label for="email" class="font-weight-bold">Email</label>
                                <input type="text" name="email" v-model="user.email" id="email" placeholder="Enter Email" class="form-control">
                            </div>
                            <div class="form-group col-12 my-2">
                                <label for="password" class="font-weight-bold">Password</label>
                                <div class="password-container">
                                    <input
                                        name="password"
                                        id="password"
                                        :type="passwordVisible ? 'text' : 'password'"
                                        v-model="user.password"
                                        placeholder="Enter your password"
                                        class="form-control"
                                    />
                                    <i :class="passwordVisible ? 'fas fa-eye-slash' : 'fas fa-eye'" @click="togglePassword" style="margin-left: -25px !important;"></i>
                                </div>
                            </div>
                            <div class="form-group col-12 my-2">
                                <label for="password_confirmation" class="font-weight-bold">Confirm Password</label>
                                <div class="password-container">
                                    <input
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        :type="passwordConfirmVisible ? 'text' : 'password'"
                                        v-model="user.password_confirmation"
                                        placeholder="Enter your password"
                                        class="form-control"
                                    />
                                    <i :class="passwordConfirmVisible ? 'fas fa-eye-slash' : 'fas fa-eye'" @click="togglePasswordConfirm" style="margin-left: -25px !important;"></i>
                                </div>
                            </div>
                            <div class="form-group col-12 my-2">
                                <label for="password_confirmation" class="font-weight-bold">Role</label>
                                <select id="role_id" name="role_id" v-model="user.role_id" class="form-control">
                                    <option value=null disabled selected class="d-none">Choose Role</option>
                                    <option value="1">Student</option>
                                    <option value="2">Teacher</option>
                                </select>
                            </div>
                            <div class="form-group col-12 my-2">
                                <button type="submit" :disabled="processing" class="btn btn-primary btn-block form-control">
                                {{ processing ? "Please wait" : "Register" }}
                                </button>
                            </div>
                            <div class="col-12 text-center">
                                <label>Already have an account? <router-link :to="{name:'login'}">Login Now!</router-link></label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    name:'register',
    data(){
        return {
            user:{
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
                role_id: null,
            },
            validationErrors:{},
            processing:false,
            passwordVisible: false,
            passwordConfirmVisible: false,
        }
    },
    methods:{
        ...mapActions({
            signIn:'auth/login'
        }),
        async register(){
            this.processing = true
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/register',this.user).then(response=>{
                this.validationErrors = {}
                this.signIn()
            }).catch(({response})=>{
                if(response.status===422){
                    this.validationErrors = response.data.errors
                }else{
                    this.validationErrors = {}
                    alert(response.data.message)
                }
            }).finally(()=>{
                this.processing = false
            })
        },

        togglePassword() {
            this.passwordVisible = !this.passwordVisible;
        },

        togglePasswordConfirm() {
            this.passwordConfirmVisible = !this.passwordConfirmVisible;
        },
        goBack() {
            window.location.href = "/login";
        },
    }
}
</script>
<style scoped>
.password-container {
  position: relative;
  display: flex;
  align-items: center;
}

input[type="text"],
input[type="password"] {
  padding-right: 40px; /* Adjust based on the icon size */
}
.flex-grow-1 {
    flex-grow: 0.85 !important;
}
</style>