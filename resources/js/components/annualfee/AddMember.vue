<template>
 <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Member List</h3>

                <div class="card-tools">                  
                  <router-link to="/annualfee/count" class="btn btn-default">期別納入者数</router-link>
                  <router-link to="/annualfee/add" class="btn btn-default">新規登録</router-link>
                </div>
              </div>

              <member-list>
              </member-list> 

            </div>
            <!-- /.card -->

          </div>
        </div>
    </div>
  </section>
</template>

<script>
    import MemberList from '../members/MemberList';

    export default {
      components: {
          MemberList,
        },

        methods: {
          deleteMember(id){
              Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {

                      // Send request to the server
                        if (result.value) {
                              this.form.delete('api/member/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadMembers();
                              }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                        }
                  })
          },
        },
    }
</script>
