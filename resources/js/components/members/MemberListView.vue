<template>
  <div class="component">
    <section class="content">
      <div class="container-fluid">
          <div class="row">

            <div class="col-12">
              <div class="card">

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
                        <th v-if="isShownAddress">爺便番号</th>
                        <th v-if="isShownAddress">住所</th>
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

                        <td v-if="isShownAddress">{{member.zipcode}}</td>
                        <td v-if="isShownAddress">{{member.address1}}{{member.address2}}{{member.address3}}</td>

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
  </div>
</template>

<script>
    import VueTagsInput from '@johmun/vue-tags-input';

    export default {
      name : 'VueMemberList',
      components: {
        VueTagsInput,
      },
      props: {
        members: {
          type: Object,
          default: {}
        },
        isShownAddress: {
          type: Boolean,
          default : false
        }
      },
      data () {
        return {
          keyword: '',
          search_item: 'name',

          total: 1,
          from: 0,
          to: 0,
        }
      },
      watch: {
        keyword: function (q) {
        },
      },

      methods: {
        loadMembers(page = 1){
        },
      },
    }
</script>
