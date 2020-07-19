<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Member List</h3>

                <div class="card-tools">
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

                        <a href="#" @click="editModal(member)">
                            <i class="fa fa-edit blue"></i>
                        </a>

                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            
              
              <div class="card-footer">
                <div style="margin-top: 40px" class="col-sm-6 text-right">全 {{total}} 件中 {{from}} 〜 {{to}} 件表示</div>
                <pagination :data="members" :limit=2 @pagination-change-page="loadMembers"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <p>{{ form.graduate }}期</p>
                    <h1>{{ form.last_name_kanji }} {{ form.first_name_kanji }}</h1>
                    <p class="lead">{{ form.last_name_kana }} {{ form.first_name_kana }}</p>
                </div>

                <form @submit.prevent="updateMember()">
                    <div class="modal-body">
                        <div class="form-group">

                            <label>支払方法</label>
<!--
                            <select class="form-control" v-model="form.category_id">
                              <option 
                                  v-for="(cat,index) in categories" :key="index"
                                  :value="index"
                                  :selected="index == form.category_id">{{ cat }}</option>
                            </select>
                      -->
                            <select v-model="form.payment" class="form-control" x-autocompletetype="region">
                                <option value="B">銀行振込</option>
                                <option value="A">郵便振替</option>
                                <option value="G">現金</option>
                                <option value="O">オンライン</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>


    </div>
  </section>
</template>

<script>
  import VueMemberList from '../members/Members.vue';

  export default {
    mixins: [VueMemberList],
    components: {
      VueMemberList,
    },
    data () {
      return {
        editmode: false,
        form: new Form({
          id                : '',
          graduate          : '',
          last_name_kana    : '',
          first_name_kana   : '',
          last_name_kanji   : '',
          first_name_kanji  : '',
          email : '',
          annual_fee : '',
          payment : '',
        }),
      }
    },
    methods: {
      editModal(member){
          this.editmode = true;
          this.form.reset();
          $('#addNew').modal('show');
          this.form.fill(member);
      },
      updateMember(){
          this.$Progress.start();
          this.form.annual_fee = '2020' + this.form.payment ;
          this.form.put('/api/member/'+this.form.id)
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
      toggleMenu() {
        this.showMenu = !this.showMenu;
      },
    },
  }
</script>
