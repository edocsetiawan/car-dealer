<template>
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">New Car</div>
                <div class="card-body">
                    <form @submit.prevent="registerTransaction">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="name" class="form-control" v-model="parameter.name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" v-model="parameter.email">
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="name" class="form-control" v-model="parameter.phone_number">
                        </div>
                        <div class="form-group">
                            <select v-model="parameter.car_id">
                            <option v-for="product in products" v-bind:value="product.id">
                                {{ product.car_name }}
                            </option>
                        </select>
                        </div>
                        <div class="form-group">
                            <label for="password">qty</label>
                            <input type="number" class="form-control" v-model="parameter.qty">
                        </div>
                        <button type="submit" class="btn btn-primary" style="background-color:blue;border-color:blue">Submit</button>
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
                email : '',
                phone_number : '',
                car_id : '',
                qty : ''
            },
            products : []
        }
    },
    mounted(){
        this.init();
    },
    methods :{
        cancel : function () {
            this.$router.push({name: 'landingpage'});
        },
        registerTransaction (){
            if(this.parameter.name === ''){
                alert("Please fill name!");
            }else if(this.parameter.email === ''){
                alert("Please fill price!");
            }else if(this.parameter.phone_number === ''){
                alert("Please fill qty!");
            }else if(this.parameter.qty === ''){
                alert("Please fill qty!");
            }
            else{
                let url = `/api/add-new-transaction`;
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
        },
        init (){
                let url = `/api/get-stock-data`;
                this.axios.get(url,{
                    headers : {
                        'Authorization': 'Bearer '+localStorage.getItem('token')
                    }
                }).then((response) => {
                if(response.data.success){
                    this.products = response.data.data;
                }else{
                    alert("something went wrong");
                }
            }); 
        }
    }
}
</script>