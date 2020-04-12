<template>
    <div class="container">
         <div class="row">
          <div class="col-md-12 mt-3">
            <div class="card">             
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Staff Records
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
                      <th>Role</th>
                      <th>Address</th>
                      <th>Mobile</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="staf in staff" :key="staf.id">
                      <td>{{staf.name}} </td>
                      <td>{{staf.gender}}</td>
                      <td>{{staf.role}}</td>
                      <td>{{staf.address}}</td>
                      <td>{{staf.mobile}}</td>
                        <td>
                            <a href="#" @click="showModal(staf.id)">
                            <i class="fas fa-eye green"></i>
                            </a>
                            <a href="#" @click="editModal(staf.id)">
                            <i class="fas fa-edit blue"></i>
                            </a>
                            <a href="#" @click="deleteStaff(staf.id)">
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
        <div class="modal fade" id="showStaff" tabindex="-1" role="dialog"> 
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Staff {{specificStaff.surname}}</h5>
                    <p>{{specificStaff.firstName}} {{specificStaff.otherNames}}</p>
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
                    <h5 v-show="!editMode" class="modal-title">Add Staff</h5>
                    <h5 v-show="editMode" class="modal-title">Edit Staff Records</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateStaff() : createStaff()">
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
                            <label>Mobile</label>
                            <input v-model="form.mobile" type="text" name="mobile"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }">
                            <has-error :form="form" field="mobile"></has-error>
                        </div>               
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="form.email" type="email" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
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
                            <label>Address</label>
                            <textarea v-model="form.address" type="text" name="address"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('address') }"></textarea>
                            <has-error :form="form" field="address"></has-error>
                        </div>               
                        <div class="form-group">
                            <label>Role</label>
                            <input v-model="form.role" type="text" name="role"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                            <has-error :form="form" field="role"></has-error>
                        </div>                    
                    </div>                           
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="!editMode" type="submit" class="btn btn-primary">Add Staff to list</button>
                        <button v-show="editMode" type="submit" class="btn btn-primary">Edit Staff info</button>
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
          staff: {},
          specificStaff: {},
          form: new Form({
              id: '',
              surname: '',
              firstName: '',
              otherNames: '',
              email: '',
              gender: '',
              address: '',
              mobile: '',
              role: '',
          })
        }
    },
    methods:{
      loadStaff(){
          axios.get('http://127.0.0.1:8009/api/staff')
          .then(({ data }) => (this.staff = data.data) )
          .catch(e => console.log(e))
      },
            updateStaff(){
               this.form.put('http://127.0.0.1:8009/api/staff/'+this.form.id)
               .then(() => {
                    Swal.fire(
                    'Updated!',
                    'The Staff info has been updated.',
                    'success'
                    );
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
               })
               .catch(() => {
                   console.log("Somnething failed");
               })
            },
        async editModal(id){
           let response = await axios.get('http://127.0.0.1:8009/api/staff/'+id)
            .then( data => {
              this.editMode = true;
              this.form.reset();
              this.specificStaff = data.data
              this.form.fill(this.specificStaff);
              $('#addNew').modal('show');
              console.log(data.data);
            })
            .catch( e => console.log(e))
        },
        async showModal(id){
          let response = await axios.get('http://127.0.0.1:8009/api/staff/'+id)
            .then( data => {
              (this.specificStaff = data.data),
              $('#showStaff').modal('show')
              })
            .catch()
            // console.log("show full details of patients " + id);
        },
        newModal(){
            this.editMode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        createStaff(){
            // this.$Progress.start();
            this.form.post('http://127.0.0.1:8009/api/staff')
            .then(() => {
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')

                toast.fire({
                    icon: 'success',
                    title: 'Staff Created successfully'
                })
            //     this.$Progress.finish();
            })
            .catch((error) =>{
                console.log(error);
            })
        },
        updateStaff(){
            this.form.patch('http://127.0.0.1:8009/api/staff/'+this.form.id)
            .then((data) => {
              console.log(data);
                Swal.fire(
                'Updated!',
                'The Staff info has been updated.',
                'success'
                );
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide');
            })
            .catch((e) => {
                console.log(e);
            })
        },
        deleteStaff(id){
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
                    this.form.delete('http://127.0.0.1:8009/api/staff/'+id)
                    .then(()=>{
                            Swal.fire(
                            'Deleted!',
                            'The Staff records have been deleted.',
                            'success'
                            );
                    Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        swal("Failed!", "Staff not deleted, something went wrong.", "warning");
                    })
                    }
                })
        },

    },
        created(){
            Fire.$on('AfterCreate', () => {
                this.loadStaff();
            });
           // setInterval(() => this.loadStaff(), 3000);
        },
        mounted() {
          this.loadStaff()
            // console.log('Component mounted.')
        }
    }
</script>