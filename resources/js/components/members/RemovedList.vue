<template>
 <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Member List</h3>

                <div class="card-tools">
                  <router-link to="/members" class="btn btn-default">一覧</router-link>                  
                </div>
              </div>

              <member-list
                :showRemovedMembers="true"
                :operations="operations"
                @doOperationHandler="doOperationHandler"
              >
              </member-list> 

            </div>
            <!-- /.card -->

          </div>
        </div>
    </div>
  </section>
</template>

<script>
    import MemberList from './MemberList';

    export default {
      components: {
          MemberList,
        },
      data () {
        return {
          operations: [
              {
                path: '/members/view',
                query:'id: member.id',
                icon: 'fa fa-eye green',
              },
              {
                path: '',                   
                query:'id: member.id',
                icon: 'fa fa-trash red',
              },
          ],
        }
      },

        methods: {          
          doOperationHandler(id,member) {
            if (id == 1) {
              this.deleteMember(member.id);
            }
          },
          activateMember(member){
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
                            member.removed = '';
                            axios.put('/api/member/' + member.id,member).then(()=>{
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
                              axios.delete('/api/member/'+id).then(()=>{
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
