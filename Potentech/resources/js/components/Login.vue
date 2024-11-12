<template>
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center" style="background: linear-gradient(to right, #CFD7FF 0%, #FFFFFF 49%);">
        <div class="row" style="margin: 10px">
            <div class="col-6">
                <h1 style="font-size: 47px; color: black;">Potentech</h1>
            </div>
            <div class="col-6">
                <p style="font-size: 20px; color: gray; padding-left:10px; padding-top: 20px">Flexible Classroom</p>
            </div>
        </div>
        <button class="btn btn-primary" style="margin-right: 40px"><router-link :to="{name:'register'}" class="nav-link">Sign Up</router-link></button>
    </div>
    <div class="container">
    
        <!-- Main Content Section -->
        <div class="row" style="margin-top: 12%">
            <!-- Left Part: Login Form -->
            <div class="col-6">
                <h2 style="font-family: 'Inter', sans-serif; font-weight: bold; font-size: 30px;" class="text-center">Login</h2>
                <form action="javascript:void(0)" class="row" method="post">
                    <div class="col-12" v-if="Object.keys(validationErrors).length > 0">
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <li v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="email" class="font-weight-bold">Email</label>
                        <input type="text" v-model="auth.email" name="email" id="email" class="form-control">
                    </div>
                    <div class="form-group col-12 my-2 mb-3">
                        <label for="password" class="font-weight-bold">Password</label>
                        <input type="password" v-model="auth.password" name="password" id="password" class="form-control">
                    </div>
                    <div class="col-12 mb-2">
                        <button type="submit" :disabled="processing" @click="login" class="btn btn-primary btn-block form-control">
                            {{ processing ? "Please wait" : "Login" }}
                        </button>
                    </div>
                    <div class="col-12 text-center">
                        <label>Don't have an account? <router-link :to="{name:'register'}">Register Now!</router-link></label>
                    </div>
                </form>
            </div>
            <!-- Right Part: Empty Space -->
            <div class="col-6" style="height: 100%;"></div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    name:"login",
    data(){
        return {
            auth:{
                email:"",
                password:""
            },
            validationErrors:{},
            processing:false
        }
    },
    methods:{
        ...mapActions({
            signIn:'auth/login'
        }),
        async login(){
            this.processing = true
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/login',this.auth).then(({data})=>{
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
    }
}
</script>