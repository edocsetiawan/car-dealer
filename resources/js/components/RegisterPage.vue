<template>
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form @submit.prevent="registerUser">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="name" class="form-control" v-model="parameter.name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" v-model="parameter.email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" v-model="parameter.password">
                        </div>
                        <div class="form-group">
                            <label for="name">Confrim Password</label>
                            <input type="password" class="form-control" v-model="parameter.confirm_password">
                        </div>
                        <button type="submit" class="btn btn-primary" style="background-color:green;border-color:green">Register</button>
                    </form>
                    <button class="btn btn-primary" style="float:right;margin-top:-38px;background-color:red;border-color:red" @click="cancel()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            parameter :{
                name : '',
                password : '',
                email : '',
                confirm_password : ''
            }
        }
    },
    methods :{
        cancel : function () {
            this.$router.push({name: 'login'});
        },
        registerUser (){
            if(this.parameter.name === ''){
                alert("Please fill name!");
            }else if(this.parameter.password === '' || this.parameter.confirm_password === ''){
                alert("Please fill password!");
            }else if(this.parameter.email === ''){
                alert("Please fill password!");
            }else{
                if(this.parameter.password !== this.parameter.confirm_password){
                    alert("Please check your password & confirm password!");
                }else{
                    let url = `/api/register`;
                    this.axios.post(url,this.parameter).then((response)=>{
                        if(response.data.success){
                            alert("Welcome : "+this.parameter.name+"Please login access menu");
                            this.$router.push({name: 'login'});
                        }else{
                            alert("something went wrong");
                        }
                    });
                } 
            }
        }
    }
}
</script>