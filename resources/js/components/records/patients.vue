<template>
    <div class="container">
         <div class="row">
          <div class="col-md-12 mt-3">
            <div class="card">             
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  List of Patients
                </h3>
                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal" >Add New <i class="fa fa-user-plus"></i></button>
                </div>
              </div><!-- /.card-header -->
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead> 
                    <tr>
                      <th>Name</th>
                      <th>Gender</th>
                      <th>Age</th>
                      <th>Address</th>
                      <th>Mobile</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="patient in patients" :key="patient.id">
                      <td>{{patient.name}} </td>
                      <td>{{patient.gender}}</td>
                      <td>{{patient.age}}</td>
                      <td>{{patient.address}}</td>
                      <td>{{patient.mobile}}</td>
                        <td>
                            <a href="#" @click="showModal(patient.id)">
                            <i class="fas fa-eye green"></i>
                            </a>
                            <a href="#" @click="editModal(patient.id)">
                            <i class="fas fa-edit blue"></i>
                            </a>
                            <a href="#" @click="deletePatient(patient.id)">
                            <i class="fas fa-trash red"></i>
                            </a>
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <div class="modal fade" id="showPatient" tabindex="-1" role="dialog"> 
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Patient {{specificPatient.surname}}</h5>
                    <p>{{specificPatient.firstName}} {{specificPatient.otherNames}}</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                </div>
            </div>
        </div>


        <div class="modal fade" id="addNew" tabindex="-1" role="dialog"> 
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editMode" class="modal-title">Add Patient</h5>
                    <h5 v-show="editMode" class="modal-title">Edit Patient</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updatePatient() : createPatient()">
                    <div class="modal-body">               
                        <div class="form-group">
                            <label>Surname</label>
                            <input v-model="form.surname" type="text" name="surname"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('surname') }">
                            <has-error :form="form" field="surname"></has-error>
                        </div>               
                        <div class="form-group">
                            <label>First Name</label>
                            <input v-model="form.firstName" type="text" name="firstName"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('firstName') }">
                            <has-error :form="form" field="firstName"></has-error>
                        </div>               
                        <div class="form-group">
                            <label>Other Names</label>
                            <input v-model="form.otherNames" type="text" name="otherNames"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('otherNames') }">
                            <has-error :form="form" field="otherNames"></has-error>
                        </div>               
                        <div class="form-group">
                        <label>Gender</label>
                        <select v-model="form.gender" name="gender"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('gender') }">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <has-error :form="form" field="gender"></has-error>
                        </div>               
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input v-model="form.dob" type="date" name="dob"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('dob') }">
                            <has-error :form="form" field="dob"></has-error>
                        </div>               
                        <div class="form-group">
                            <label>Address</label>
                            <textarea v-model="form.address" type="text" name="address"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('address') }"></textarea>
                            <has-error :form="form" field="address"></has-error>
                        </div>               
                        <div class="form-group">
                            <label>Origin </label>
                            <input v-model="form.origin" type="text" name="origin"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('origin') }">
                            <has-error :form="form" field="origin"></has-error>
                        </div>               
                        <div class="form-group">
                            <label>Mobile</label>
                            <input v-model="form.mobile" type="text" name="mobile"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }">
                            <has-error :form="form" field="mobile"></has-error>
                        </div>               
                        <div class="form-group">
                            <label>Next of Kin</label>
                            <input v-model="form.kinName" type="text" name="kinName"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('kinName') }">
                            <has-error :form="form" field="kinName"></has-error>
                        </div>           
                        <div class="form-group">
                            <label>Next of Kin;s phone no.</label>
                            <input v-model="form.kinMobile" type="text" name="kinMobile"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('kinMobile') }">
                            <has-error :form="form" field="kinMobile"></has-error>
                        </div>                    
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea v-model="form.kinAddress" type="text" name="otherNames"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('otherNames') }"></textarea>
                        <has-error :form="form" field="otherNames"></has-error>
                    </div>     
                    <div class="form-group">
                    <label>Registration Type</label>
                    <select v-model="form.registration_type" name="registration_type"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('registration_type') }">
                        <option value="">Select Registeration</option>
                        <option value="individual">Individual</option>
                        <option value="family">Family</option>
                    </select>
                    <has-error :form="form" field="registration_type"></has-error>
                    </div>                         
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="!editMode" type="submit" class="btn btn-primary">Add Patient to list</button>
                        <button v-show="editMode" type="submit" class="btn btn-primary">Edit Patient info</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
      data(){
        return {
          editMode: false,
          patients: {},
          specificPatient: {},
          testPatient: {},
          form: new Form({
              id: '',
              surname: '',
              firstName: '',
              otherNames: '',
              gender: '',
              dob: '',
              address: '',
              origin: '',
              mobile: '',
              kinName: '',
              kinAddress: '',
              kinMobile: '',
              registration_type: '',            
          })
        }
    },
    methods:{
      loadPatients(){
          axios.get('http://127.0.0.1:8009/api/patients')
          .then(({ data }) => (this.patients = data.data) )
          .catch(e => console.log(e))
      },
      loadPatient(id){
            axios.get('http://127.0.0.1:8009/api/patients/'+id)
            .then( ({response}) => {(
              this.specificPatient = response,
              console.log(response) )
            })
      },
            updatePatient(){
               this.form.put('http://127.0.0.1:8009/api/patients/'+this.form.id)
               .then(() => {
                    Swal.fire(
                    'Updated!',
                    'The Patient info has been updated.',
                    'success'
                    );
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
               })
               .catch(() => {
                   console.log("Somnething failed");
               })
            },
        editModal(id){
            axios.get('http://127.0.0.1:8009/api/patients/'+id)
            .then( data => {
              this.editMode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.specificPatient = data.data
              this.form.fill(this.specificPatient);
            })
        },
        showModal(id){
            axios.get('http://127.0.0.1:8009/api/patients/'+id)
            .then( data => (this.specificPatient = data.data),
            $('#showPatient').modal('show'))
            .catch()
            // console.log("show full details of patients " + id);
        },
        newModal(){
            this.editMode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        createPatient(){
            // this.$Progress.start();
            this.form.post('http://127.0.0.1:8009/api/patients')
            .then(() => {
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')

                toast.fire({
                    icon: 'success',
                    title: 'Patient Created successfully'
                })
            //     this.$Progress.finish();
            })
            .catch((error) =>{
                console.log(error);
            })
        },
        updatePatient(){
            this.form.put('http://127.0.0.1:8009/api/patients/'+this.form.id)
            .then(() => {
                Swal.fire(
                'Updated!',
                'The Patient info has been updated.',
                'success'
                );
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide');
            })
            .catch((e) => {
                console.log(e);
            })
        },
        deletePatient(id){
          console.log(id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    //send request server to delete
                    if (result.value) {
                    this.form.delete('http://127.0.0.1:8009/api/patients/'+id)
                    .then(()=>{
                            Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                            );
                    Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        swal("Failed!", "Patient not deleted, something went wrong.", "warning");
                    })
                    }
                })
        },

    },
        created(){
            // this.loadPatients();
            Fire.$on('AfterCreate', () => {
                this.loadPatients();
            });
           // setInterval(() => this.loadPatients(), 3000);
        },
        mounted() {
          this.loadPatients()
            console.log('Component mounted.')
        }
    }
</script>
