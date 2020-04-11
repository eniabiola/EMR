<template>
    <div class="container">
         <div class="row">
          <div class="col-md-12 mt-3">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Patients' records</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Gender</th>
                      <th>Age</th>
                      <th>Address</th>
                      <th>Mobile No</th>
                      <th>Next of kin</th>
                      <th>Next of Kin Address</th>
                      <th>Next of Kin Mobile</th>
                      <th>Registration type</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1.</td>
                      <td>Awosanya Enitan</td>
                      <td>
                        Male
                      </td>
                      <td>12, Fadeke Oyenusi, Ipakodo, Ikorodu, Lagos State.</td>
                      <td>26</td>
                      <td>08162018742</td>
                      <td>Ms Awosanya Bolaji</td>
                      <td>71, Felele Straight, Ibadan. Oyo State.</td>
                      <td>08162018742</td>
                      <td>Individual</td>
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
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
