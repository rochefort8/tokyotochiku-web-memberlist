<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
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
                      <th v-if="showNewsletterReceivers">爺便番号</th>
                      <th v-if="showNewsletterReceivers">住所</th>

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
                      <td v-if="showNewsletterReceivers">{{member.zipcode}}</td>
                      <td v-if="showNewsletterReceivers">{{member.address1}}{{member.address2}}{{member.address3}}</td>


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
                <pagination :data="members" :limit=2 @pagination-change-page="loadMembers"></pagination>
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
      name : 'MemberList',
      components: {
          VueTagsInput,
        },
      props: {
        showRemovedMembers: {
          type: Boolean,
          default : false
        },
        showAnnualFeePayers: {
          type: Boolean,
          default : false
        },
        showNewsletterReceivers: {
          type: Boolean,
          default : false
        },
        showNewsletterUndelivered: {
          type: Boolean,
          default : false
        },
        fiscalYear: {
          type: Number,
          default : 2020
        },
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

              if (this.showNewsletterReceivers == true) {
                url = '/api/newsletter?page=' + page ;
              }
              if (this.showRemovedMembers == true) {
                  url = url + '&removed=true' ;
              }
              if (this.showAnnualFeePayers == true) {
                  url = url + '&annual_fee=' + this.fiscalYear ;
              }
              if (this.showNewsletterUndelivered== true) {
                  url = url + '&undelivered=true' ;
              }
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
