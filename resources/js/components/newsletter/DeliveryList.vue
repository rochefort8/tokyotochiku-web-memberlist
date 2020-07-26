<template>
 <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Member List</h3>

                <div class="card-tools">                  
                  <router-link to="/newsletter/undelivered" class="btn btn-default">不着一覧</router-link>
                </div>
              </div>

              <member-list
                :showNewsletterReceivers="true">
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
          removeFromList(member){
              Swal.fire({
                  title: 'このメンバを会報不着者リストに追加しますか ?',
                  text: member.first_name_kanji,
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {

                      // Send request to the server
                        if (result.value) {
                            member.newsletter_undelivered = 'Y';
                              axios.put('/api/newsletter/' + member.id,member).then(()=>{
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
