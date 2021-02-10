<template>
    <div>
    <div class="row justify-content-md-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header">Dashboard</div>
        <div class="card-body">
                <label for="name">Hello : </label> {{user.name}}
                <button type="submit" class="btn btn-primary" style="background-color : red !important;border-color : red !important;float:right" @click="logout()">LOGOUT</button>
                <button type="submit" class="btn btn-primary" style="background-color : blue !important;border-color : blue !important;float : right; margin-right:10px;" @click="newCar()">ADD CAR</button>
                <button type="submit" class="btn btn-primary" style="background-color : blue !important;border-color : blue !important;float : right; margin-right:10px;" @click="newTransaction()">ADD TRANSACTION</button>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width:50%">DATA HARI INI</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mobil paling banyak dijual</td>
                        <td>{{today_data.car_name}}</td>
                    </tr>
                    <tr>
                        <td>Penjualan Hari ini </td>
                        <td>{{today_data.qty}}</td>
                    </tr>
                    <tr>
                        <td>Total penjualan hari ini</td>
                        <td>{{today_data.total}}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width:50%">DATA 7 MINGGU TERAKHIR</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mobil paling banyak dijual</td>
                        <td>{{last_7_days.car_name}}</td>
                    </tr>
                    <tr>
                        <td>Penjualan 7 hari terakhir </td>
                        <td>{{last_7_days.qty}}</td>
                    </tr>
                    <tr>
                        <td>Total penjualan 7 hari terakhir</td>
                        <td>{{last_7_days.total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            token : '',
            user : [],
            today_data  : [],
            last_7_days : [],
        }
    },
    mounted(){
        this.init();
    },
    methods :{
        init : function(){
            if(localStorage.getItem('token') == null){
                alert("Please login first!");
                this.$router.push({name: 'login'});
            }else{
                let url = `/api/getme`;
                this.axios.get(url,{
                    headers : {
                        'Authorization': 'Bearer '+localStorage.getItem('token')
                    }
                }).then((response) => {
                if(response.data.success){
                    this.user = response.data.data.data;
                    this.today_data = response.data.data.today_transaction;
                    this.last_7_days = response.data.data.last_7_days;
                }else{
                    alert("something went wrong");
                }
            });
            }

        },
        logout : function(){
            if(confirm("Do you really want to leave?")){
                localStorage.removeItem('token');
                alert("See you!");
                this.$router.push({name: 'login'});
            }
        },
        newCar : function() {
            this.$router.push({name: 'car'});
        },
        newTransaction : function(){
            this.$router.push({name: 'transaction'});
        }
    }
}
</script>