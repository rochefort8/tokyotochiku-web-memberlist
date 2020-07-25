<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <div class="input-group">
                  <label class="control-label"><a href="javascript:void(0)" @click="toggleSearchKind()">{{ search_kind_string }} </a></label>    
                </div>

                <div v-if="is_search_kind_free">
                    <input v-model="keyword" type="text" class="form-control" id="search_keyword" placeholder="Type content...">
                </div>
                <div v-else>

                  <!-- 卒業期 -->
                  <div class="form-group col-xs-12 has-feedback">
                      <label for="graduate" class="control-label">卒業期</label>
                      <select v-model="graduate" class="form-control" x-autocompletetype="region">
                          <option value="" selected="selected">-- 卒業期 --</option>
                          <option v-for="graduate in graduates" v-bind:value="graduate.value">
                              {{ graduate.value }}期({{ graduate.string }})
                          </option>
                      </select>
                  </div>

                  <!--　お名前 -->
                  <div class="col-xs-12 form-group">
                    <label class="control-label">お名前（漢字）</label>    
                    <input v-model="name "type="text" class="form-control" name="name" placeholder="" x-autocompletetype="surname" required>
                  </div>  

                  <!--　メールアドレス -->
                  <div class="col-xs-12 form-group">
                      <label for="email" class="control-label">メールアドレス</label>
                      <input v-model="email" type="email" class="form-control alphabet" name="email" placeholder="yoki-kana@tochiku.com" pattern="^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$" x-autocompletetype="email" required>
                  </div>

                  <!--　フリー -->
                  <div class="col-xs-12 form-group">
                    <div class="input-group-btn search-panel">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span id="search_concept">お名前</span> 
                        </button>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:void(0)" @click="updateOption('email','メールアドレス')">メールアドレス</a></li>
                            <li><a href="javascript:void(0)" @click="updateOption('address','住所')">住所</a></li>
                            <li><a href="javascript:void(0)" @click="updateOption('phone','電話番号')">電話番号</a></li>
                            <li><a href="javascript:void(0)" @click="updateOption('club','部活動')">部活動</a></li>
                            <li><a href="javascript:void(0)" @click="updateOption('junior_high_school','出身中学')">出身中学</a></li>
                        </ul>
                    </div>
                    <input v-model="free" type="free" class="form-control alphabet" name="free" placeholder="" pattern="^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$" x-autocompletetype="email" required>
                  </div>
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
                graduates : [],
                search_kind_string : 'フリー検索',
                is_search_kind_free : true,
            }
        },
        watch: {
          keyword: function (q) {
            this.keyword = q ;
            this.search_item='free';
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
          toggleSearchKind() {
              if (this.is_search_kind_free == true) {
                this.is_search_kind_free = false ;
                this.search_kind_string = '詳細検索' ;
              } else {
                this.is_search_kind_free = true ;
                this.search_kind_string = 'フリー検索' ;
              }
          },
          createGraduateTable: function() {
              var _year = 1942 ;
              var max_year = new Date().getFullYear();

              for (;_year <= max_year;_year++) {
                  var _graduate = _year - 1902 ;
                  var _gengo = '' ;

                  if (_year <= 1988) {
                      _gengo = '昭和' + String(_year - 1925) + '年';
                  } else
                  if (_year <= 2018) {
                      _gengo = '平成' + String(_year - 1988) + '年';
                  } else {
                      _gengo = '令和' + String(_year - 2018) + '年';
                  }
                  this.graduates.push({ value : String(_graduate),
                                      string : String(_year) + '年/' + _gengo + '卒' });
              }
          },
        },
        mounted() {
            
        },
        created() {
            this.createGraduateTable();
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
