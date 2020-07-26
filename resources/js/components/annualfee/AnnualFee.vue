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

              <member-list
                :showAnnualFeePayers="true"
                :fiscalYear=fiscal_year
                :operations="operations">
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
      data () {
        return {
          fiscal_year: '',
          operations: [
              {
                path: '/members/view',
                query:'id: member.id',
                icon: 'fa fa-eye green',
              },
              {
                path: '/members/delete',                   
                query:'id: member.id',
                icon: 'fa fa-trash red',
              },
          ],
        }
      },
        methods: {
          getCurrentFiscalYear() {
            var today = new Date();
            var fiscal_year = today.getFullYear() ;
            if ((today.getMonth() + 1) <= 3) {
              fiscalyear = today.getFullYear() -1 ;
            } 
            this.fiscal_year = fiscal_year ;
          },

          removeFromList(member){
              Swal.fire({
                  title: 'Are you sure ?',
                  text: member.first_name_kanji,
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {

                      // Send request to the server
                        if (result.value) {
                            member.annual_fee = '';
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
        },
        created() {
            this.getCurrentFiscalYear();
        },
    }
</script>
