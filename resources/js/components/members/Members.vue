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
                  <!--
                  <button type="button" class="btn btn-sm btn-primary" @click="/members/create">
                      <i class="fa fa-plus-square"></i>
                      Add New
                  </button>
                  -->
                </div>

                <div class="input-group">
                  <div class="input-group-btn search-panel">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span id="search_concept">お名前</span> 
                      </button>

                      <ul class="dropdown-menu" role="menu">
                          <li><a href="javascript:void(0)" @click="updateOption('name','お名前')">お名前</a></li>                   
                          <li><a href="javascript:void(0)" @click="updateOption('graduate','卒業期')">卒業期</a></li>
                          <li><a href="javascript:void(0)" @click="updateOption('email','メールアドレス')">メールアドレス</a></li>
                          <li><a href="javascript:void(0)" @click="updateOption('address','住所')">住所</a></li>
                          <li><a href="javascript:void(0)" @click="updateOption('phone','電話番号')">電話番号</a></li>
                          <li><a href="javascript:void(0)" @click="updateOption('club','部活動')">部活動</a></li>
                          <li><a href="javascript:void(0)" @click="updateOption('junior_high_school','出身中学')">出身中学</a></li>
                      </ul>
                  </div>
                  <input type="hidden" name="search_param" value="all" id="search_param">         
                  <input type="text" class="form-control" id="search_keyword" v-model="keyword" placeholder="Type content...">
                  <span class="input-group-btn">
                      <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                  </span>
                </div>
              </div>
              <!-- /.card-header -->
              
              <div>
                <member-list-view :members="members">
                </member-list-view>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
    </div>
  </section>

</template>
<script>
    import MemberListView from './MemberListView';

    export default {
      components: {
          MemberListView,
        },
        data () {
            return {
                members : {},
                current_page: 1,
                last_page: 1,
                total: 1,
                from: 0,
                to: 0,
                keyword: '',
                search_item: 'name',
            }
        },
        watch: {
          keyword: function (q) {
            this.keyword = q ;
            this.loadMembers() ;
          },
        },
        methods: {
          loadMembers(page = 1){
              var app = this;
              var url = '/api/member?page=' + page ;

              if (this.keyword != "") {
                  url = url + '&' + this.search_item + '=' + this.keyword;
              }
              axios.get(url).then(({ data }) => (this.members = data.data));
          },
          updateOption(option,text) {
              this.search_item = option;
              $('.search-panel span#search_concept').text(text);
              this.keyword = '';
              this.loadMembers();
          },
        },
        mounted() {
            
        },
        created() {
            this.$Progress.start();
            this.loadMembers();
            this.$Progress.finish();
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },
        computed: {
          filteredItems() {
            return this.autocompleteItems.filter(i => {
              return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
          },
        }
    }
</script>    
        
