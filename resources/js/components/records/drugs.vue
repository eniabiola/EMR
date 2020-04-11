<template>
    <div class="container">
         <div class="row">
          <div class="col-md-12 mt-3">
            <div class="card">             
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  List of drugs
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
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Code</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="drug in drugs" :key="drug.id">
                      <td>{{drug.id}}</td>
                      <td>{{drug.name}}</td>
                      <td>{{drug.description}}</td>
                      <td>{{drug.code}}</td>
                        <td>
                            <a href="#" @click="editModal(drug)">
                            <i class="fas fa-edit blue"></i>
                            </a>
                            <a href="#" @click="deleteDrug(drug.id)">
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
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog"> 
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editMode" class="modal-title">Create User</h5>
                    <h5 v-show="editMode" class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateDrug() : createDrug()">
                    <div class="modal-body">               
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>               
                        <div class="form-group">
                            <label>Description</label>
                            <textarea v-model="form.description" name="description"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                            <has-error :form="form" field="description"></has-error>
                        </div>                    
                        <div class="form-group">
                            <label>Code</label>
                            <input v-model="form.code" type="text" name="code"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('code') }">
                            <has-error :form="form" field="code"></has-error>
                        </div>                 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="!editMode" type="submit" class="btn btn-primary">Add Drug to list</button>
                        <button v-show="editMode" type="submit" class="btn btn-primary">Edit Drug info</button>
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
          drugs: {},
          form: new Form({
              id: '',
              name: '',
              description: '',
              code: ''            
          })
        }
    },
    methods:{
      loadDrugs(){
          axios.get('http://127.0.0.1:8009/api/drugs')
          .then(({ data }) => (this.drugs = data.data,
            console.log(data)))
          .catch(e => console.log(e))
      },
            updateDrug(){
              //  this.form.put('api/user/'+this.form.id)
              //  .then(() => {
                    Swal.fire(
                    'Updated!',
                    'The user info has been updated.',
                    'success'
                    );
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
              //  })
              //  .catch(() => {
              //      console.log("Somnething failed");
              //  })
            },
        editModal(user){
            this.editMode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(user);
        },
        newModal(){
            this.editMode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        createDrug(){
            // this.$Progress.start();
            this.form.post('http://127.0.0.1:8009/api/drugs')
            .then(() => {
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')

                toast.fire({
                    icon: 'success',
                    title: 'User Created successfully'
                })
            //     this.$Progress.finish();
            })
            .catch((error) =>{
                console.log(error);
            })
        },
        updateDrug(){
            this.form.put('http://127.0.0.1:8009/api/drugs/'+this.form.id)
            .then(() => {
                Swal.fire(
                'Updated!',
                'The drug info has been updated.',
                'success'
                );
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide');
            })
            .catch(() => {
                console.log("Somnething failed");
            })
        },
        deleteDrug(id){
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
                    this.form.delete('http://127.0.0.1:8009/api/drugs/'+id)
                    .then(()=>{
                            Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                            );
                    Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        swal("Failed!", "Drug not deleted, something went wrong.", "warning");
                    })
                    }
                })
        },

    },
        created(){
            // this.loadUsers();
            Fire.$on('AfterCreate', () => {
                this.loadDrugs();
            });
           // setInterval(() => this.loadUsers(), 3000);
        },
        mounted() {
          this.loadDrugs()
            console.log('Component mounted.')
        }
    }
</script>
