<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Member List</h3>

                <div class="card-tools">
                  
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
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>卒業期</th>
                      <th>お名前</th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th>性別</th>
                      <th>操作</th>
                  </tr>

                  </thead>
                  <tbody>
                     <tr v-for="member in members.data" :key="member.id">

                      <td>{{member.id}}</td>
                      <td>{{member.graduate}}</td>
                      <td>{{member.last_name_kanji}}</td>
                      <td>{{member.first_name_kanji}}</td>
                      <td>{{member.last_name_kana}}</td>
                      <td>{{member.first_name_kana}}</td>
                      <td>{{member.gender}}</td>

                      <!-- <td><img v-bind:src="'/' + member.photo" width="100" alt="member"></td> -->
                      <td>
                        <router-link :to="{path: 'members/view', query: {id: member.id}}"> 
                          <i class="fa fa-eye green"></i>
                        </router-link>

                        <router-link :to="{path: 'members/edit', query: {id: member.id}}"> 
                          <i class="fa fa-edit blue"></i>
                        </router-link>

                        <router-link :to="{path: 'members/delete', query: {id: member.id}}"> 
                          <i class="fa fa-trash red"></i>
                        </router-link>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            
              
              <div class="card-footer">
                <div style="margin-top: 40px" class="col-sm-6 text-right">全 {{total}} 件中 {{from}} 〜 {{to}} 件表示</div>
                <pagination :data="members" :limit=2 @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
    </div>
  </section>
</template>

<script>
    import VueTagsInput from '@johmun/vue-tags-input';

    export default {
      components: {
          VueTagsInput,
        },
        data () {
            return {
                editmode: false,
                members : {},
                current_page: 1,
                last_page: 1,
                total: 1,
                from: 0,
                to: 0,
                keyword: '',
                search_item: 'name',

                form: new Form({
                    id : '',
                    category : '',
                    name: '',
                    description: '',
                    tags:  [],
                    photo: '',
                    category_id: '',
                    price: '',
                    photoUrl: '',
                }),
                categories: [],
              
                tag:  '',
                autocompleteItems: [],
            }
        },
        watch: {
          keyword: function (q) {
            var app = this;
            axios.get('/api/member?' + this.search_item + '=' + q)
              .then(({ data }) => (this.members = data.data));	   
          },
        },
        methods: {

          getResults(page = 1) {
              var app = this;
              var url = '/api/member?page=' + page ;

              if (this.keyword != "") {
                  url = url + '&' + this.search_item + '=' + this.keyword;
              }

              this.$Progress.start();
              axios.get(url).then(({ data }) => (this.members = data.data));


              this.$Progress.finish();
          },
          loadMembers(){

              if (this.keyword != "") {
                  url = url + '&' + this.search_item + '=' + this.keyword;
              }
            // if(this.$gate.isAdmin()){
              axios.get("/api/member").then(({ data }) => (this.members = data.data));
            // }
          },
          loadCategories(){
              axios.get("/api/category/list").then(({ data }) => (this.categories = data.data));
          },
          loadTags(){
              axios.get("/api/tag/list").then(response => {
                  this.autocompleteItems = response.data.data.map(a => {
                      return { text: a.name, id: a.id };
                  });
              }).catch(() => console.warn('Oh. Something went wrong'));
          },
          editModal(member){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(member);
          },
          createMember(){
              this.$Progress.start();

              this.form.post('api/member')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadMembers();

                } else {
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });

                  this.$Progress.failed();
                }
              })
              .catch(()=>{

                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              })
          },
          updatemember(){
              this.$Progress.start();
              this.form.put('api/member/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadMembers();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

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
            updateOption(option,text) {
                this.search_item = option;
                $('.search-panel span#search_concept').text(text);
                this.keyword = '';
                this.loadMembers();
            },
            toggleMenu() {
              this.showMenu = !this.showMenu;
            },
        },
        mounted() {
            
        },
        created() {
            this.$Progress.start();

            this.loadMembers();
            this.loadCategories();
            this.loadTags();

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
