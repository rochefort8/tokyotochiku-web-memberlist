<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

            <div class="col-12">
            
                <div class="card">
                
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <div class="card-header">
                        <p>{{ member.graduate }}期</p>
                        <h1>{{ member.last_name_kanji }} {{ member.first_name_kanji }}</h1>
                        <p class="lead">{{ member.last_name_kana }} {{ member.first_name_kana }}</p>
                    </div>
                    <form @submit.prevent="saveForm()">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>住所</th>
                                    <td>{{ member.postcode }}<br>{{ member.address }}</td>
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
                            <router-link to="/members" class="btn btn-default">戻る</router-link>
                            <router-link :to="{path: '/members/edit', query: {id: member.id}}"　class="btn btn-default">編集</router-link>
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
                axios.patch('/api/v1/members/' + app.memberId, newMember)
                    .then(function (resp) {
                        app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your member");
                    });
            }
        }
    }
</script>
