<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

            <div class="col-12">
            
                <div class="card">
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <div class="card-header">
                        <h1>{{this.fiscal_year}}名簿より削除</h1>

                        <p>{{ member.graduate }}期</p>
                        <h1>{{ member.last_name_kanji }} {{ member.first_name_kanji }}</h1>
                        <p class="lead">{{ member.last_name_kana }} {{ member.first_name_kana }}</p>
                    </div>
                    <form @submit.prevent="saveForm()">


                        <!--　削除理由 -->
                        <div class="col-xs-12 form-group">
                            <label for="removed" class="control-label">削除理由</label>           
                            <select v-model="member.removed" options="items" class="form-control" x-autocompletetype="region" required>
                                <option value="" selected="selected">-- 削除理由 --</option>
                                <option v-for="reason in reasons">
                                    {{ reason }}
                                </option>
                            </select>
                        </div>

                        <table class="table">
                            <tbody>

                                <tr>
                                    <th>住所</th>
                                    <td>{{ member.zipcode }}<br>{{ member.address }}</td>
                                </tr>
                                <tr>
                                    <th>メールアドレス</th>
                                    <td>{{ member.email }}</td>
                                </tr>
                                <tr>
                                    <th>電話番号1</th>
                                    <td>{{ member.phone1 }}</td>
                                </tr>
                                <tr>
                                    <th>電話番号2</th>
                                    <td>{{ member.phone2 }}</td>
                                </tr>
                                <tr>
                                    <th>出身中学</th>
                                    <td>{{ member.junior_high_school }}</td>
                                </tr>
                                <tr>
                                    <th>部活動</th>
                                    <td>{{ member.club }}</td>
                                </tr>
                                <tr>
                                    <th>夫婦</th>
                                    <td>{{ member.couple }}</td>
                                </tr>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ member.id }}</td>
                                </tr>

                                <tr>
                                    <th>期別幹事</th>
                                    <td>{{ member.representative }}</td>
                                </tr>
                                <tr>
                                    <th>備考</th>
                                    <td>{{ member.remarks }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">Delete</button>
                        </div>
                    </form>

                </div>
                <!-- /.card-body -->
                            
                <div class="card-footer">

                </div>
                </div>
                <!-- /.card -->
            </div>
            </div>
        </div>
    </section>

</template>
<script>
    export default {
        mounted() {
            
        },
        created() {
            let app = this;
            let id = app.$route.query.id;

            axios.get("/api/member?id=" + id).then(response => {
                app.member = response.data.data.data[0];
            }).catch(() => console.warn('Oh. Something went wrong'));
        },
        data: function () {
            return {
                memberId: null,
                member: {
                    name: '',
                    address: '',
                    website: '',
                    email: '',
                },
                reasons : [
                    '本人希望','ご逝去','その他',
                ],
            }
        },
        methods: {
            saveForm() {
 
                var app = this;
                var newMember = this.member;

                axios.put('/api/member/' + this.member.id,this.member)

//                axios.delete('/api/member/' + this.member.id)

                .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();

                } else {
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again..'
                  });

                }
              })
              .catch(()=>{

                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              })
            }
        }
    }
</script>
