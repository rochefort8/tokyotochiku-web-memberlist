<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

            <div class="col-12">
            
                <div class="card">
                
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <div class="card-header">
                        <h1>編集</h1>
                    </div>

                    <form @submit.prevent="saveForm()">

                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>お名前(漢字)</th>
                                    <td>{{ member.last_name_kanji }} {{ member.first_name_kanji }}</td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <th>お名前(カナ)</th>
                                    <td>{{ member.last_name_kana }} {{ member.first_name_kana }}</td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <th>卒業期</th>
                                    <td>{{ member.graduate }}期</td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <th>住所</th>
                                    <td>{{ member.postcode }}<br>{{ member.address }}</td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <th>メールアドレス</th>
                                    <td>
                                        <div v-if="show">{{ member.email }}</div>
                                        <div v-else><input type="text" v-model="member.email" class="form-control"></div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-xs btn-default" @click="show = !show"><i class="glyphicon glyphicon-pencil"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>電話番号1</th>
                                    <td>{{ member.phone1 }}</td>
                                    <td>
                                        <button type="button" class="btn btn-xs btn-default"  @click="show = !show"><i class="glyphicon glyphicon-pencil"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>電話番号2</th>
                                    <td>{{ member.phone2 }}</td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <th>出身中学</th>
                                    <td>{{ member.junior_high_school }}</td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <th>部活動</th>
                                    <td>{{ member.club }}</td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <th>夫婦</th>
                                    <td>{{ member.couple }}</td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ member.id }}</td>
                                    <td>
                                    </td>
                                </tr>

                                <tr>
                                    <th>期別幹事</th>
                                    <td>{{ member.representative }}</td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <th>備考</th>
                                    <td>{{ member.remarks }}</td>
                                    <td>
                                    </td>
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
                <!-- /.card -->
            </div>
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
                }
            }
        },
        methods: {
            saveForm() {
                var app = this;
                var newMember = app.member;
                axios.put('/api/member/' + this.member.id, this.member)
                    .then(function (resp) {
                        app.$router.replace('/members');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your member");
                    });
            }
        }
    }
</script>