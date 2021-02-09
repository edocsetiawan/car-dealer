<template>
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">New Car</div>
                <div class="card-body">
                    <form @submit.prevent="registerCar">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="name" class="form-control" v-model="parameter.car_name">
                        </div>
                        <div class="form-group">
                            <label for="email">Price</label>
                            <input type="number" class="form-control" v-model="parameter.price">
                        </div>
                        <div class="form-group">
                            <label for="password">qty</label>
                            <input type="number" class="form-control" v-model="parameter.stock">
                        </div>
                        <button type="submit" class="btn btn-primary" style="background-color:blue;border-color:blue">Register</button>
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
                car_name : '',
                price : '',
                stock : '',
            }
        }
    },
    methods :{
        cancel : function () {
            this.$router.push({name: 'landingpage'});
        },
        registerCar (){
            if(this.parameter.name === ''){
                alert("Please fill name!");
            }else if(this.parameter.price === ''){
                alert("Please fill price!");
            }else if(this.parameter.stock === ''){
                alert("Please fill stock!");
            }else{
                let url = `/api/add-new-stock`;
                this.axios.post(url,this.parameter,{
                    headers :{
                        'Authorization': 'Bearer '+localStorage.getItem('token')
                    }
                }).then((response)=>{
                    if(response.data.success){
                        alert("Success");
                        this.$router.push({name: 'landingpage'});
                    }else{
                        alert("Something went wrong");
                    }
                })
                 
            }
        }
    }
}
</script>