<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
              <!--
                <h1 class="card-title">{{this.fiscal_year}}年度期別納入者数</h1>
              -->
                <h1>{{this.fiscal_year}}年度年会費支払者リスト</h1>

                <div class="card-tools">
                  
                  <router-link to="/annualfee" class="btn btn-default">納入者リスト</router-link>
                  <button type="button" class="btn btn-sm btn-primary" @click="exportData">
                      <i class="fa fa-plus-square"></i>
                      Excel
                  </button>
                </div>

                <div class="input-group">
                  <div class="input-group-btn search-panel">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span id="search_concept">お名前</span> 
                      </button>

                      <ul class="dropdown-menu" role="menu">
                          <li><a href="javascript:void(0)" @click="updateOption('2020','2020')">2020年</a></li>                   
                          <li><a href="javascript:void(0)" @click="updateOption('2019','2019')">2019年</a></li>
                          <li><a href="javascript:void(0)" @click="updateOption('2018','2018')">2018年</a></li>
                          <li><a href="javascript:void(0)" @click="updateOption('2017','2017')">2017年</a></li>
                          <li><a href="javascript:void(0)" @click="updateOption('2016','2016')">2016年</a></li>
                      </ul>
                  </div>
              </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>卒業期</th>
                      <th>会員数</th>
                      <th>ゆうちょ</th>
                      <th>銀行</th>
                      <th>自動</th>
                      <th>現金</th>
                      <th>当日現金</th>
                      <th>オンライン</th>
                      <th>合計</th>
                      <th>操作</th>
                  </tr>

                  </thead>
                  <tbody>
                     <tr v-for="member in members.data" :key="member.id">

                      <td>{{member.graduate}}</td>
                      <td>{{member.total_count}}</td>
                      <td>{{member.post}}</td>
                      <td>{{member.bank}}</td>
                      <td>{{member.bank_auto}}</td>
                      <td>{{member.cash}}</td>
                      <td>{{member.cash_konshinkai}}</td>
                      <td>{{member.online}}</td>
                      <td>{{member.sum}}</td>

                      <!-- <td><img v-bind:src="'/' + member.photo" width="100" alt="member"></td> -->
                      <td>
                        <router-link :to="{path: 'members/view', query: {id: member.id}}"> 
                          <i class="fa fa-eye green"></i>
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
                fiscal_year: '',

                categories: [],
              
                tag:  '',
                autocompleteItems: [],
            }
        },
        watch: {
          keyword: function (q) {
            this.keyword = q ;
            this.loadMembers();
          }
        },
        methods: {
          loadMembers(page = 1){

              var app = this;
              var url = '/api/annualfee?page=' + page ;
              url = url + '&' + 'annual_fee=' + this.fiscal_year;
              if (this.keyword != "") {
                  url = url + '&' + this.search_item + '=' + this.keyword;
              }
              this.$Progress.start();
              axios.get(url).then(({ data }) => (this.members = data.data));
              this.$Progress.finish();
          },
          async exportData(){

              var _url = '/api/annualfee/export' ;
              this.$Progress.start();
              /*
              try {
                const res = await axios.get(_url);
                if(res.status === 200){
                  window.location = res.request.responseURL
                } else {
                // ダウンロード失敗のメッセージって何の飾り気のないalertでも許してもらえる気がする
                  alert("downloadに失敗しました")
                }
              } catch(e) {
                alert("downloadに失敗しました")
              }
              */
            axios({
                url: _url,
                method: 'GET',
                responseType: 'blob',
            }).then((response) => {
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement('a');

                fileLink.href = fileURL;
                fileLink.setAttribute('download', 'file.xlsx');
                document.body.appendChild(fileLink);

                fileLink.click();
            });              
//              axios.get(url).then(({ data }) => (this.members = data.data));
              this.$Progress.finish();
          },

            getCurrentFiscalYear() {
              var today = new Date();
              var fiscal_year = today.getFullYear() ;
              if ((today.getMonth() + 1) <= 3) {
                fiscalyear = today.getFullYear() -1 ;
              } 
              this.fiscal_year = fiscal_year ;
            },
            updateOption(option,text) {
                this.fiscal_year = option;
                
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
            this.getCurrentFiscalYear();

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
