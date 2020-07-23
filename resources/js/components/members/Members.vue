<template>
 <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Member List</h3>

                <div class="card-tools">
                  <router-link to="/members/removed" class="btn btn-default">削除一覧</router-link>                  
                  <router-link to="/members/create/multiple" class="btn btn-default">一括登録</router-link>                  
                  <router-link to="/members/create" class="btn btn-default">新規登録</router-link>
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
  import MemberList from './MemberList';

  export default {
    components: {
      MemberList,
    },
  }
</script>    
        
