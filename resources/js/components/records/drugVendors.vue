<template>
    <div class="container">
         <div class="row">
          <div class="col-md-12 mt-3">
            <div class="card">             
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Drug Vendor Records
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
                      <th>Address</th>
                      <th>Alias</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in items" :key="item.id">
                      <td>{{item.name}} </td>
                      <td>{{item.address}}</td>
                      <td>{{item.alias}}</td>
                        <td>
                            <a href="#" @click="editModal(item)">
                            <i class="fas fa-edit blue"></i>
                            </a>
                            <a href="#" @click="deleteItem(item.id)">
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
                    <h5 v-show="!editMode" class="modal-title">Add Vendor</h5>
                    <h5 v-show="editMode" class="modal-title">Edit Vendor Records</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateItem() : createItem()">
                    <div class="modal-body">               
                        <div class="form-group">
                            <label>name</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>                   
                        <div class="form-group">
                            <label>Address</label>
                            <textarea v-model="form.address" type="text" name="address"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('address') }"></textarea>
                            <has-error :form="form" field="address"></has-error>
                        </div>               
                        <div class="form-group">
                            <label>Alias</label>
                            <input v-model="form.alias" type="text" name="alias"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('alias') }">
                            <has-error :form="form" field="alias"></has-error>
                        </div>                    
                    </div>                           
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="!editMode" type="submit" class="btn btn-primary">Add Vendor to list</button>
                        <button v-show="editMode" type="submit" class="btn btn-primary">Edit Vendor info</button>
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
          items: {},
          specificItem: {},
          form: new Form({
              id: '',
              name: '',
              address: '',
              alias: '',
          })
        }
    },
    methods:{
      loadItem(){
          axios.get('http://127.0.0.1:8009/api/drugvendors')
          .then(({ data }) => (this.items = data.data) )
          .catch(e => console.log(e))
      },
            updateItem(){
               this.form.put('http://127.0.0.1:8009/api/drugvendors/'+this.form.id)
               .then(() => {
                    Swal.fire(
                    'Updated!',
                    'The drug vendor info has been updated.',
                    'success'
                    );
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
               })
               .catch(() => {
                   console.log("Somnething failed");
               })
            },
        editModal(item){
            this.editMode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(item);
        },
        newModal(){
            this.editMode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        createItem(){
            // this.$Progress.start();
            this.form.post('http://127.0.0.1:8009/api/drugvendors')
            .then(() => {
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')

                toast.fire({
                    icon: 'success',
                    title: 'Vendor Created successfully'
                })
            //     this.$Progress.finish();
            })
            .catch((error) =>{
                console.log(error);
            })
        },
        updateItem(){
            this.form.patch('http://127.0.0.1:8009/api/drugvendors/'+this.form.id)
            .then((data) => {
              console.log(data);
                Swal.fire(
                'Updated!',
                'The Vendor info has been updated.',
                'success'
                );
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide');
            })
            .catch((e) => {
                console.log(e);
            })
        },
        deleteItem(id){
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
                    this.form.delete('http://127.0.0.1:8009/api/drugvendors/'+id)
                    .then(()=>{
                            Swal.fire(
                            'Deleted!',
                            'The Vendor records have been deleted.',
                            'success'
                            );
                    Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        swal("Failed!", "Vendor not deleted, something went wrong.", "warning");
                    })
                    }
                })
        },

    },
        created(){
            Fire.$on('AfterCreate', () => {
                this.loadItem();
            });
           // setInterval(() => this.loadStaff(), 3000);
        },
        mounted() {
          this.loadItem()
            // console.log('Component mounted.')
        }
    }
</script>