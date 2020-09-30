<template>
    <div class="container container-task">
        <div class="row">
           <div class="col-md-6">
                <h2>Buscar disponibilidad</h2>
                <div class="form-group">
                    <input v-model="id" type="hidden">
                    <input v-model="room_id" type="hidden">
                    <label>Checkin</label>
                    <input v-model="checkin" type="date" :min='minDate' class="form-control" required>

                    <label>Checkout</label>
                    <input v-model="checkout" type="date" :min='minDate' class="form-control" required>

                    <label>Tipo</label>
                    <select v-model="type_id" class="form-control" required>
                        <option value="1" >Single</option>
                        <option value="2" >Double</option>
                        <option value="3" >Familiar</option>
                    </select>
                </div>
                <div class="container-buttons">
                    <button v-if="update == 0" @click="searchBookings()" class="btn btn-success float-right">Buscar</button>
                    <button v-if="update != 0" @click="updateBookings()" class="btn btn-warning float-right">Modificar</button>
                    <button v-if="update != 0" @click="clearFields()" class="btn float-right">Atrás</button>
                </div>
            </div>

         <div class="col-md-6">
                <h2>Habitaciones Disponibles</h2>
                <table class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col">N° Habitación</th>
                                <th scope="col">Checkin</th>
                                <th scope="col">Checkout</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="booking in arrayAvailables" :key="booking.id">
                                <td v-text="booking.room_id"></td>
                                <td v-text="booking.checkin = checkin"></td>
                                <td v-text="booking.checkout = checkout"></td>
                                <td v-text="booking.type_name"></td>
                                <td>
                                    <button class="btn btn-primary" @click="saveBooking(booking)">Reservar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </div>


        <div class="col-md-12">
                <h2>Habitaciones Reservadas</h2>
                <table class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col">N° Habitación</th>
                                <th scope="col">Checkin</th>
                                <th scope="col">Checkout</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="booking in arrayBookings" :key="booking.id"> 
                                <td v-text="booking.room_id"></td>
                                <td v-text="booking.checkin"></td>
                                <td v-text="booking.checkout"></td>
                                <td v-text="booking.type_name"></td>
                                <td>
                                    <button class="btn" @click="loadFieldsUpdate(booking)">Modificar</button>
                                    <button class="btn" @click="deleteBooking(booking)">Borrar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>

    </div>
</template>

<script>
    export default {
        data(){
            return{
                id:"",
                checkin:"",
                checkout:"",
                room_id:"",
                type_id:'',
                update:0, 
                arrayBookings:[],
                arrayAvailables:[],
                minDate : new Date().toISOString().slice(0,10)
            }
        },
        methods:{
            getBookings(){
                let url = 'api/';
                let obj = this;
                axios.get(url).then(function (response) {
                    obj.arrayBookings = response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            searchBookings(){
                let url = 'api/room/availability/'+this.type_id+"/"+this.checkin+"/"+this.checkout;
                let obj = this;
                axios.get(url).then(function (response) {
                    obj.arrayAvailables = response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            saveBooking(booking){
                let url = 'api/room/reservation';
                let obj = this;
                axios.post(url,{ 
                    'checkin':booking.checkin,
                    'checkout':booking.checkout,
                    'room_id':booking.room_id,
                }).then(function (response) {
                    obj.getBookings();
                    obj.clearFields();
                    obj.arrayAvailables = [];
                })
                .catch(function (error) {
                    console.log(error);
                });   
                
            },
            updateBookings(){
                let obj = this;
                axios.put('/api/room/reservation',{
                    'id':this.id,
                    'room_id':  this.room_id,
                    'type_id':  this.type_id,
                    'checkin':  this.checkin,
                    'checkout': this.checkout
                }).then(function (response) {
                   obj.getBookings();
                   obj.clearFields();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(data){ 
                this.update = data.id
                this.id = data.id;
                this.room_id= data.room_id;
                this.checkin= data.checkin;
                this.checkout= data.checkout;
                this.type_id= data.type_id;
            },
            deleteBooking(data){
                let id = data.id;
                let url = '/api/room/reservation/';
                let obj = this;
                if (confirm('¿Seguro que deseas borrar la reservacion?')) {
                    axios.delete(url,{
                        params: {
                                    'id': id
                                }   
                        }
                    ).then(function (response) {
                        obj.getBookings();
                    })
                    .catch(function (error) {
                        console.log(error);
                    }); 
                }
            },
            clearFields(){
                this.id = "";
                this.room_id = "";
                this.checkin = "";
                this.checkout = "";
                this.type_id = "";
                this.update = 0;
            }
        },
        mounted() {
           this.getBookings();
        }
    }
</script>
